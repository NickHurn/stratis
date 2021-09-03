

$(document).on("submit", "#shareApplianctForm", function(){
    $('.shareButton').prop('disabled', true);
    $('.shareModalSpinner').show();
    var request = $.ajax({
        url: '/applicant/share',
        method: 'post',
        data: $(this).serialize()
    });
    request.done(function (data) {
        $('#applicantModal').modal('hide');
        location.reload();
    });
    return false;
});


$(document).on('submit', '#RejectApplicantForm', function(){
    $('.rejectApplicantSubmit').hide();
    $('.rejectModalSpinner').show();
    var ids = [];
    var userId = $('.rejectApplicantUserId').val();
    var jobId = $('.rejectApplicantJobId').val();
    var message = $('.rejectMessage').val();
    var toEmail = $('#bulkRejectsendEmail').is(':checked');
    ids.push({jobId:jobId, userId:userId, message:message, toEmail:toEmail});
    var jsondata = JSON.stringify(ids);
    var request = $.ajax({
        url: '/applicant/reject',
        type: 'POST',
        data: jsondata,
        async: false
    });
    request.done(function (msg) {
        if(msg === 'ok'){
            alert('The applicant(s) have been rejected and emailed if requested.');
            $('#applicantModal').modal('hide');
            location.reload();
        }
    });
    return false;
});



$(document).on('submit', '#acceptApplicantForm', function(){
    $('.acceptApplicantSubmit').hide();
    $('.acceptModalSpinner').show();

    var ids = [];
    var userId = $('.acceptApplicantUserId').val();
    var jobId = $('.acceptApplicantJobId').val();
    var message = $('.acceptMessage').val();
    var toEmail = $('#bulkAcceptsendEmail').is(':checked');
    ids.push({jobId:jobId, userId:userId, message:message, toEmail:toEmail});

    var jsondata = JSON.stringify(ids);
    var request = $.ajax({
        url: '/applicant/accept',
        type: 'POST',
        data: jsondata,
        async: false
    });

    request.done(function (msg) {
        if(msg === 'ok'){
            alert('The applicant(s) have been accepted and emailed if requested.');
            $('#applicantModal').modal('hide');
            location.reload();
        }
    });
    return false;
});


$('.shareApplicantNotes').click(function(){
    $('.applicantDetailsApplicantNotes').toggle();
});

$(document).on('click', '.watchlist', function(){
    var userId = $(this).data('id');
    var jobId = $(this).data('jobid');
    var employeeId = $(this).data('employeeid');
    var request = $.ajax({
        url: '/applicant/watch/add',
        type: 'GET',
        data: { userid:userId, jobid:jobId, employerid:employeeId },
});
    request.done(function (msg) {
        var watched = JSON.parse(msg);
        if(watched.id >= 1){
            alert('The applicant(s) have been added to the watch list.');
        }
        location.reload();
    });
    return false;
});

$(document).on('click', '.removewatchlist', function(){
    var userId = $(this).data('id');
    var jobId = $(this).data('jobid');
    var employeeId = $(this).data('employeeid');
    var request = $.ajax({
        url: '/applicant/watch/remove',
        type: 'GET',
        data: { userid:userId, jobid:jobId, employerid:employeeId },
});
    request.done(function (msg) {
        if(msg === 'ok'){
            alert('The applicant(s) have been removed from the watch list.');
        }
        location.reload();
    });
    return false;
});

$('.shareApplicantNotes').click(function(){
    $('.applicantModal').toggle();
});

$(document).on('click', '.extraChecksSubmit', function(){
    $('#applicantModal').modal('hide');
    var request = $.ajax({
        url: '/applicant/extracheckssubmit',
        type: 'GET',
        data: $('form#extraChecksForm').serialize()
    });
    request.done(function (data) {
        if( data.status == 'ok'){
            alert('The applicant(s) have been emailed.');
            location.reload(true);
        }

    });

    return false;
});
