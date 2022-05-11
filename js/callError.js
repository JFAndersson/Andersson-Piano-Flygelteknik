function errorLogin(){
    document.getElementById("errorPhraseLogin").style.visibility = "visible";
    document.getElementById("errorPhraseLogin").innerHTML = "Incorrect username and/or password!"
}

function errorRegister(){
    document.getElementById("errorPhraseRegister").style.visibility = "visible";
    document.getElementById("errorPhraseRegister").innerHTML = "Could not prepare statement!"
}