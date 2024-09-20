<?php
namespace Example;
use Example\Services;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../vendor/docusign/esign-client/autoload.php';
require_once __DIR__ . '/../ds_config.php';
require_once __DIR__ . '/Services/JWTService.php';
require_once __DIR__ . '/Services/SignatureClientService.php';
require_once __DIR__ . './EG001EmbeddedSigning.php';
require_once __DIR__ . '/../../../private/config.php';
require_once __DIR__ . '/../../../private/function.php';
require_once __DIR__ . '/../../../public/mail/vendor/autoload.php';
// use Example\Services\RouterService;

$GLOBALS['app_url'] = $GLOBALS['DS_CONFIG']['app_url'] . '/';
// print_r($GLOBALS['app_url']);
$signer_email_arg = '';
$signer_name_arg = '';
$signer_client_id = 1000;
$form = $_GET['form'];
$order_report_id = $_GET['order_id'];

// echo $_GET['email'];
// exit;
// if(isset($_POST) && !empty($_POST)) {
if(!isset($_GET['page'])) {
    $signer_email_arg = $_GET['email'];
    $signer_name_arg = $_GET['name'];
    $_SESSION['auth_service'] = "jwt";
    $authService = new Services\JWTService();
    $authService->checkToken();
    $eSign = new EG001EmbeddedSigning($_GET['email'], $_GET['name'], $_GET['form'], $order_report_id);
    $eSign->createController();
}
// echo $_GET['page'];
// exit;
if(isset($_GET['page'])) {
    $page = $_GET['page'];
    $order_report_id = $_GET['order_id'];
    $filename = $page."_".$order_report_id.".pdf";
    $signer_email = $signer_email_arg;
    $signer_name = $signer_name_arg;
    $envelope_args = [
        'signer_email' => $signer_email,
        'signer_name' => $signer_name,
        'signer_client_id' => $signer_client_id,
        'ds_return_url' => $GLOBALS['app_url'] . "../src/index.php?page=$form&order_id=$order_report_id"
    ];
    $args = [
        'account_id' => $_SESSION['ds_account_id'],
        'base_path' => $_SESSION['ds_base_path'],
        'ds_access_token' => $_SESSION['ds_access_token'],
        'envelope_args' => $envelope_args
    ];
    $clientService = new Services\SignatureClientService($args);
    $envelope_api = $clientService->getEnvelopeApi();

    $temp_file = $envelope_api->getDocument($args['account_id'],  '1', $_SESSION['envelope_id']);
    
    file_put_contents(FOLDER_UPLOADS . DIRECTORY_SEPARATOR . $filename, file_get_contents($temp_file->getPathname()));

    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Length: ". filesize("$filename").";");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/octet-stream; "); 
    header("Content-Transfer-Encoding: binary");

    readfile($filename);

    $mail = new PHPMailer(true);

    if ($page == 'ssa') {
        $order_query = "UPDATE client_order_report SET ssa89_form = '$filename' WHERE id=".$order_report_id;
    }

    if ($page == 'appl_discl_form') {
        $order_query = "UPDATE client_order_report SET application_form = '$filename' WHERE id=".$order_report_id;
    }

    if ($page == 'anaf') {
        $order_query = "UPDATE client_order_report SET non_discloser_form = '$filename' WHERE id=".$order_report_id;
    }

    if ($page == 'summ_of_consumer_rights') {
        $order_query = "UPDATE client_order_report SET sum_cons_right_form = '$filename' WHERE id=".$order_report_id;
    }

    if ($page == 'mixed_envelope') {
        $order_query = "UPDATE client_order_report SET sum_cons_right_form = '$filename' WHERE id=".$order_report_id;
    }

    if ($page == 'drug_d') {
        $order_query = "UPDATE client_order_report SET drug_test_manual_file = '$filename' WHERE id=".$order_report_id;
    }

    if (mysqli_query($conn, $order_query)) {
        header("Location: ../../../public/applicant-form2.php?docusign_signed=$page");
        exit();
    }

    //client
    // $mail = setUpMail($mail, $_SESSION["signup_email"], EMAIL_NOREPLY_ID, $_SESSION["signup_first"], $_SESSION["signup_last"], 0, '', '', FOLDER_ASSETS . DIRECTORY_SEPARATOR . "docusign" . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . $filename);
}


// <!-- <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Document</title>
//     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
// </head>
// <body>
    
// </body>
//     <br><br><br>
//     <div class="container">
//         <div class="row">
//             <div class="col-lg-12">
//                 <h4>Use embedded signing</h4>
//                 <form class="eg" action="" method="post">
//                     <div class="form-group">
//                         <label for="signer_email">Signer Email</label>
//                         <input type="email" class="form-control" id="signer_email" name="signer_email"
//                             aria-describedby="emailHelp" placeholder="pat@example.com" required>
//                     </div>
//                     <div class="form-group">
//                         <label for="signer_name">Signer Name</label>
//                         <input type="text" class="form-control" id="signer_name" placeholder="Pat Johnson" name="signer_name" required>
//                     </div>
//                     <button type="submit" class="btn btn-primary">Submit</button>
//                 </form>  
//                 <br><br>
//             </div>
//         </div>
//     </div>
// </html> -->
// <?php } 

