<?php
echo "Thank you for the details! One of our customer representatives will get in touch with you shortly.";
exit;
print_r($_POST);
$name = trim($_POST['chat-name']);
$email = trim($_POST['chat-email']);
$phone = trim($_POST['chat-phone']);
$query = trim($_POST['chat-query']);

ini_set("SMTP","smtp.office365.com");
ini_set("sendmail_from", "swaraj@porosiq.com");
ini_set('smtp_port', "587");

$to      = 'sayantan.g@ptscservices.com';
$subject = 'the subject';
$message = 'hello';
$headers = array(
    'From' => 'swaraj@porosiq.com',
    'Reply-To' => $email,
    'X-Mailer' => 'PHP/' . phpversion()
);

if (mail($to, $subject, $message, $headers)) {
	echo "done";
} else {
	echo "<pre>" . print_r(error_get_last(), 1) . "</pre>";
	echo "fail";
}


exit();
// $to_email = 'info@ptscservices.com';
$to_email = "sayantan.g@ptscservices.com";
// $form_email = 'sadmin@porosiq.com';

$mail_subject = "$user_email have some query | porosIQ chat";
$mail_body = "$message";

$headers = "MIME-Version: 1.0" . "\r\n";
$headers.= "Content-type:text/html;charset=UTF-8" . "\r\n";
// $headers.= 'Cc: ' . $user_email . "\r\n";
$headers.= 'From: ' . $email . "\r\n" . 'Reply-To: ' . $email . "\r\n";

if (mail($to_email, $mail_subject, $mail_body, $headers)) {
	    echo "We have received your query. One of our Admin will soon get back to you on this on your email. Thank you, have a nice day!";
	} else {
	    echo "Something went wrong! Please try again...";
	}
?>