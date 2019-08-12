/*
* This script control if users enter proper values in register form and prevent to send if the inputs doesn't verify the conditions
*/

let register = document.getElementById("register");
let registrationPseudo = document.getElementById("registrationPseudo");
let registrationMail = document.getElementById("registrationMail");
let registrationPassword = document.getElementById("registrationPassword");
let registrationVerifPassword = document.getElementById("registrationVerifPassword");


let mailRegex = /^[a-z0-9.\._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/;


register.addEventListener("submit", function(e){
    if ((register.elements.pseudo.value.length === 0) || (!mailRegex.test(register.elements.mail.value)) ||  (register.elements.password.value.length < 8 || register.elements.password.value.length > 14) || (register.elements.password.value != register.elements.confirm_password.value)) {
        e.preventDefault();
        if (register.elements.pseudo.value.length === 0) {
            registrationPseudo.classList.add("list-group-item-danger", "font-weight-bold");
            registrationMail.classList.remove("list-group-item-danger","font-weight-bold");
            registrationPassword.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationVerifPassword.classList.remove("list-group-item-danger", "font-weight-bold");
        }
        else if(!mailRegex.test(register.elements.mail.value)) {
            registrationPseudo.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationMail.classList.add("list-group-item-danger","font-weight-bold");
            registrationPassword.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationVerifPassword.classList.remove("list-group-item-danger", "font-weight-bold");
        }
        else if (register.elements.password.value.length < 8 || register.elements.password.value.length > 14) {
            registrationPseudo.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationMail.classList.remove("list-group-item-danger","font-weight-bold");
            registrationPassword.classList.add("list-group-item-danger", "font-weight-bold");
            registrationVerifPassword.classList.remove("list-group-item-danger", "font-weight-bold");
        }
        else if (register.elements.password.value != register.elements.confirm_password.value) {
            registrationPseudo.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationMail.classList.remove("list-group-item-danger","font-weight-bold");
            registrationPassword.classList.remove("list-group-item-danger", "font-weight-bold");
            registrationVerifPassword.classList.add("list-group-item-danger", "font-weight-bold");
        }
    }
});
