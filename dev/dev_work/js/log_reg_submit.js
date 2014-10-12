/**
 * login registration submission
 * @class log_reg_submit
 */
/**
 * 
 * hashes email and password
 * @method formhash
 * @param form
 * @param email
 * @param password
 * @returns {Boolean} 
 */
function formhash(form, email, password) {
try{
    
    // clear error messages
    clearAllErrors();
    
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    if (email.value == '' || password.value == '') {

        document.getElementById("login_error").innerHTML = 'You must fill out all fields.';        
        return false;
    }

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // submit the form. 
    form.submit();
    
    return true;
}
catch(e) {
	log("log_reg_submit.js", e.lineNumber, e);
}
}

/**
 * check that each field has a value
 * @method regformhash
 * @returns {boolean}
 */
function regformhash(form, username, email, password, p_confirm) {
    // Check each field has a value
try {

    // clear error messages
    clearAllErrors();

    if (username.value == '' ||
            email.value == '' ||
            password.value == '' ||
            p_confirm.value == '') {

        document.getElementById("email_error").innerHTML = 'You must fill out all fields.';
        return false;
    }

    // set error catcher
    var goodForm = true;

    // Check email
    var e_pattern = /^\S+@\S+\.\S+$/;
    if (!(form.email.value.match(e_pattern))) {
        document.getElementById("email_error").innerHTML = "Invalid email.";
        form.username.focus();
        goodForm = false;
    }

    // Check the username
    var pattern = /^\w+$/;
    if (!(username.value.match(pattern))) {
        document.getElementById("username_error").innerHTML = "Username must contain only<br>letters, numbers, and underscores.";
        form.username.focus();
        goodForm = false;
    }
    else if (username.value.length < 3 || username.value.length > 20 ){
        document.getElementById("username_error").innerHTML = "Username must be<br>3-20 characters.";
        form.username.focus();
        goodForm = false;
    }

    // regex for password
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    // Check that the password is sufficiently long (min 8 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 8) {
        document.getElementById("password_error").innerHTML = 'Passwords must be at least 8 characters long.';
        form.password.focus();
        goodForm = false;
    }
    // At least one number, one lowercase and one uppercase letter 
    // At least eight characters 
    else if (!re.test(password.value)) {
        document.getElementById("password_error").innerHTML = 'Passwords must contain at least one number,<br>one lowercase and one uppercase letter.';
        form.password.focus();
        goodForm = false;
    }
    // Check password and confirmation are the same
    else if (password.value != p_confirm.value) {
        document.getElementById("password_error").innerHTML = 'Your passwords do not match.';
        form.password.focus();
        goodForm = false;
    }

    // This allows the user to see all errors at once
    if (!goodForm){
        return false;
    }

    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    p_confirm.value = "";

    // submit the form. 
    form.submit();

    return true;
}
catch(e) {
	log("log_reg_submit.js", e.lineNumber, e);
}
}

/**
 * clears all errors
 * @method clearAllErrors
 */
function clearAllErrors(){
	try{
    if(document.getElementById("login_error").innerHTML !== null)
        document.getElementById("login_error").innerHTML = "<br>";
    if (document.getElementById("email_error").innerHTML !== null)    
        document.getElementById("email_error").innerHTML = "<br>";
    if (document.getElementById("username_error").innerHTML !== null)
        document.getElementById("username_error").innerHTML = "<br>";
    if (document.getElementById("password_error").innerHTML !== null)
        document.getElementById("password_error").innerHTML = "<br>";
	}
	catch(e) {
		log("log_reg_submit.js", e.lineNumber, e);
	}
}