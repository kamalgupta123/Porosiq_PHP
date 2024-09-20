
function client_status_data(data) {

     $.ajax({
          url: "../ajax/client_status_result.php", 
          type: "POST", 
          dataType: "text",               
          data: {option_data: data},

          success: function(res) {
            $('#client-status-result').html(res);
            
            if (data == 1) {
              $('#responce-status').html(': In progress');
            } else if (data == '2') {
              $('#responce-status').html(': Completed');
            } else if (data == '3') {
              $('#responce-status').html(': Archived');
            } else if (data == '4') {
              $('#responce-status').html(': Needs Attention');
            }
          }
        });

}