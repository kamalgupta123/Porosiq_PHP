$(document).ready(function () {
  // var str = window.location.href;
  // var n = str.search("dashboard");
  // if (n > "1") {
  //   setTimeout(function () {
  //     document.getElementById("myForm").style.display = "block";
  //   }, 3000);
  // }
  first_message();
    if (localStorage.getItem("hasCodeRunBefore") === null) {
      setTimeout(function () {
      document.getElementById("myForm").style.display = "block";
    }, 3000);
      localStorage.setItem("hasCodeRunBefore", true);
    }
});

function first_message() {
  $("#loading").show().appendTo($(".chat-inner ul"));
  setTimeout(function () {
    $("#loading").hide();
    $(
      '<li class="send-chat"><p>' + data[0].first_options + "</p></li>"
    ).appendTo($(".chat-inner ul"));
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
  }, 4000);
  $(".chat-inner").animate({
    scrollTop: $(".chat-inner").prop("scrollHeight"),
  });
}
function chat_query(message) {
  $("#message").val(null);
  $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
    $(".chat-inner ul")
  );
  $("#loading").show().appendTo($(".chat-inner ul"));
  setTimeout(function () {
    $("#loading").hide();
    $("#chat-content").hide();
    $("#chat_form").show();
  }, 2000);
  $(".chat-inner").animate({
    scrollTop: $(".chat-inner").prop("scrollHeight"),
  });
}
// function send_query(message){
//  if($.trim(message) == '') {
//   return false;
// }
// else {
// $('#message').val(null);
// $('<li class="reply-chat"><p>' + message + '</p></li>').appendTo($('.chat-inner ul'));
// $('#loading').show().appendTo($('.chat-inner ul'));
// $(".chat-inner").animate({
//             scrollTop: $('.chat-inner').prop('scrollHeight')
//             });
//     $.ajax({
//      url: "chat/user-query.php",
//      type: "POST",
//      dataType: "text",
//      data: {message: message},
//      success: function(res) {
//        $('<li class="send-chat"><p>' + res + '</p></li>').appendTo($('.chat-inner ul'));
//        $(".chat-inner").animate({
//          scrollTop: $('.chat-inner').prop('scrollHeight')
//          });
//        console.log(res);
//        $('#loading').hide();
//        $('#btns').hide();
//      }
//    });
// }
// }

var previous_message = 0; //Declaring a var for back options

function start_message() {
  $("#one").hide();
  first_message();
  $("#zero").show();
}

function option_zero(message) {
  window.previous_message = message;

  if ($.trim(message) == "") {
    return false;
  } else if ($.trim(message) == "1") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Ok, Here you go<br>You chose <b>Documentation</b><br>1. How to Upload Document<br/>2. How to edit Document<br>3. Go back to the Last Menu  <br/>9. Can\'t find your query?<br><br> Reply with the option number (like, 1) to select option.</p></li>'
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
    $("#zero").hide();
    $("#one").show();
  } else if ($.trim(message) == "2") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Ok, Here you go<br>You chose <b>Timesheet</b><br>1. How to Upload Timesheet<br/>2. How to edit Timesheet<br>3. Go back to the Last Menu  <br/>9. Can\'t find your query?<br><br> Reply with the option number (like, 1) to select option.</p></li>'
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
    $("#zero").hide();
    $("#one").show();
  } else if ($.trim(message) == "3") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Ok, Here you go<br>You chose <b>Project Details</b><br>1. How to see projects<br>2. How to update Project details<br>3. Go back to the Last Menu  <br/>9. Can\'t find your query?<br><br> Reply with the option number (like, 1) to select option.</p></li>'
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
    $("#zero").hide();
    $("#one").show();
  } else if ($.trim(message) == "4") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Ok, Here you go<br>You chose <b>Communication</b><br>1. How to see projects<br>2. How to update Project dfetails<br>3. Go back to the Last Menu  <br/>9. Can\'t find your query?<br><br> Reply with the option number (like, 1) to select option.</p></li>'
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
    $("#zero").hide();
    $("#one").show();
  } else if ($.trim(message) == "5") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Ok, Here you go<br>You chose <b>Update profile</b><br>1. How to update email Id <br>2. How to Update Phone number <br>3. Go back to the Last Menu  <br/>9. Can\'t find your query?<br><br> Reply with the option number (like, 1) to select option.</p></li>'
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
    $("#zero").hide();
    $("#one").show();
  } else if ($.trim(message) == "9") {
    chat_query(message);
  } else {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );
    $("#loading").show().appendTo($(".chat-inner ul"));
    setTimeout(function () {
      $("#loading").hide();
      $(
        '<li class="send-chat"><p>Invalid Option chosen!!!<br><br>' +
          data[0].first_options +
          "</p></li>"
      ).appendTo($(".chat-inner ul"));
      $(".chat-inner").animate({
        scrollTop: $(".chat-inner").prop("scrollHeight"),
      });
    }, 2000);
    $(".chat-inner").animate({
      scrollTop: $(".chat-inner").prop("scrollHeight"),
    });
  }
}

function option_one(message) {
  console.log(previous_message);

  if ($.trim(message) == "") {
    return false;
  } else if ($.trim(message) == "3") {
    $("#message").val(null);
    $('<li class="reply-chat"><p>' + message + "</p></li>").appendTo(
      $(".chat-inner ul")
    );

    $("#loading").show().appendTo($(".chat-inner ul"));
    start_message();
    return false;
  } else if ($.trim(message) == "9") {
    chat_query(message);
  }
}

/**
 * For this function to work properly,
 * all the user type options related JS files need to be imported or included here
 */
// function processOptions(user_type, old_option_set, next_option_num) {
//   var variable_suffix_part = '';

//   if (old_option_set != '') {
//     variable_suffix_part += "_" + old_option_set;
//   }

//   if (!isNaN(next_option_num)) {
//     if (next_option_num == 9) { // To go back to the last menu
//       variable_suffix_part = variable_suffix_part.substring(0, variable_suffix_part.length - 2);
//     } else if (next_option_num == 0) { // To go back to the main menu
//       variable_suffix_part = '';
//     } else if (next_option_num > 9) { // What to do when unknown options are chosen?

//     } else {
//       variable_suffix_part += "_" + next_option_num;
//     }
//   } else { // What to do when some invalid character/s is given as an option?

//   }

//   eval("var required_options = " + user_type + "_options" + variable_suffix_part + ";");

//   if (typeof required_options !== 'undefined') {
//     console.log(required_options);
//   } else {
//     console.log("required options variable not found");
//   }
// }
