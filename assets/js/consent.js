// $(document).ready(function() {
//     $('#consent_form').submit(function(e) {
//     	$('#error-message').hide();

//     	var radio = $('#Radio1').val();
//     	var radio2 = $('#Radio2').val();
//     	var txtBox = $('#txtBox').val();

//     	if (radio == 1) {
//     		if (txtBox.length < 1) {
//     			e.preventDefault();
//     			 $('#txtBox').css('border-color', 'red');
//           		 $('#error-message').show();
//           		 $('#error-message').html("Please enter company name");
//     		}
//     	}
// 	});
// });
$(document).ready(function () {
  $("input:radio[name=consent]").change(function () {
    if (this.value == "individual") {
      $("#consent-companyForm").hide("fast");
      $("#consent-individualForm").show("fast");
    } else if (this.value == "company") {
      console.log("clicked");
      $("#consent-individualForm").hide("fast");
      $("#consent-companyForm").show("fast");
    }
  });
});
