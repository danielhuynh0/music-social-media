// Daniel Huynh (tap7ke) and Alex Fetea (pvn5nv)

const userObject = {
    username: "",
    password: ""
}

$(document).ready(function () {
    $('#loginForm').submit(function (event) {
        userObject['username'] = $('#username').val();
        userObject['password'] = $('#passwd').val();
        const errorMessage = $('#errorMessage');

        // Regular expression pattern from PHP backend
        const passwordPattern = /^[a-zA-Z0-9]*[0-9][a-zA-Z0-9]*$/;

        if (userObject['username'] === "" || userObject['password'] === "") {
            errorMessage.text("Please fill out all fields");
            alert("Please fill out all fields");
            event.preventDefault();
            return false;
        } else if (!passwordPattern.test(userObject['password'])) {
            errorMessage.text("Password must contain at least one number and consist of alphanumeric characters");
            alert("Password must contain at least one number and consist of alphanumeric characters");
            event.preventDefault();
            return false;
        }
    });
});
