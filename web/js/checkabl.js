function verifyEmail(){

   var btn = $('button#requestemail');
    btn.val('Please wait ...')
        .attr('disabled','disabled');


    $.ajax({
        method: "POST",
        url: "/checkabl/verifyemail"

    })
        .done(function( msg ) {
            if(msg == 'Success'){
                window.location.replace('/checkabl');
            } else {
                $( "#codeerror" ).remove();
                $( "<ul class='alert alert-danger' id='codeerror'><li>" + msg + "</li></ul>" ).insertAfter( "#buttoncode" );
            }
        });
}

function verifySms(){

    var btn = $('button#requestsms');
    btn.val('Please wait ...')
        .attr('disabled','disabled');
    $.ajax({
        method: "POST",
        url: "/checkabl/verifysms"

    })
        .done(function( msg ) {
            if(msg == 'Success'){
                window.location.replace('/checkabl');
            } else {
                $( "#smscodeerror" ).remove();
                $( "<ul class='alert alert-danger' id='smscodeerror'><li>We were unable to send a message.  Please check you mobile number is correct.  If it is not correct you may change it <a href='/user/' />here</a>.</li></ul>" ).insertAfter( "#smsbuttoncode" );
            }
        });
}

function verifyBank(){

    var sortcode = $('#sortcode').val();
    var account = $('#bankaccount').val();
    $.ajax({
            method: "GET",
            url: "/checkabl/verifybank",
            data: { account : account, sortcode: sortcode }
        })
        .done(function( msg ) {
            console.log(msg);
            if(msg == 'Success'){
                window.location.replace('/checkabl');
            } else {
                $( "#bankcodeerror" ).remove();
                $( "<ul class='alert alert-danger' id='bankcodeerror'><li>" + msg + "</li></ul>" ).insertAfter( "#bankp" );
            }
        });
}

function verifyCode(){

    var btn = $('button#verifyemail');
    btn.val('Please wait ...')
        .attr('disabled','disabled');
    code = $('#code').val();

    $.ajax({
        method: "POST",
        url: "/checkabl/verifycode",
        data: { code: code }

    })
        .done(function( msg ) {
            if(msg == 'valid'){
                window.location.replace('/checkabl');
            } else {
                $( "#verify-error").empty();
                $( ".verification-error").show();

                $( "#verify-error").append(  "The Email Code you entered is Invalid." );
            }
        });
}

function verifySmsCode(){

    var btn = $('button#verifysms');
    btn.val('Please wait ...')
        .attr('disabled','disabled');
    code = $('#smscode').val();

    $.ajax({
        method: "POST",
        url: "/checkabl/verifySmscode",
        data: { code: code }

    })
        .done(function( msg ) {
            if(msg == 'valid'){
                window.location.replace('/checkabl');
            } else {
                $( "#verify-error").empty();
                $( ".verification-error").show();

                $( "#verify-error").append(  "The SMS Code you entered is Invalid." );
            }
        });
}