$(function() {

  $("#form_submit").click(function(e){  // passing down the event 

    var spinner = $('#loader');
    spinner.show();
    $('#ajax_data').hide();

    $.ajax({
       url:'sadmin-load-historical-timesheet',
       type: 'POST',
       data: $("#historical_timesheet_form").serialize(),
       success: function(response){
           $("#ajax_data").html(response);
           spinner.hide();
           $('#ajax_data').show();
       },
       error: function(){
       }
   });
   e.preventDefault(); // could also use: return false;
 });
});