
"use strict"

// for show password 
let createpassword = (type, ele) => {
    let inputField = document.getElementById(type);
    inputField.type = inputField.type === "password" ? "text" : "password";
    let icon = ele.querySelector("i"); // Look for the <i> tag inside the element
    if (icon) {
        if (icon.classList.contains("ri-eye-line")) {
            icon.classList.remove("ri-eye-line");
            icon.classList.add("ri-eye-off-line");
        } else {
            icon.classList.remove("ri-eye-off-line");
            icon.classList.add("ri-eye-line");
        }
    } else {
        console.error("Icon not found. Make sure the <i> element exists.");
    }
};


function IsEmail(email) {
    
    const regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    }
    else {
        return true;
    }
}