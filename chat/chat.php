<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

if (!defined('BASEPATH')) {
  define('BASEPATH', '');
}
require_once(dirname(__DIR__) . '/application/config/config.php');
include_once(dirname(__DIR__) . '/application/config/constants.php');

$chat_site_url = base_url() . "chat/" ;
// $chat_site_url = "http://localhost/porosiq-bitbucket/porosiq/chat/" ;
?>

<!-- Style CSS -->
<link rel="stylesheet" href="<?php echo $chat_site_url; ?>css/style.css">
<!-- ajax link -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?php echo $chat_site_url; ?>js/data.js" type="text/javascript"></script>
<script src="<?php echo $chat_site_url; ?>js/chat.js" type="text/javascript"></script>

<!-- CHAT BOX HTML START (copy css from style & js from bottom) -->
<button class="open-button" onclick="openForm()"><img src="<?php echo $chat_site_url; ?>images/chat.png" alt=""></button>

<div class="chat-popup" id="myForm">
   <div class="form-container">
      <form id="chat_form" method="POST">
         <h5><img src="<?php echo $chat_site_url; ?>images/chat-icon.png" alt=""> Send your query!</h5>
         <div class="error-display alert alert-danger text-center" id="error-message"></div>
         <div class="responsecontainer alert alert-success text-center" role="alert" id="responsecontainer"></div>
         <div class="loader" id="loader"></div>
         <div class="form-total-pnl" id="input-panel">
            <label>Name <span class="required-red">*</span></label><input type="text" class="form-control" id="chat-name" name="chat-name" placeholder="">
            <label>Email <span class="required-red">*</span></label><input type="text" class="form-control" id="chat-email" name="chat-email" placeholder="" value="<?php echo $_SESSION["user-email-id"]; ?>" readonly> 
            <label>Phone <span class="required-red">*</span></label><input type="number" class="form-control" id="chat-phone" name="chat-phone" placeholder="">
            <label>Query <span class="required-red">*</span></label><textarea rows="2" class="form-control" id="chat-query" name="chat-query" placeholder=""></textarea>
         </div>
         <button type="submit" name="submit" id="submit" class="btn">Send Query</button>
      </form>
      <span id="chat-content">
         <h5><img src="<?php echo $chat_site_url; ?>images/chat-icon.png" alt=""> Chat with us!</h5>
         <div class="chat-inner" id="chat_box">
            <ul style="margin:0; padding:0;">
               <li class="send-chat">
                  <p>Hello, <b><?php echo $_SESSION["user-email-id"]; ?></b>. This is Admin of PorosIQ.<br/>How may I help you today?</p>
               </li>
               <span id="loading">
                  <li class="send-chat">
                     <div class="container-chat">
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                     </div>
                  </li>
               </span>
            </ul>
         </div>
         <div class="input-group mb-3" id="btns">
            <input type="text" class="form-control" id="message" placeholder="Write your message...">
            <div class="input-group-append">
               <button class="btn btn-outline-secondary" id="zero" onclick="option_zero(document.getElementById('message').value);" type="button">Send</button>
               <button class="btn btn-outline-secondary" class="btn" id="one" onclick="option_one(document.getElementById('message').value);" type="button">Send</button>
            </div>
         </div>
      </span>
      <button type="button" class="btn cancel" onclick="closeForm()"><img src="<?php echo $chat_site_url; ?>images/croos.png" alt=""></button>
   </div>
</div>
<!-- CHAT BOX HTML END -->
<!-- CHAT BOX JS START -->
<script>
   $("#chat_form").on('submit', function(e) {
     e.preventDefault();
     
     $('#error-message').hide();
     $("#chat-name, #chat-email, #chat-phone, #chat-query").css('border', '1px solid #d2d6de');
   
     var spinner = $('#loader');
     var name = $('#chat-name').val();
     var email = $('#chat-email').val();
     var phone = $('#chat-phone').val();
     var query = $('#chat-query').val();
   
     var regEx = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
     var validEmail = regEx.test(email);
   
     if (name.length < 1) {
       $('#chat-name').css('border', '1px solid red');
       $('#error-message').show();
       $('#error-message').html("Please provide your Name");
     }
     else if (email.length < 1) {
       $('#chat-email').css('border', '1px solid red');
       $('#error-message').show();
       $('#error-message').html("Please provide your Email Address");
     }
     else if (!validEmail) {
       $('#chat-email').css('border', '1px solid red');
       $('#error-message').show();
       $('#error-message').html("Please provide a valid Email Address");
     }
     else if (phone.length < 9) {
       $('#chat-phone').css('border', '1px solid red');
       $('#error-message').show();
       $('#error-message').html("Please provide your valid Phone Number");
     }
     else if (query.length < 1) {
       $('#chat-query').css('border', '1px solid red');
       $('#error-message').show();
       $('#error-message').html("Please provide your Query");
     }
     else {
       $('#submit').hide();
       $.ajax({
          url: "<?php echo $chat_site_url; ?>user-query-test.php", // URL to which the request is send
          type: "POST",                // Type of request to be send, called as method
          data: new FormData(this),    // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false,          // The content type used when sending data to the server.
          cache: false,                // To unable request pages to be cached
          processData: false,          // To send DOM or non processed data file it is set to false
          success: function(response) {
            $('#input-panel').hide();                   
            $('#responsecontainer').show();
            $("#responsecontainer").html('Thank you for the details! One of our customer representatives will get in touch with you shortly.');
          }
        });
     }
   });
        function openForm() {
          $("#myForm").toggle();
        }
        
        function closeForm() {
          document.getElementById("myForm").style.display = "none";
        }
     
</script>
<!-- CHAT BOX JS END -->