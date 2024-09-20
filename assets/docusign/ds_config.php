<?php
// ds_config.php
// 
// DocuSign configuration settings
$DS_CONFIG = [
    'quickstart' => '{QUICKSTART_VALUE}',
    'ds_client_id' => 'e4e82ac2-bccb-4d69-9fd4-0ed16df50b03',  // The app's DocuSign integration key
    'ds_client_secret' => 'f3a68e5f-6546-4f38-a570-f91fc1805007', // The app's DocuSign integration key's secret
    'signer_email' => 'kamal@ptscservices.com',
    'signer_name' => 'Kamal Gupta',
    'app_url' => 'https://vetzu-dev.azurewebsites.net/assets/docusign/src', // The url of the application.
    // Ie, the user enters  app_url in their browser to bring up the app's home page
    // Eg http://localhost/code-examples-php/public if the app is installed in a
    // development directory that is accessible via web server.
    // NOTE => You must add a Redirect URI of app_url/index.php?page=ds_callback to your Integration Key.
    'authorization_server' => 'https://account-d.docusign.com',
    'session_secret' => '{SESSION_SECRET}', // Secret for encrypting session cookie content
    'allow_silent_authentication' => true, // a user can be silently authenticated if they have an
    // active login session on another tab of the same browser
    'target_account_id' => false, // Set if you want a specific DocuSign AccountId, If false, the user's default account will be used.
    'demo_doc_path' => 'demo_documents',
    'doc_docx' => 'World_Wide_Corp_Battle_Plan_Trafalgar.docx',
    'doc_pdf' =>  'SSA-89.pdf',
    'doc_pdf_2' => 'Application_disclosure_form.pdf',
    'doc_txt' =>  'Welcome.txt',
    // Payment gateway information is optional
    'gateway_account_id' => '{GATEWAY_ACCOUNT_ID}',
    'gateway_name' => "stripe",
    'gateway_display_name' => "Stripe",
    'github_example_url' => 'https://github.com/docusign/code-examples-php/tree/master/src/Controllers/examples/eSignature/',
    'documentation' => false,
];

$JWT_CONFIG = [
    'ds_client_id' => 'e4e82ac2-bccb-4d69-9fd4-0ed16df50b03', // The app's DocuSign integration key
    'authorization_server' => 'account-d.docusign.com',
    "ds_impersonated_user_id" => '118613d7-5141-45f9-bea5-120b920df8b0',  // the id of the user
    "private_key_file" => "/private.key", // path to private key file
];

$EXAMPLES_API_TYPE = [
    'Rooms' => false,
    'ESignature' => true,
    'Click' => false,
    'Monitor' => false
];

$GLOBALS['DS_CONFIG'] = $DS_CONFIG;
$GLOBALS['JWT_CONFIG'] = $JWT_CONFIG;
$GLOBALS['EXAMPLES_API_TYPE'] = $EXAMPLES_API_TYPE;