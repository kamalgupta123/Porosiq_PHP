$(document).ready(function() {
	$('#order_report_form').submit(function(e) {

		$("#first_name, #last_name, #street_address, #dob, #city, #order_st, #zip, #security_num").css('border-color', 'grey');
		$("#application_form, #non_disclosure_aggrement, #ssa_form").css('color', 'black');

		var first_name = $('#first_name').val();
		var last_name = $('#last_name').val();
		var street_address = $('#street_address').val();
		var city = $('#city').val();
		var dob = $('#dob').val();
		var order_st = $('#order_st').val();
		var zip = $('#zip').val();
		var security_num = $('#security_num').val();
		var application_form = $('#application_form').val();
		var non_disclosure_aggrement = $('#non_disclosure_aggrement').val();
		var ssa_form = $('#ssa_form').val();
		var drugCheck = $('#drugCheck').val();

		if (first_name.length < 1) {
			e.preventDefault();
			$('#first_name').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* first name is requried.</p>');
		} else if (last_name.length < 1) {
			e.preventDefault();
			$('#last_name').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* last name is requried.</p>');
		} else if (street_address.length < 1) {
			e.preventDefault();
			$('#street_address').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* Street Address is requried.</p>');
		} else if (dob.length < 1) {
			e.preventDefault();
			$('#dob').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* DOB is requried.</p>');
		} else if (city.length < 1) {
			e.preventDefault();
			$('#city').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* city is requried.</p>');
		} else if (order_st.length < 1) {
			e.preventDefault();
			$('#order_st').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* ST is requried.</p>');
		} else if (zip.length < 1) {
			e.preventDefault();
			$('#zip').css('border-color', 'red');
			$('#error').html('<p class="text-danger error">* Zip Code is requried.</p>');
		} else if (security_num.length < 1) {
			if (!$('#e_sign').is(':checked')) {
				e.preventDefault();
				$('#security_num').css('border-color', 'red');
				$('#error').html('<p class="text-danger error">* Social Security Number is requried.</p>');
			}
		} else if ($('.checkOption:checkbox:checked').length == 0 && $(".3packages").is(':checked') == false && !$('.bg_check').is(':checked') && !('.check_bg').is(':checked')) {
			e.preventDefault();
			$('#error').html('<p class="text-danger error">* At least one Verification Option checkbox needs to be checked.</p>');
		} else if ($('#bgCheck:checkbox:checked').length == 1) {

			if (application_form.length == 0) {
				e.preventDefault();
				$('#application_form').css('color', 'red');
				$('#error').html('<p class="text-danger error">* Please upload your Applicant Disclosure Form.</p>');
			} else if (non_disclosure_aggrement.length == 0) {
				e.preventDefault();
				$('#non_disclosure_aggrement').css('color', 'red');
				$('#error').html('<p class="text-danger error">* Please upload your Application and Authorisation Form for Background Screening.</p>');
			} else if (ssa_form.length == 0) {
				e.preventDefault();
				$('#ssa_form').css('color', 'red');
				$('#error').html('<p class="text-danger error">* Please upload your SSA-89 form.</p>');
			}
		}
	});

	$(document).on("click",".drug_tests",function() {
		if ($(this).is(':checked')) {
			$(".drug_test_consent_form").show();
		}
		else {
			$(".drug_test_consent_form").hide();
		}
    });

	$(document).on("change",".not_drug_tests",function() {
		$(".drug_test_consent_form").hide();
    });

	$(document).on("click","#package6",function() {
		$('.cori_form_block').toggle();
		$('.cori_download').toggle();
		$(".drug_test_consent_form").hide();
    });

	$(document).on("change",".not_package_6",function() {
		$('.cori_form_block').hide();
		$('.cori_download').hide();
    });

	$(document).on("change",".drug_tests_radio",function() {
		$(".drug_test_consent_form").show();
    });

});