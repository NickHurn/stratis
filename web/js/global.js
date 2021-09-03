$( document ).ready(function() {
    buttoncheck();
});

$(window).resize(function() {
    buttoncheck();
});

function buttoncheck(){
    width = $(this).width();
    height = $(this).height();
    var logindiv = $( '#login-div' );
    if(width > 736){
        $( '#login-button' ).addClass('btn-yellow').removeClass('btn-black');
        logindiv.addClass('col-lg-3').removeClass('col-lg-4');
        logindiv.addClass( "dashboard" );
        $( '#welcome' ).show();

    } else {
        $( '#login-button' ).addClass('btn-black').removeClass('btn-yellow');
        logindiv.addClass('col-lg-4').removeClass('col-lg-4');
        logindiv.removeClass( "dashboard" );
        $( '#welcome' ).hide();
    }
}


