/**
 * forgot password use
 * @class forgot_password
 */

/**
 * clears all
 * @method clearAll
 * @param email
 */function clearAll(email) {
	try{
		document.getElementById('error_message').innerHTML = '<br>An email has been sent to:<br><strong>' + email + '</strong><br><br>';
		document.getElementById('error_message').style.color = '#009900';
		$('#submit_button').attr("onclick", "goToLogin()");
		document.getElementById('submit_button').innerHTML = 'Log In';
		$(".disappear").hide();
	}
	catch(e){
		log("forgot_password.js", e.lineNumber, e);
	}
}

// NEEDS DEBUGGING
function goToLogin(email){
	try{
		//alert("hi " + email);
		window.location.href = 'index.php?eTried=0';
		//alert("hello");
	}
	catch(e){
		log("forgot_password.js", e.lineNumber, e);
	}
}