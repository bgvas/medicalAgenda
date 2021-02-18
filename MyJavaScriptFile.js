
function passwordValidation(){
    var password = document.getElementById("pass").value;
    var messages = null;

    if (password.length < 6) {
        messages = "<span style='color:Red;'>Must have at last 6 chars</span>";
    } 
    else if (password.search(/\d/) == -1) {
        messages = "<span style='color:Red;'>Must have at last 1 number</span>";
    } 
    else if (password.search(/[A-Z]/) == -1) {
        messages = "<span style='color:Red;'>Must have at last 1 capital letter</span>";
    } 
    else if (password.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+\.\,\;\:]/) != -1) {
        messages = "<span style='color:Red;'>Invalid character</span>";
    }
    else messages = "<span style='color:Green;'>Your password is valid</span>";

    document.getElementById("passwordvalidator").innerHTML = messages;
}

function Responses(){
    var url = window.location.search;
    if(url.includes("errorlogin")){
       document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>Error Username or Password!!!</h2></span>";
    }
    if(url.includes("usernotfound")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>Can't find user!!!</h2></span>";
    }
    if(url.includes("errorEmail")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>There is no user with this Email address</h2></span>";
    }
    if(url.includes("updated")){
        document.getElementById("messages").innerHTML = "<span style='color:DarkBlue'><h2>Password updated!</h2></span>";
    }
    if(url.includes("userexists")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'></h2>This email address already exists.</h2></span>";
    }
    if(url.includes("emptyfields")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>You have some empty fields</h2></span>";
    }
    if(url.includes("errorProcess")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>Error processing. Try again</h2></span>";
    }
    if(url.includes("registrationerror")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>Error while sending registration email. Try again</h2></span>";
    }
    if(url.includes("usercreated")){
        document.getElementById("messages").innerHTML = "<span style='color:Blue'><h2>User created successful. Now Login to insert.</h2></span>";
    }
    if(url.includes("patientIdDoesNotExist")){
        document.getElementById("messages").innerHTML = "<span style='color:Red'><h2>There is no patient with this id. Ask your doctor.</h2></span>";
    }

}

function resendEmailMessage(result){
    if(result == false){
        document.getElementById("m").innerHTML = "<span style='color:Red';>Error while sending email. Try again</span>";
    }
}

function equality(){
    var password1 = document.getElementById("pass").value;
    var password2 = document.getElementById("re-pass").value;
    if(password1 === password2 && password1 != ""){
        document.getElementById("checkEquality").innerHTML = "<span style='color:Green;'>Passwords, are equal</span>";
        document.getElementById("sbutton").disabled = false; // submit button will stay inactive, until 2 passwords will be equal
    }
    else document.getElementById("checkEquality").innerHTML = "<span style='color:Red;'>Passwords, are not equal</span>";
}


function activateSelection(id){
    document.getElementById(id).style.color = 'white';
    document.getElementById(id).font-weight-bold;
}

function OddDiv(){
    document.getElementById(odd).style.backgroundColor = "Grey";
}

function isNumber(evt) {
   console.log("Hello");
}

function activateVisitor() {
    document.getElementById("patientId").disabled = false;
}
