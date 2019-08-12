/*
* This script control if users enter proper values in update forms and prevent to send if the inputs doesn't verify the conditions
*/


let mailUpdate = document.getElementById("mail_update");
let passwordUpdate = document.getElementById("password_update");
let updateMailHelp = document.getElementById("updateMailHelp");
let updatePasswordHelp = document.getElementById("updatePasswordHelp");
let verifPasswordHelp = document.getElementById("verifPasswordHelp");

let mailRegex = /^[a-z0-9.\._-]+@[a-z0-9._-]+\.[a-z]{2,6}$/;


mailUpdate.addEventListener("submit", function(e){
    if (!mailRegex.test(mailUpdate.elements.mail.value)) {
        e.preventDefault();
        updateMailHelp.classList.add("list-group-item-danger","font-weight-bold");
        updatePasswordHelp.classList.remove("list-group-item-danger", "font-weight-bold");
        verifPasswordHelp.classList.remove("list-group-item-danger", "font-weight-bold");
    }
});

passwordUpdate.addEventListener("submit", function(e) {
    if ((passwordUpdate.elements.new_password.value.length < 8 || passwordUpdate.elements.new_password.value.length > 14) || (passwordUpdate.elements.new_password.value != passwordUpdate.elements.confirm_new_password.value)) {
        e.preventDefault();
        if (passwordUpdate.elements.new_password.value.length < 8 || passwordUpdate.elements.new_password.value.length > 14) {
            updateMailHelp.classList.remove("list-group-item-danger","font-weight-bold");
            updatePasswordHelp.classList.add("list-group-item-danger", "font-weight-bold");
            verifPasswordHelp.classList.remove("list-group-item-danger", "font-weight-bold");
        }
        else if (passwordUpdate.elements.new_password.value != passwordUpdate.elements.confirm_new_password.value) {
            updateMailHelp.classList.remove("list-group-item-danger","font-weight-bold");
            updatePasswordHelp.classList.remove("list-group-item-danger", "font-weight-bold");
            verifPasswordHelp.classList.add("list-group-item-danger", "font-weight-bold");
        }
    }
});
