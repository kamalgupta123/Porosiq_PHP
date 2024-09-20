<?php
if (!defined('BASEPATH')) {
  define('BASEPATH', '');
}

include_once(dirname(__DIR__) . '/application/config/constants.php');

$name = trim($_POST['chat-name']);
$email = trim($_POST['chat-email']);
$phone = trim($_POST['chat-phone']);
$query = trim($_POST['chat-query']);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.office365.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'swaraj@porosiq.com';                     // SMTP username
    $mail->Password   = 'Suite@1702';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('swaraj@porosiq.com');
    $mail->addAddress(HELPDESK_EMAIL);
    $mail->addReplyTo($email);
    $mail->addCC($email);
    $mail->addCC('sayantan@porosiq.com');     // Add a recipient
    $mail->addCC('anutosh@porosiq.com');      // Name is optional

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = SITE_NAME . " Query | $name has a Query";
    $mail->Body = '<b>Name: </b>'. $name .'<br/>' . 
    			'<b>Email: </b>'. $email .'<br/>' .
    			'<b>Phone: </b>'. $phone .'<br/><br/>' .
    			$query;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent.";
}
?>