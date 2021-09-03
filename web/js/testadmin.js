$(function() {
    $( "#sortable1, #sortable2, #sortable3" ).sortable({
        connectWith: ".connectedSortable",
        receive: function( event, ui ) {}
    }).disableSelection();

    $( "#sortable1" ).on( "sortreceive", function( event, ui ) {
        var linkid = $(ui.item).attr('id');
        var jobid = $('#jobid').val();
        var type = $(ui.item).attr('type');
        var item = $('li#'+linkid);
        $.ajax({
            method: "POST",
            url: "/testadmin/addtest",
            data: { link_id: linkid,
                job_id: jobid,
                type: type
            }
        }).done(function( msg ) {
            $( item ).append( '<i class="fa fa-check pull-right" style="color:#a3cd39" aria-hidden="true"></i>' );

        });
    } );

    $( "#sortable2" ).on( "sortreceive", function( event, ui ) {
        var linkid = $(ui.item).attr('id');
        var jobid = $('#jobid').val();
        var type = $(ui.item).attr('type');
        var item = $('li#'+linkid);
        $.ajax({
            method: "POST",
            url: "/testadmin/removetest",
            data: { link_id: linkid,
                job_id: jobid,
                type: type
            }
        })
            .done(function( msg ) {
                $( item ).children( "i" ).remove();
            });
    } );

   
});


