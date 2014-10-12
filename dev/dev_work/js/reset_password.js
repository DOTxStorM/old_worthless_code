function change_password(form, new_password, confirm_password){
	try{
		//clear errors
		//clearErrors();

		if (new_password.value == '' || confirm_password.value == ''){
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
		p.value = hex_sha512(new_password.value);
		
		var p = document.createElement("input");
		form.appendChild(p);
		p.name="q";
		p.type = "hidden";
		p.value = q;

		// Make sure the plaintext password doesn't get sent. 
		new_password.value = "";
		confirm_password.value="";
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