function checkUsername(){

    var username = "";

    username = $('#username').val();

    $.ajax({
        method: "POST",
        url: "/register/userexists",
        data: { username: username }
    })
        .done(function( msg ) {
           if( msg == 'true'){
               $( "#usernameerror" ).remove();
               $( "<ul class='errors' id='usernameerror'><li>Username already exists</li></ul>" ).insertAfter( "#username" );
           } else {
               $( "#usernameerror" ).remove();
           }
        });
}

function checkEmail(){

    var email = "";

    email = $('#email').val();

    $.ajax({
        method: "POST",
        url: "/register/emailexists",
        data: { email: email }
    })
        .done(function( msg ) {
            if( msg == 'true'){
                $( "#emailerror" ).remove();
                $( "<ul class='errors' id='emailerror'><li>Email address already exists</li></ul>" ).insertAfter( "#email" );
            } else {
                $( "#emailerror" ).remove();
            }
        });
}