/**
 * profile class
 * @class profile
 */$(document).ready(function() {
	var icons = {
			header: "ui-icon-plus",
			activeHeader: "ui-icon-minus"
	};
	$( "#collapse_box" ).accordion({
		collapsible: true,
		icons: icons
	});
});

var usernameError = document.getElementById('username_error');
var passwordError = document.getElementById('password_error');
var emailError = document.getElementById('email_error');
/**
 * change user's email
 * @method change_email
 * @param form
 * @param {string} email
 * @param confirm_email
 * @param {string} password
 * @returns {Boolean}
 */
function change_email(form, email, confirm_email, password){
	try{
		//clear errors
		//clearErrors();
		if (email.value == '' || confirm_email.value == '' || password.value == ''){
			emailError.innerHTML = 'You must fill out all fields.';
			return false;
		}

		var e_pattern = /^\S+@\S+\.\S+$/;
		if (!(email.value.match(e_pattern))) {
			emailError.innerHTML = "Invalid email.";
			return false;
		}
		else if (!(email.value == confirm_email.value)){
			emailError.innerHTML = "Emails do not match.";
			return false;
		}

				// TEST //
		var p = document.createElement("input");

		// Add the new element to our form. 
		form.appendChild(p);
		p.name = "password";
		p.type = "hidden";
		p.value = hex_sha512(password.value);
 
		// TEST //
		
		// Make sure the plaintext password doesn't get sent. 
		password.value = "";
		set_update_type('email', form);
		addUserID(form);
		addUserEmail(email.value, form);
		// submit the form. 
		//alert(email.value);
		form.submit();
	}
	catch(e){
		//alert(e);
		log("profile.js", e.lineNumber, e);
	}
}
/**
 * change the password
 * @method change_password
 * @param form
 * @param {string} new_password
 * @param {string} confirm_password
 * @param {string} old_password
 * @returns {Boolean}
 */
function change_password(form, new_password, confirm_password, old_password){
	try{
		//clear errors
		//clearErrors();

		if (new_password.value == '' || old_password.value == '' || confirm_password.value == ''){
			passwordError.innerHTML = 'You must fill out all fields.';
			return false;
		}

		// regex for password
		var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
		// Check that the password is sufficiently long (min 8 chars)
		// The check is duplicated below, but this is included to give more
		// specific guidance to the user
		if (new_password.value.length < 8) {
			passwordError.innerHTML = 'Passwords must be at least 8 characters long.';
			form.new_password.focus();
			return false;    
		}
		// At least one number, one lowercase and one uppercase letter 
		// At least eight characters 
		else if (!re.test(new_password.value)) {
			passwordError.innerHTML = 'Passwords must contain at least one number,<br>one lowercase and one uppercase letter.';
			form.new_password.focus();
			return false;
		}
		// Check password and confirmation are the same
		else if (new_password.value != confirm_password.value) {
			passwordError.innerHTML = 'Your passwords do not match.';
			form.new_password.focus();
			return false;
		}
			// Create a new element input, this will be our hashed password field. 
		var p = document.createElement("input");

		// Add the new element to our form. 
		form.appendChild(p);
		p.name = "password";
		p.type = "hidden";
		p.value = hex_sha512(old_password.value);

		// Make sure the plaintext password doesn't get sent. 
		old_password.value = "";

		// hash password and append to formq
		//secure_password(old_password, false);
		//secure_password(new_password, true);

		set_update_type('password', form);
		addUserID(form);
		addUserPassword(new_password.value, form);
		new_password.value = "";
		confirm_password.value = ""; // wipe this password
		// submit the form. 
		form.submit();
	}
	catch(err){
		var vDebug = ""; 
	    for (var prop in err) 
	    {  
	       vDebug += "property: "+ prop+ " value: ["+ err[prop]+ "]\n"; 
	    } 
	    vDebug += err.toString(); 
	    //alert(vDebug);
		log("profile.js", e.lineNumber, e);

	}
}
/**
 * change user name
 * @method change_username
 * @param form
 * @param {string} new_username
 * @param {string} password
 * @returns {Boolean}
 */
function change_username(form, new_username, password){
	try{
		
		//clear errors
		//clearErrors();

		if (new_username.value == '' || password.value == ''){
			usernameError.innerHTML = 'You must fill out all fields.';
			return false;
		}
		// Check the username
		var pattern = /^\w+$/;
		if (!(new_username.value.match(pattern))) {
			usernameError.innerHTML = 'Username must contain only<br>letters, numbers, and underscores.';
			form.new_username.focus();
			return false;
		}
		else if (new_username.value.length < 3 || new_username.value.length > 20 ){
			usernameError.innerHTML = 'Username must be<br>3-20 characters.';
			form.new_username.focus();
			return false;
		}

		//hash password and append to form
		//sercure_password(password, false);
		
		// TEST //
		var p = document.createElement("input");

		// Add the new element to our form. 
		form.appendChild(p);
		p.name = "password";
		p.type = "hidden";
		p.value = hex_sha512(password.value);
 
		// TEST //
		
		// Make sure the plaintext password doesn't get sent. 
		password.value = "";
		set_update_type('username', form);
		addUserID(form);
		addUserName(new_username.value, form);
		// submit the form. 
		form.submit();
	}
	catch(e){
		//alert (e.stack);
		//alert (e.line);
		log("profile.js", e.lineNumber, e);
	}
}


function delete_user(form, password) {
if (confirm("Are you sure you want to delete your account? All your stories and media files will be deleted") == true) {
	try{
		var p = document.createElement("input");

		// Add the new element to our form. 
		form.appendChild(p);
		p.name = "password";
		p.type = "hidden";
		p.value = hex_sha512(password.value);
 
		// TEST //
		
		// Make sure the plaintext password doesn't get sent. 
		password.value = "";
		set_update_type("delete", form);
		addUserID(form);
		// submit the form. 
		form.submit();
	}
	catch(e){
		//alert (e.stack);
		//alert (e.line);
		log("profile.js", e.lineNumber, e);
	}
}
else {
}
}

//clear error messages
/**
 * clear error messages
 * @method clearErrors
 */
function clearErrors(){
	try{
	if(emailError.innerHTML !== null)
		emailError.innerHTML = ' ';
	if(usernameError.innerHTML !== null)
		usernameError.innerHTML = ' ';
	if(passwordError.innerHTML !== null)
		passwordError.innerHTML = ' ';
	}
	catch(e) {
		//alert("Error Caught: 200");
		log("profile.js", e.lineNumber, e);
	}
}

/**
 * makes password secure
 * @param form
 * @param {string} password
 * @param {string} new_password
 */
function secure_password(form, password, new_password){
	try{
		var password_name = "";
		if (new_password){
			password_name = "_new";
		}

		// Create a new element input, this will be our hashed password field. 
		var p = document.createElement("input");

		// Add the new element to our form. 
		form.appendChild(p);
		p.name = "password" + password_name;
		p.type = "hidden";
		p.value = hex_sha512(password.value);

		// Make sure the plaintext password doesn't get sent. 
		password.value = "";
	}
	catch(err){
		//alert("Error Caught: 231");
		var vDebug = ""; 
	    for (var prop in err) 
	    {  
	       vDebug += "property: "+ prop+ " value: ["+ err[prop]+ "]\n"; 
	    } 
	    vDebug += "toString(): " + " value: [" + err.toString() + "]"; 
	    //alert(vDebug);
		log("profile.js", err.lineNumber, err);
	}
}

/**
 * set the update type
 * @method set_update_type
 * @param type
 * @param form
 */
function set_update_type(type, form){
	try{
	var p = document.createElement("input");

	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "update";
	p.type = "hidden";
	p.value = type;
	}
	catch(e) {
		//alert("Error Caught: 260");
		log("profile.js", e.lineNumber, e);
	}
}
/**
 * add a user into table
 * @method addUserID
 * @param form
 */
function addUserID(form){
	try {
	var p = document.createElement("input");

	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "user_id";
	p.type = "hidden";
	p.value = user_id;
	}
	catch(e) {
		//alert("Error Caught: 280");
		log("profile.js", e.lineNumber, e);
	}
}
/**
 * add a userName into table
 * @method addUserName
 * @param value, form
 */
function addUserName(val, form){
	try {
	var p = document.createElement("input");

	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "username";
	p.type = "hidden";
	p.value = val;
	}
	catch(e) {
		//alert("Error Caught: 301");
		log("profile.js", e.lineNumber, e);
	}
}

function addUserEmail(val, form){
	try {
	var p = document.createElement("input");

	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "email";
	p.type = "hidden";
	p.value = val;
	}
	catch(e) {
		//alert("Error Caught: 301");
		log("profile.js", e.lineNumber, e);
	}
}

function addUserPassword(val, form){
	try {
	var p = document.createElement("input");

	// Add the new element to our form. 
	form.appendChild(p);
	p.name = "password_new";
	p.type = "hidden";
	p.value = hex_sha512(val);

	}
	catch(e) {
		//alert("Error Caught: 301");
		log("profile.js", e.lineNumber, e);
	}
}
