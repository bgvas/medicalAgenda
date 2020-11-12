
function passwordValidator(){
    var password = document.getElementById("password");
    
    if(password == "a"){
        document.getElementById("username").innerHTML = "Hello World";
    }
    else document.getElementById("username").innerHTML = "";
}

function errorLogin(){
    const url = window.location.search;
    if(url.includes("errorlogin")){
       document.getElementById("error").innerHTML = "Error Username or Password!!!";
    }
    if(url.includes("usernotfound")){
        document.getElementById("error").innerHTML = "Can't find user!!!";
    }
    if(url.includes("errorEmail")){
        document.getElementById("error").innerHTML = "There is no user with this Email address";
    }
}

function resendEmail(email, token){
    php.call(SendForgotPasswordEmail(email, token));
}


