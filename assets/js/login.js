$(document).ready(function() {
	$('#login_form').submit(function(e) {

		$('#error-message').hide();
		$("#email, #password").css('border-color', '#dfe3e7');
		var email = $('#email').val();
    	var password = $('#password').val();

    	var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     	var validEmail = regEx.test(email);

    	if (email.length < 1) {
    	  e.preventDefault();
     	  $('#email').css('border-color', 'red');
     	  $('#error-message').show();
     	  $('#error-message').html("Please provide your Email Address");
     	}
     	else if (!validEmail) {
     	  e.preventDefault();
     	  $('#email').css('border-color', 'red');
     	  $('#error-message').show();
     	  $('#error-message').html("Please provide a valid Email Address");
     	}
     	else if (password < 1) {
     	  e.preventDefault();
     	  $('#password').css('border-color', 'red');
     	  $('#error-message').show();
     	  $('#error-message').html("Please provide your password");
     	}
	});
});