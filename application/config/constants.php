<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
// Centralised Code
// INDIA
define('INDIA', true);
define('NEW_DATE_FORMATTER', 'd/m/Y');
// define('DBASE', 'porosiq');
// define('BUCKET', 'porosiq-india');
define('SMTP_EMAIL', getenv('SMTP_EMAIL'));
define('SMTP_PASSWORD', getenv('SMTP_PASSWORD'));
// $appsetting = getenv('APPSETTING_{SMTP_EMAIL}'); echo $appsetting;

// US
define('US', false);
// define('NEW_DATE_FORMATTER', 'm/d/Y');
// define('DBASE', 'procureline');
// define('BUCKET', 'porosiq-us');

// LATAM
define('LATAM', false);
// define('NEW_DATE_FORMATTER', 'd/m/Y');
// define('DBASE', 'porosiq');
// define('BUCKET', 'porosiq-latam');

//DEMO DBASE
define('DEMO', false);
define('DBASE', 'demossql');
define('BUCKET', 'porosiq-demo');

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SITE_NAME', 'PorosIQ');
define('PROJECT_TYPE_LOGIN', 'PorosIQ is an Industry leading 100% Cloud-based');
define('PROJECT_TYPE', 'A 100% Cloud-based');
define('PROJECT_NAME', 'GRM/GVM Software');
define('COPYRIGHT_TEXT', '&copy; 2020 PorosIQ. All rights reserved. Copyright with Cognatic Solutions LLC');
define('COMPANY_NAME', 'Cognatic Solutions');
define('COMPANY_LINK', 'https://www.cognatic.com/');

define("CLIENT_LOGO", "assets/client-logo/FIFCO_LOGO.png"); // assets/client-logo/leap-learner.png
define('CLIENT_NAME', 'PTS');
define("CLIENT_ADDRESS", "Demo Suite <br>Demo City <br>Demo pin");

define('FACEBOOK_LINK', 'https://www.facebook.com');
define('TWITTER_LINK', 'https://www.twitter.com');

define('HELPDESK_EMAIL', 'helpdesk@porosiq.com');
define('REPLY_EMAIL', 'helpdesk@porosiq.com');
define('SUPERADMIN_EMAIL','sadmin@porosiq.com');
define('SENDER_EMAIL', 'helpdesk@porosiq.com');

define('SHOW_DEMO', false);
define('USE_SSO_OKTA', false);
define('USE_1KOSMOS_CLIENT', true);
define('USE_1KOSMOS_SUPER_ADMIN', true);
define('SHOW_1KOSMOS_QR_SADMIN', true);
define('USE_1KOSMOS_EMP', true);
define('USE_1KOSMOS_VENDOR', true);
define('USE_LANG_TRANSLATOR', true);

define('SHOW_1KOSMOS_QR_ADMIN', true);

define('SHOW_1KOSMOS_QR_VENDOR', true);
define('SHOW_1KOSMOS_QR_ADMIN', true);
define('SHOW_1KOSMOS_QR_EMP', true);

define('TELEPHONE', '+1-630-635-8374');
define('FAX', '+1-551-888-3856');
define('OFFICE_ADDRESS', '1770 Park Street, Suite 107, Naperville, IL 60563');

define('NEW_DOC_DATE', '2020-12-15');

// s3 Credentials

define('S3_REGION', 'us-east-2');
define('S3_KEY', 'AKIA2BRYYMFHYYK6VFM3');
define('S3_SECRET', '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');


/**
 * Whether to use temporary employee feature.
 */
define('USE_TEMP_EMP', true);

/**
 * This flag regulates email functionality on account update of following user types.
 * Employee
 * Consultant
 * Vendor
 * Currently only PROFILE_UPDATE_SEND_EMAIL_VENDOR is in use. Others constants could be used in future.
 */
define('PROFILE_UPDATE_SEND_EMAIL_EMPLOYEE', true);
define('PROFILE_UPDATE_SEND_EMAIL_CONSULTANT', true);
define('PROFILE_UPDATE_SEND_EMAIL_VENDOR', true);

/**
 * Date and Time constants
 */
define('FORMAT_DATE', 'm/d/Y');
define('FORMAT_TIME', 'H:i');

/**
 * Use this array to define & utilize all the user types.
 *
 * @var        array
 */
$global_user_types = [
	'admin'    => 'Client',
	'employee' => 'Employee/Consultant',
	'vendor'   => 'Vendor',
	'sadmin'   => 'S Admin',
];

/**
 * Use this array to define & utilize all the candidate types.
 *
 * @var        array
 */
$global_candidate_types = [
	'1099' => '1099 User',
	'C'	   => 'Consultant',
	'E'    => 'Employee',
];
if (USE_TEMP_EMP) {
	$global_candidate_types['TE'] = 'Temporary Employee';
}

/**
 * Use this array to maintain the required number of approval levels and who will approve.
 * Please do NOT change or remove this array unless you want the site to be screwed up.
 *
 * The keys of this array will be based on the keys defined for the global user types.
 *
 * There can be two types of approval:-
 * 1. In a fixed order
 *    ==>	This order will be preferred.
 * 2. In any order
 *    ==>	If the fixed order is blank, then this order will be considered.
 */
$global_approval_levels = [
	'fixed' => [],
	'any' => [
		'admin' => 1
	],
];

// $classifications_employee = [
// 	'w2_hourly_benefit'  	=> 'W2 Hourly benefitted',
// 	'w2_hourly_non_benefit' => 'W2 Hourly non-benefitted',
// 	'w2_salaried'			=> 'W2 Salaried',
// 	'1099_user'				=> '1099',
// 	'subcontractor' 		=> 'Subcontractor'
// ];

$classifications_employee = [
	'probation'   => 'Probation',
	'permanent'   => 'Permanent',
	'contractual' => 'Contractual'
];

/**
 * This array stores the all categories of employee
 * If you are adding any new categories here then make sure do necessary changes in (Controllers > Admin > login > dashboard function) and dashboard of admin page to add new categories in dynamic employee chart.
 *
 * @var        array
 */
$categories_employee = [
	'it'              => 'IT',
	'admin_clerical'  => 'Admin Clerical',
	'professional'    => 'Professional',
	'light_industrial'=> 'Light Industrial',
	'engineering'	  => 'Engineering',
	'scientific'	  => 'Scientific',
	'healthcare'	  => 'Healthcare'
];

/**
 * To use for all the rate types.
 *
 * @var        array
 */
$global_rate_types = [
	'hourly' => 'Hourly',
	'yearly' => 'Yearly',
];

/**
 * Here the current logged-in user's privileges will be mentioned at a global-level.
 * Please do NOT change or remove this array unless you want the site to be screwed up.
 *
 * All the Privilege keys of this array are based on the Permission options available for each user.
 * If you want any new privilege key, ensure to add a UNIQUE word/s from the permission option.
 *
 * This array is utilized properly in the set_user_privileges() helper function.
 *
 * @var        array
 */
$global_user_privileges = [
	'1099 user'	    => false,
	'admin' 	 	=> false,
	'communication' => false,
	'consultant'    => false,
	'employee' 		=> false,
	'invoice'	 	=> false,
	'project'	 	=> false,
	'timesheet'	 	=> false,
	'vendor'	 	=> false,
];

/**
 * This array stores the vendor tier. This is a category of vendors based on performance
 *
 * @var        array
 */
$vendor_tier = [
	'1' => 'Tier 1',
	'2' => 'Tier 2',
	'3' => 'Tier 3',
];

/**
 * Requisition status for manage requisition functionality
 *
 * @var        array
 */
$requisition_status = [
	'1' => 'Open',
	'2' => 'On Hold',
	'3' => 'Closed',
	'4' => 'Cancelled',
];
/* End of file constants.php */
/* Location: ./application/config/constants.php */
