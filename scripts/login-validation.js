
const username = document.getElementById('username');
const password = document.getElementById('passwd');
const errorMessage = document.getElementById('errorMessage');

username.addEventListener("input", validateForm);

function validateForm() {
    let username_val = username.val;
    let password_val = password.val;
    const hasNumber = /\d/.test(password_val);
    
    if (username_val == "" || password_val == "") {
        errorMessage.innerHTML = "Please fill out all fields";
        return false;
    }
    else if(hasNumber == false) {
        errorMessage.innerHTML = "Password must contain at least one number";
        return false;
    }
    return true;
}