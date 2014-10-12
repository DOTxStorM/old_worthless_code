/**
 * email verification
 * @class email_validation
 * 
 */
/**
 * checks if email is verified
 * @method 
 */
$(document).ready(function() {
	if(code != 'empty') {
	$.ajax({
    type: "POST",
    url: "includes/validate_email.php",
    data: {code: code},
    success: function(data)
            {
				data_arr = JSON.parse(data);
                $("#message").html(data_arr[0]);
				$("#subtext").html(data_arr[1]);
            }
    });
	}
	else {
		$("#message").html("Check your email!");
		$("#subtext").html("A link has been sent to your address to validate your account");
	}
});