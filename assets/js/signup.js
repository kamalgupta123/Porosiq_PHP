$(document).ready(function() {
    $('#signup_form').submit(function(e) {

		$('#error-message').hide();
		$("#firstName, #lastName, #email, #password1, #password2").css('border-color', '#dfe3e7');
    $("#policy").css('outline-color', '#dfe3e7');

		var email = $('#email').val();
  	var password1 = $('#password1').val();
    var password2 = $('#password2').val();
    var firstName = $('#firstName').val();
    var lastName = $('#lastName').val();
    var policy = $('#policy:checkbox:checked').length < 1;

  	var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
   	var validEmail = regEx.test(email);

    if (firstName.length < 1) {
      e.preventDefault();
      $('#firstName').css('border-color', 'red');
      $('#error-message').show();
      $('#error-message').html("Please enter your First Name");
    }
    else if (lastName.length < 1) {
      e.preventDefault();
      $('#lastName').css('border-color', 'red');
      $('#error-message').show();
      $('#error-message').html("Please enter your Last Name");
    }
  	else if (email.length < 1) {
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
   	else if (password1.length < 5) {
   	  e.preventDefault();
   	  $('#password1').css('border-color', 'red');
   	  $('#error-message').show();
   	  $('#error-message').html("Please provide your Password of at least 5 characters");
   	}
    else if (password1 != password2) {
      e.preventDefault();
      $('#password1').css('border-color', 'red');
      $('#password2').css('border-color', 'red');
      $('#error-message').show();
      $('#error-message').html("Passwords don't match! Please try again");

    } else if (policy == true) {
      e.preventDefault();
      $('#policy').css('outline-color', 'red');
      $('#policy').css('outline-style', 'solid');
      $('#policy').css('outline-width', 'thin');
      $('#error-message').show();
      $('#error-message').html("Please accept Terms of Use and Privacy Policy.");

    }
	});
});