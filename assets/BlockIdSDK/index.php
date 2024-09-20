<?php

header('Content-Type: application/json');
// header("Access-Control-Allow-Origin: *");
require_once("./BIDEcdsa.php");


// $my_public_key      = "MIGbMBAGByqGSM49AgEGBSuBBAAjA4GGAAQAJn9PqpqN+PDWI9fr8HRFxgua2yHd3wtDqpahfPaNZ4DkFbx7QGxMHD51FL4YJsD6uI2fW9ZFGUDhAnQUFs7+CUgAuMbk7ITbo9wflwX5/ZsXysHVwFYs5ocASkf+aIUh3ie2sKohGDYtqy5OJawbMs7MOslwTDtzK2CKDdsUv9lhFdI=";
// $my_private_key     = "MIHuAgEAMBAGByqGSM49AgEGBSuBBAAjBIHWMIHTAgEBBEIApOEXQIO+PPZq6BnhQbt4ediWoMCLX9xSYOvjLt/7SHjc2UuVYKZelWy02z9OaLRoZnCExR+jjecg9YenQKjwK5KhgYkDgYYABAAmf0+qmo348NYj1+vwdEXGC5rbId3fC0OqlqF89o1ngOQVvHtAbEwcPnUUvhgmwPq4jZ9b1kUZQOECdBQWzv4JSAC4xuTshNuj3B+XBfn9mxfKwdXAVizmhwBKR/5ohSHeJ7awqiEYNi2rLk4lrBsyzsw6yXBMO3MrYIoN2xS/2WEV0g==";
$my_public_key      = "os9skQhJpyJIz7g5xgopwlN3N7eqMR9XMupvIIZf+CkB0V5ADDDdQ0wfA8KqH98NuFch4cIm6qwfuLGwoPCk+A==";
$my_private_key     = "cGB/g7jd/jw1v4z8FDfoeppYQ6y1IJAYzPPkzKkCc4w=";
$tenantTag          = "porosiq";
$tenantURL          = "https://porosiq.1kosmos.net";
$communityName      = "default";
// $licenseKey         = "afeb1c93-2265-43e1-a7b1-5049bb4f3c8b";
$licenseKey         = "ab91b811-d71d-4e4b-bb48-526d72f82650";
$appId              = "com.bid.php.sdk";

function executeRequest($method, $url, $headers, $body, $debug) {

    $debug_curl = false;
    if (isset($debug)) {
        $debug_curl = $debug;
    }

	$curl = curl_init();

    $curl_headers = array("Content-Type: application/json", "Content-Type: text/plain");

	if (isset($headers)) {
		foreach ($headers as $key => $value){
			array_push($curl_headers, $key . ": " . $value);
		}
	}




	$options = array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => $method,
	  CURLOPT_HTTPHEADER => $curl_headers,
	);
	
	if (isset($body)) {
        $bodyStr = json_encode($body);
        $options[CURLOPT_POSTFIELDS] = $bodyStr;
    }

    

    curl_setopt_array($curl, $options);
    if ($debug) {
        curl_setopt($curl, CURLOPT_VERBOSE, true);
    }
	
    $response = curl_exec($curl);
    
    if ($debug) {
        $info = curl_getinfo($curl);
        error_log(print_r("curl info: " . json_encode($info), TRUE));
    }
    
    curl_close($curl);

    if ($debug) {
        error_log(print_r($method . " url: " . $url . " returned: " . $response, TRUE));
    }

	return json_decode($response);	
}

function fetchServerKeys() {
    global $tenantURL, $tenantTag, $communityName, $licenseKey;
    $url = $tenantURL . "/api/r1/community/" . $communityName . "/publickeys";

    $key = "public_key:tenant:" . $tenantTag . "@" . $url;

    $publicKey = $_SESSION[$key];

    if (!isset($publicKey)) {
        error_log(print_r("call server for public key ", TRUE));
        //let's get it from server
        $serverKeySet = executeRequest("GET", $url, array("X-TenantTag" => $tenantTag), null, false);
        $_SESSION[$key] = $publicKey = $serverKeySet->{"publicKey"};
    }


    return $publicKey;
}

function ecdsaHelper($method, $dataStr, $rcptKey) {
    global $my_private_key;
    $sharedKey = BIDEcdsa::createSharedKey($my_private_key, $rcptKey);

    $ret = "";
    if ("encrypt" == $method) {
        $ret = BIDEcdsa::encrypt($dataStr, $sharedKey);
    }
    else {
        $ret = BIDEcdsa::decrypt($dataStr, $sharedKey);
    }

    return $ret;

}


function makeRequestIdStr() {
    global $appId;
    $unqid = uniqid();
    $epoctime = time();

    $payload = array(
        "ts" => $epoctime,
        "appid" => $appId,
        "udid" => $unqid
    );

    $payloadStr = json_encode($payload);
    // error_log(print_r("reqId str: " . $payloadStr, TRUE));

    $serverKey = fetchServerKeys();

    // error_log(print_r("serverKey: " . $serverKey, TRUE));
    
    $response = ecdsaHelper("encrypt", $payloadStr, $serverKey);

    return $response;
}

function encryptedLicenseKey() {
    global $licenseKey;

    $ret = ecdsaHelper("encrypt", $licenseKey, fetchServerKeys());

    // error_log(print_r("encryptedLicense " . $ret, TRUE));

    return $ret;
}

function fetchLinkedAccounts($DID) {
//{{client_api}}/api/r1/community/default/userdid/:userdid/userinfo    
    global $tenantURL, $tenantTag, $communityName, $my_public_key;
    $url = $tenantURL . "/api/r1/community/" . $communityName . "/userdid/" . $DID . "/userinfo";

    // error_log(print_r("fetchLinkedAccounts for " . $url, TRUE));

    $headers = array (
        "X-TenantTag" => $tenantTag,
        "publicKey" => $my_public_key,
        "licensekey" => encryptedLicenseKey(),
        "requestid" => makeRequestIdStr()
    );

    $response = executeRequest("GET", $url, $headers, null, false);
    $data_str = $response->{'data'};
    // error_log(print_r("fetchLinkedAccounts for " . $url . " \n data_str = " . $data_str, TRUE));
    $profile_info = null;
    if (isset($data_str)) {
        $profile_info_str = ecdsaHelper("decrypt", $data_str, fetchServerKeys());

        // error_log(print_r("profile_info_str for " . $url . " \n = " . $profile_info_str, TRUE));

        $profile_info = json_decode($profile_info_str);
    }

    // error_log(print_r("profile_info for " . $DID . " = " . json_encode($profile_info), TRUE));
    return $profile_info;

}

function checkAuthSession($sessionId) {
    global $tenantURL, $tenantTag, $communityName, $my_public_key;

    $url = $tenantURL . "/api/r1/community/" . $communityName . "/session/" . $sessionId . "/response";
    $headers = array (
        "X-TenantTag" => $tenantTag,
        "publicKey" => $my_public_key,
        "licensekey" => encryptedLicenseKey(),
        "requestid" => makeRequestIdStr()
    );

    $session_response = executeRequest("GET", $url, $headers, null, false);
    //error_log(print_r("session_payload: " . json_encode($session_response), TRUE));

    $user_data = null;
    if (isset($session_response)) {
        $user_data_str = ecdsaHelper("decrypt", $session_response->{'data'}, $session_response->{'publicKey'});
        $user_data = json_decode($user_data_str);
        $session_response->{"user_data"} = $user_data;
    }

    //error_log(print_r("isset(user_data): " . isset($user_data), TRUE));
    if (isset($user_data)) {
        //error_log(print_r("user_data from api: " . json_encode($user_data), TRUE));
        $DID = $user_data->{"did"};
        //error_log(print_r("did: " . $DID, TRUE));
        $session_response->{"account_data"} = fetchLinkedAccounts($DID);
    }

    // error_log(print_r("user_data: " . json_encode($user_data), TRUE));

    return $session_response;
}

function doEncrypt($str, $publicKey) {
    global $my_private_key;
    $sharedKey = BIDEcdsa::createSharedKey($my_private_key, $publicKey);

    $ret = BIDEcdsa::encrypt($str, $sharedKey);

    return $ret;
}

function doDecrypt($str, $publicKey) {
    global $my_private_key;
    $sharedKey = BIDEcdsa::createSharedKey($my_private_key, $publicKey);

    $ret = BIDEcdsa::decrypt($str, $sharedKey);

    return $ret;
}



session_start();


    $aResult = array();

	if ('getkeyset' == $_POST['functionname']) {
		$phrase = $_POST['phrase'];
		$aResult["publicKey"] 	= $my_public_key;
        // $aResult["privateKey"] 	= $my_private_key;
    }
    else if ('encrypt' == $_POST['functionname']) {
        $aResult["result"] = "n/a";
	}
    else if ('decrypt' == $_POST['functionname']) {
        $aResult["result"] = "n/a";
    }
    else if ('checksession' == $_POST['functionname']) {
        $sessionId = $_POST['sessionId'];
        $aResult = checkAuthSession($sessionId);
    }
    else if ('sessionpayload' == $_POST['functionname']) {
        $aResult = array(
            "publicKey" => $my_public_key,
            "api" => $tenantURL,
            "tag" => $tenantTag,
            "community" => $communityName
        );
    }
	else {
		$aResult["error"] 		= "invalid method call";
    }
    
    //OK  fetchServerKeys();
    //OK ecdsaHelper("encrypt", "hi", "os9skQhJpyJIz7g5xgopwlN3N7eqMR9XMupvIIZf+CkB0V5ADDDdQ0wfA8KqH98NuFch4cIm6qwfuLGwoPCk+A==");
    //OK ecdsaHelper("decrypt", "ZWQ2YzIxYjUyNmFhNWJiORulREPqAoblwaxmfy4s7ygWcw==", "os9skQhJpyJIz7g5xgopwlN3N7eqMR9XMupvIIZf+CkB0V5ADDDdQ0wfA8KqH98NuFch4cIm6qwfuLGwoPCk+A==");
    //OK makeRequestIdStr();
    //OK encryptedLicenseKey();
    //OK checkAuthSession("lqun4cwhxhpixhjtt9chq");

	echo json_encode($aResult);

?>

