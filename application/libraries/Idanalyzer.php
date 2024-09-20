<?php                                                                                 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once("IDAnalyzer/CoreAPI.php");
require_once("IDAnalyzer/Vault.php");

use IDAnalyzer\CoreAPI;
use IDAnalyzer\Vault;

/**
 * @description : Library to access IDAnalyzer Core API
 */
Class Idanalyzer {

    function __construct() {

    }

    public function run($file1,$file2,$file3) {

        // ID Analyzer API key available under your web portal https://portal.idanalyzer.com
        $apikey = "zKlXYGcvDUvYV7zddsFeP1kWy2YmQvKN";

        // API region: US or EU
        $api_region = "US";
        
        // Initialize Core API with your credentials
        $coreapi = new CoreAPI($apikey, $api_region);

        // Make API error raise exceptions for API level errors (such as out of quota, document not recognized)
        $coreapi->throwAPIException(true);

        // enable vault cloud storage to store document information and image
        $coreapi->enableVault(true,false,false,false);

        // quick fake id check
        $coreapi->enableAuthentication(true, 'quick'); // check if document is real using 'quick' module


        // perform a scan using uploaded image
        $result = $coreapi->scan($file1,$file2,$file3);


        return $result;
    }

    public function getVaultData($vaultid) {

        // ID Analyzer API key available under your web portal https://portal.idanalyzer.com
        $apikey = "zKlXYGcvDUvYV7zddsFeP1kWy2YmQvKN";

        // API region: US or EU
        $api_region = "US";

        // Initialize Vault API with your credentials
        $vault = new Vault($apikey, $api_region);

        // Get the vault entry using Vault Entry ID received from Core API
        $vaultdata = $vault->get($vaultid);

        $vaultData = $vaultdata;

        return $vaultData;
    }

}

?>