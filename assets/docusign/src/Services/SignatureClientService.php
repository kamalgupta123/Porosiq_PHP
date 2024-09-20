<?php


namespace Example\Services;

use DocuSign\eSign\Api\AccountsApi;
use DocuSign\eSign\Api\BulkEnvelopesApi;
use DocuSign\eSign\Api\EnvelopesApi;
use DocuSign\eSign\Api\GroupsApi;
use DocuSign\eSign\Api\TemplatesApi;
use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Client\ApiException;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\Model\RecipientViewRequest;

class SignatureClientService
{
    /**
     * DocuSign API Client
     */
    public $apiClient;

    /**
     * Router Service
     */
    public $routerService;

    /**
     * Create a new controller instance.
     *
     * @param $args
     * @return void
     */
    public function __construct($args)
    {
        # Construct your API headers
        # Exceptions will be caught by the calling function
        # Step 2 start
        $config = new Configuration();
        $config->setHost($args['base_path']);
        $config->addDefaultHeader('Authorization', 'Bearer ' . $args['ds_access_token']);    
        $this->apiClient = new ApiClient($config);
        # Step 2 end    
        $this->routerService = new RouterService();
    }

    /**
     * Getter for the EnvelopesApi
     */
    public function getEnvelopeApi(): EnvelopesApi
    {
        return new EnvelopesApi($this->apiClient);
    }

    /**
     * Getter for the TemplatesApi
     */
    public function getTemplatesApi(): TemplatesApi
    {
        return new TemplatesApi($this->apiClient);
    }

    /**
     * Getter for the AccountsApi
     */
    public function getAccountsApi(): AccountsApi
    {
        return new AccountsApi($this->apiClient);
    }

    /**
     * Getter for the AccountsApi
     */
    public function getGroupsApi(): GroupsApi
    {
        return new GroupsApi($this->apiClient);
    }

    /**
     * Getter for the BulkEnvelopesApi
     */
    public function getBulkEnvelopesApi(): BulkEnvelopesApi
    {
        return new BulkEnvelopesApi($this->apiClient);
    }

    /**
     * Getter for the RecipientViewRequest
     */
    public function getRecipientViewRequest($authentication_method, $envelope_args): RecipientViewRequest
    {
        return new RecipientViewRequest([
            'authentication_method' => $authentication_method,
            'client_user_id' => $envelope_args['signer_client_id'],
            'recipient_id' => '1',
            'return_url' => $envelope_args['ds_return_url'],
            'user_name' => $envelope_args['signer_name'], 'email' => $envelope_args['signer_email']
        ]);
    }

    /**
     * Getter for the AccountsApi
     *
     * @param $account_id string
     * @param $envelope_id string
     * @param $recipient_view_request RecipientViewRequest
     * @return mixed - the list of Recipient Views
     */
    public function getRecipientView($account_id, $envelope_id, $recipient_view_request)
    {
        try {
            $envelope_api = $this->getEnvelopeApi();
            $results = $envelope_api->createRecipientView($account_id, $envelope_id, $recipient_view_request);
        } catch (ApiException $e) {
            $error_code = $e->getResponseBody()->errorCode;
            $error_message = $e->getResponseBody()->message;
            if ($error_code == "WORKFLOW_UPDATE_RECIPIENTROUTING_NOT_ALLOWED") {
                $GLOBALS['twig']->display('error_eg34.html', [
                        'error_code' => $error_code,
                        'error_message' => $error_message]
                );
            }
            else {
                $GLOBALS['twig']->display('error.html', [
                        'error_code' => $error_code,
                        'error_message' => $error_message]
                );
            }
            exit;
        }

        return $results;
    }

    /**
     * Redirect user to the error page
     *
     * @param  ApiException $e
     * @return void
     */
    public function showErrorTemplate(ApiException $e): void
    {
        $body = $e->getResponseBody();
        $GLOBALS['twig']->display('error.html', [
                'error_code' => $body->errorCode ?? unserialize($body)->errorCode,
                'error_message' => $body->message ?? unserialize($body)->message]
        );
    }

    /**
     * Redirect user to the 'success' page
     *
     * @param $title string
     * @param $headline string
     * @param $message string
     * @param $results
     * @return void
     */
    public function showDoneTemplate($title, $headline, $message, $results = null): void
    {
        $GLOBALS['twig']->display('example_done.html', [
            'title' => $title,
            'h1' => $headline,
            'message' => $message,
            'json' => $results
        ]);
        exit;
    }

    /**
     * Redirect user to the auth page
     *
     * @param $eg
     * @return void
     */
    public function needToReAuth($eg): void
    {
        $this->routerService->flash('Sorry, you need to re-authenticate.');
        # We could store the parameters of the requested operation
        # so it could be restarted automatically.
        # But since it should be rare to have a token issue here,
        # we'll make the user re-enter the form data after
        # authentication.
        $_SESSION['eg'] = $GLOBALS['app_url'] . 'index.php?page=' . $eg;
        header('Location: ' . $GLOBALS['app_url'] . 'index.php?page=must_authenticate');
        exit;
    }

    /**
     * Redirect user to the template page if !envelope_id
     *
     * @param $basename string
     * @param $template string
     * @param $title string
     * @param $eg string
     * @param $is_ok null|array
     * @return void
     */
    public function envelopeNotCreated($basename, $template, $title, $eg, $is_ok = null)
    {
        $conf = [
            'title' => $title,
            'source_file' => $basename,
            'source_url' => $GLOBALS['DS_CONFIG']['github_example_url'] . $basename,
            'documentation' => $GLOBALS['DS_CONFIG']['documentation'] . $eg,
            'show_doc' => $GLOBALS['DS_CONFIG']['documentation'],
        ];

        $GLOBALS['twig']->display($template, array_push($conf, $is_ok));
        exit;
    }

    /**
     *  Get the lis of the Brands
     *
     * @param  array $args
     * @return array $brands
     */
    public function getBrands($args): array
    {
        # Retrieve all brands using the AccountBrands::List
        $accounts_api = $this->getAccountsApi();
        try {
            $brands = $accounts_api->listBrands($args['account_id']);
        } catch (ApiException $e) {
            $this->showErrorTemplate($e);
            exit;
        }

        return $brands['brands'];
    }

    /**
     *  Get the lis of the Permission Profiles
     *
     * @param  array $args
     * @return array $brands
     */
    public function getPermissionsProfiles($args): array
    {
        # Retrieve all brands using the AccountBrands::List
        $accounts_api = $this->getAccountsApi();
        try {
            $brands = $accounts_api->listPermissions($args['account_id']);
        } catch (ApiException $e) {
            $this->showErrorTemplate($e);
            exit;
        }

        return $brands['permission_profiles'];
    }

    /**
     *  Get the lis of the Groups
     *
     * @param  array $args
     * @return array $brands
     */
    public function getGroups($args): array
    {
        # Retrieve all Groups using the GroupInformation::List
        $accounts_api = $this->getGroupsApi();
        try {
            $brands = $accounts_api->listGroups($args['account_id']);
        } catch (ApiException $e) {
            $this->showErrorTemplate($e);
            exit;
        }

        return $brands['groups'];
    }

    /**
     * Creates a customized html document for the envelope
     *
     * @param  $args array
     * @return string -- the html document
     */
    public function createDocumentForEnvelope(array $args, $type): string
    {
      if ($type == 'ssa') {
        return <<< heredoc
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <title>SSA-89</title>
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            </head>
            <style type="text/css">
                .card{
                    margin-bottom: 27px;
                    margin-top: 27px;
                }
                .vertical-line {
                  border-right: 1px solid #333;
                  margin-top: -16px;
                }
                h2{
                    font-size: 18px;
                    font-weight: 700;
                }
                hr {
                    margin-top: 1rem;
                    margin-bottom: 1rem;
                    border: 0;
                    border-top: 2px solid rgba(0,0,0,.1);
                    border-color: #00000070;
                }
            </style>
            <body>
                <div class="container">
                    <form action="index_submit" method="get" accept-charset="utf-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    Form <b>SSA-89</b> (12-2020)<br>
                                    Discontinue Prior Editions<br> 
                                    Social Security Administration
                                </div>
                                <div class="col-md-6"></div>
                                <div class="col-md-2">
                                    OMB No.0960-0760
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <h1 style="text-align: center;font-weight: 700;margin: 0px 60px 0px 60px;font-size: 36px;">Authorization for the Social Security Administration (SSA) To Release Social Security Number (SSN) Verification</h1>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4 vertical-line">
                                    <div class="form-group">
                                        <label for="fname">Printed Name:</label>
                                        <span style="color:white;">/sn1/</span>
                                    </div>
        
                                </div>
                                <div class="col-md-4 vertical-line">
        
                                    <div class="form-group">
                                        <label for="fname">Date of Birth:</label>
                                        <span style="color:white;">/sn2/</span>
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -16px;">
                                    <div class="form-group">
                                        <label for="fname">Social Security Number:</label>
                                        <span style="color:white;">/sn3/</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-check">
                                <h2>Reason for authorizing consent: (Please select one)</h2>
                                <div class="row" style="padding-right: 37px;padding-left: 37px;">
                                    <div class="col-md-4">
                                        <span style="color:white;">/sn4/</span>
                                        <label class="form-check-label" for="flexCheckChecked">
                                            To apply for a mortgage
                                        </label>
                                        <br>
                                        <span style="color:white;">/sn5/</span>
                                        <label class="form-check-label" for="flexCheckChecked2">
                                            To open a bank account
                                        </label>
                                        <br>
                                        <span style="color:white;">/sn6/</span>
                                        <label class="form-check-label" for="flexCheckChecked3">
                                            To apply for a credit card
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        
                                        <span style="color:white;">/sn7/</span>
                                        <label class="form-check-label" for="flexCheckChecked4">
                                            To apply for a loan
                                        </label>
                                        <br>
                                        <span style="color:white;">/sn8/</span>
                                        <label class="form-check-label" for="flexCheckChecked5">
                                            To open a retirement account
                                        </label>
                                        <br>
                                        <span style="color:white;">/sn9/</span>
                                        <label class="form-check-label" for="flexCheckChecked6">
                                            To apply for a job
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        
                                        <span style="color:white;">/sn10/</span>
                                        <label class="form-check-label" for="flexCheckChecked7">
                                            To meet a licensing requirement
                                        </label>
                                        <br>
        
                                        <span style="color:white;">/sn11/</span>
                                        <label class="form-check-label" for="flexCheckChecked8">
                                            Other
                                        </label>
        
                                        <span style="color:white;">/sn12/</span>
        
        
        
                                    </div>
                                </div>
        
                                <hr>
        
                                <div class="row">
                                        <label for="" class="col-md-4">With the following company ("the Company"):</label>
                                        <span style="color:white;">/sn13/</span>
                                        
                                </div>
        
                                <hr>
                                <div class="row">
                                        <label for="" class="col-md-4">Company Name:</label>
                                        <span style="color:white;">/sn14/</span>
                                        
                                </div>
        
                                <hr>
                                <div class="row">
                                        <label for="" class="col-md-4">Company Address:</label>
                                        <span style="color:white;">/sn15/</span>
                                        
                                </div>
        
                                <hr>
                                <div class="row">
                                        <label for="" class="col-md-4">The name and address of the Company's Agent (if applicable):</label>
                                        <span style="color:white;">/sn16/</span>
                                        
                                </div>
        
                                <hr>
                                <div class="row">
                                        <label for="" class="col-md-4">Agent's Name:</label>
                                        <span style="color:white;">/sn17/</span>
                                        
                                </div>
        
                                <hr>
                                <div class="row">
                                        <label for="" class="col-md-4">Agent's Address:</label>
                                        <span style="color:white;">/sn18/</span>
                                        
                                </div>
        
                                <hr>
        
                                <p>I authorize the Social Security Administration to verify my name and SSN to the Company and/or the Company's Agent, if applicable, for the purpose I identified. I am the individual to whom the Social Security number was issued or the parent or legal guardian of a minor, or the legal guardian of a legally incompetent adult. I declare and affirm under the penalty of perjury that the information contained herein is true and correct. I acknowledge that if I make any representation that I know is false to obtain information from Social Security records, I could be found guilty of a misdemeanor and fined up to $5,000.</p>
                                <br>
                                <h2>This consent is valid only for one-time use. This consent is valid only for 90 days from the date signed, unless indicated otherwise by the individual named above. Ifyou wish to change this timeframe, fill in the following:</h2>
                                <br>
        
                                <h2>This consent is valid for_____<span style="color:white;">/sn19/</span>_____days from the date signed._____<span style="color:white;">/sn20/</span>_____(Please initial.)</h2>
        
                                <hr>
        
                                <div class="row">
                                    <div class="col-md-8 vertical-line">
                                        <div class="form-group">
                                            <label for="fname">Signature:</label>
                                            <span style="color:white;">/sn21/</span>
                                        </div>
        
                                    </div>
                                    
                                    <div class="col-md-4" style="margin-top: -16px;">
        
                                        <div class="form-group">
                                            <label for="fname">Date Signed:</label>
                                            <span style="color:white;">/sn22/</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <label for="" class="col-md-6">Relationship (if not the individual to whom the SSN was issued):</label>
                                    <span style="color:white;">/sn23/</span>    
                                </div>
                                <hr>
                                <h2 style="margin-bottom: 15px;"><center>Privacy Act Statement Collection and Use of Personal Information</center></h2>
                                <p>
                                    Sections 205(a) and 1106 of the Social Security Act, as amended, allow us to collect this information. Furnishing us this information is voluntary. However, failing to provide all or part of the information may prevent us from releasing information to a designated company or company’s agent. We will use the information to verify your name and Social Security number (SSN). In addition, we may share this information in accordance with the Privacy Act and other Federal laws. For example, where authorized, we may use and disclose this information in computer matching programs, in which our records are compared with other records to establish or verify a person’s eligibility for Federal benefit programs and for repayment of incorrect or delinquent debts under these programs. A list of routine uses is available in our Privacy Act System of Records Notice (SORN) 60-0058, entitled Master Files of SSN Holders and SSN Applications. Additional information and a full listing of all our SORNs are available on our website at <a href="www.socialsecurity.gov/foia/bluebook">www.socialsecurity.gov/foia/bluebook</a>.
                                </p>
                                <br>
                                <p><b>Paperwork Reduction Act Statement - </b>This information collection meets the requirements of
        44 U.S.C. § 3507, as amended by section 2 of the Paperwork Reduction Act of 1995. You do not need to answer these
        questions unless we display a valid Office of Management and Budget control number. We estimate that it will take about 3 minutes to complete the form. You may send comments on our time estimate above to: SSA, 6401 Security Blvd., Baltimore, MD 21235-6401. <b><i>Send to this address only comments relating to our time estimate, not the completed form.</i></b></p>
        <center>----------------------------------------------------------------------TEAR OFF----------------------------------------------------------------------</center>
        <h2>NOTICE TO NUMBER HOLDER</h2>
        <p>
            The Company and/or its Agent have entered into an agreement with SSA that, among other things, includes restrictions on the further use and disclosure of SSA's verification of your SSN. To view a copy of the entire model agreement, visit <a href="http://www.ssa.gov/cbsv/docs/SampleUserAgreement.pdf">http://www.ssa.gov/cbsv/docs/SampleUserAgreement.pdf</a>.
        </p>
        <hr>   
                            </div>
                        </div>
                    </form>
                    </div>   
                        </body>
                    </html>
heredoc;
        }
        if ($type == 'adf') {
        return <<< heredoc
        <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Test html form</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</head>

	<style type="text/css">
		.card{
			margin-bottom: 27px;
			margin-top: 27px;
			text-align: justify;
		}
	</style>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-default">
						<div class="card-header">
							<h3 class="card-title"><center>Applicant Disclosure Statement</center></h3>
							<div class="card-tools">
							</div>
						</div>
						<div class="card-body">
							<p>In connection with your employment or application for employment (or contract for
								services) and any future employment (or contract for services) with Company
								(_______<span style="color:white;">/sn1/</span>________) and any subsidiary, you may have information requested about
								you from a consumer reporting agency in connection with your application for
								employment purposes. This information may be obtained in the form of background
								reports and/or investigative reports. These reports may be obtained at any time after
								receipt of your signed authorization and, if you are hired by Company, throughout your
								employment if permissible under applicable Company policy and/or state law.
								These reports may contain information about your character, general reputation
								and/or mode of living. The types of information that may be obtained include, but are
								not limited to: social security number verifications; address history; criminal records
								checks; public court records checks; driving records checks; employment history
								verifications; and professional licensing/certification checks. This information may be
								obtained from private and/or public records sources, including, as appropriate,
								governmental agencies and courthouses; educational institutions; former employers;
								or other information sources.
								If adverse action is taken resulting from information obtained, in whole or in part, from
								consumer reports and/or investigative reports, you will have the option to receive a
								copy of the report from Vetzu Inc can be contacted at 1700 Park Street, Suite 212,
							Naperville, IL-60563, USA or by phone at 630-635-8278 or by email at <a href="mailto:info@Vetzu.com?subject=feedback">info@Vetzu.com</a></p>
							
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="fname">Name:</label>
										<span style="color:white;">/sn2/</span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="fname">Signature:</label>
										<span style="color:white;">/sn3/</span>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="fname">Date:</label>
										<span style="color:white;">/sn4/</span>
									</div>
								</div>
								
							</div>
							
						</div>
						
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="card card-default">
						<div class="card-header">
							<h3 class="card-title"><center>Authorization of Background Investigation</center></h3>
							<div class="card-tools">
							</div>
						</div>
						<div class="card-body">
							<p>I have carefully read, and understand, this Authorization form and further acknowledge
								receipt of the separate document entitled “A Summary of Your Rights under the
								Fair Credit Reporting Act” and the “Applicant Disclosure Statement” and certify
								that I have read and understand both documents. By my signature below, I consent to
								the release of background reports and/or investigative background reports prepared
								by a background reporting agency, such as Vetzu Inc., to COMPANY and its
								designated representatives and agents for the purposes of determining my eligibility
								for employment, retention, or other lawful employment purposes. I understand that if
								COMPANY hires me, my consent will apply, and COMPANY may obtain background
								reports throughout my employment if permissible under applicable COMPANY policy.
								I understand that information contained in my employment application, or otherwise
								disclosed by me before, or during, my employment, if any, may be used for the
								purpose of obtaining background reports and/or investigative background reports. I
								also understand that nothing herein shall be construed as an offer of employment. I
								hereby authorize law enforcement agencies, educational institutions (including public
								and private schools/universities), information service bureaus, record/data
								repositories, courts (federal, state, and local), motor vehicle records agencies, my past
								or present employers, the military, and other information sources to furnish any, and
								all, information on me that is requested by the background reporting agency.
								Additional State Law Notices
								California, Oklahoma and Minnesota: You have the right to receive a copy of your background/investigative
								report by checking the box on the Authorization of Background Investigation below.
								California Applicants Only: I acknowledge receipt of a copy of California Civil Code 1786.22. Pursuant to
								Section 1786.22 of the California Civil Code, you may view the file maintained on you by Vetzu Inc, during
								normal business hours. You may also obtain a copy of this file, upon submitting proper identification by
								appearing at Vetzu's offices in person, during normal business hours and on reasonable notice, or by mail. You
								may also receive a summary of the file by telephone, upon submitting proper identification. Vetzu has trained
								personnel available to explain your file to you, including any coded information. By signing below, you
								acknowledge receipt of California Civil Code 1786.22.
								Massachusetts and New Jersey: If we request an investigative background report, you have the right, upon written
								request, to a copy of the report.
								New York Applicants Only: I acknowledge receipt of a copy of Article 23-A of New York Correction
								Law.
								By signing below, you acknowledge receipt of Article 23-A of the New York Correction Law.
								Washington State: If COMPANY requests an investigative background report, you have the right, upon written
								request made within a reasonable period of time after your receipt of this disclosure, to receive from COMPANY
								a complete and accurate disclosure of the nature and scope of the investigation requested by COMPANY. You
								also have the right to request from the consumer reporting agency a written summary of your rights and remedies
								under the Washington Fair Credit Reporting Act.
								By my signature below, I certify the information I provided on, and in connection with, this form is true, accurate,
								and complete. I agree that this Disclosure and Authorization form in original, facsimile, photocopy, or electronic
								(including electronically signed) formats, will be valid for any reports that may be requested by, or on behalf of,
							COMPANY.</p>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="card card-default">
						<div class="card-header">
							<h3 class="card-title"><center>Authorization of Background Investigation</center></h3>
							<div class="card-tools">
							</div>
						</div>
						<div class="card-body">
							<h3>California, Minnesota or Oklahoma applicants only:</h3>
							<p>you may recieve a free copy of any consumer report or investigative consumer report obtained on you if you check the box bellow.</p>
							<div class="form-check">
								<span style="color:white;">/sn5/</span>
								<label class="form-check-label" for="flexCheckChecked">
									I wish to receive a free copy of the report.
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title"><center>Fill this form</center></h3>
					<div class="card-tools">
						<!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button> -->
						<!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button> -->
					</div>
				</div>
				<!-- /.card-header -->
				<div class="card-body">
					<div id="error-message"></div>
					<div id="success-message"></div>
					<form id="add_user">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fname">First Name:</label>
									<span style="color:white;">/sn6/</span>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="lname">Middle/Last Name:</label>
									<span style="color:white;">/sn7/</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="username">Address</label>
									<span style="color:white;">/sn8/</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label>City:</label>
									<span style="color:white;">/sn9/</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>State:</label>
									<span style="color:white;">/sn10/</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Zip Code:</label>
									<span style="color:white;">/sn11/</span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Social Security Number(SSN):</label>
									<span style="color:white;">/sn12/</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Date of Birth:</label>
									<span style="color:white;">/sn13/</span>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Driving license Number:</label>
									<span style="color:white;">/sn14/</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>State of issue:</label>
									<span style="color:white;">/sn15/</span>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Signature:</label>
									<span style="color:white;">/sn16/</span>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Date:</label>
									<span style="color:white;">/sn17/</span>
								</div>
							</div>
							
						</div>
					</form>
					<!-- /.row -->
					</div><!-- /.container-fluid -->
					
				</body>
			</html>
heredoc;
        }
        if ($type == 'scr') {
            return <<< heredoc
            <!DOCTYPE html>
            <html>
            <head>
            <style>
            body{
                width:70%;
                margin-left: auto;
                margin-right: auto;
            }
            .contactTable {
                border: 2px solid #d4d4d4;
                border-collapse: collapse; 
            }

            .contactTable td {
                border: 2px solid #d4d4d4;
                border-collapse: collapse; 
            }

            tr {
                border: 2px solid #d4d4d4;
                border-collapse: collapse;
            }

            th {
                background-color: #d4d4d4;
                text-align: center;
            }

            .content {
                margin: 150 auto;
                font-family: serif;
            }

            @page {
                size: 7in 9.25in;
                margin: 27mm 16mm 27mm 16mm;
            }
            </style>


            </head>
            <body>

            <table>
            <tr>
            <th>

            Summary of Consumer Rights Under the Fair Credit Reporting Act


            </th>
            </tr><tr>
            <td>
            <p>
            The federal <b>Fair Credit Reporting Act (FCRA)</b> promotes the accuracy, fairness, and privacy of information in the files of consumer reporting agencies. There are many types of consumer reporting agencies, including credit bureaus and specialty agencies (such as agencies that sell information about check writing histories, medical records, and rental history records). Here is a summary of your major rights under the FCRA. <b> For more information, including information about additional rights, go to:<u> www.consumerfinance.gov/learnmore </u> or write to: Consumer Financial Protection Bureau, 1700 G Street N.W., Washington, DC 20552.</b>
            </p>

            <ul>
            <li><b>You must be told if information in your file has been used against you.</b> Anyone who uses a credit report or another type of consumer report to deny your application for credit, insurance, or employment�or to take another adverse action against you�must tell you, and must give you the name, address, and phone number of the agency that provided the information.</li>
            <li><b>You have the right to know what is in your file.</b> You may request and obtain all the information about you in the files of a consumer reporting agency (your �file disclosure�). You will be required to provide proper identification, which may include your Social</li>
            <li>a person has taken adverse action against you because of information in your credit report;</li>
            <li>you are the victim of identity theft and place a fraud alert in your file;</li>
            <li>your file contains inaccurate information as a result of fraud;</li>
            <li>you are on public assistance;</li>
            <li>you are unemployed but expect to apply for employment within 60 days.</li>
            In addition, all consumers are entitled to one free disclosure every 12 months upon request from each nationwide Credit Bureau and from nationwide specialty consumer reporting agencies. See <u>www.consumerfinance.gov/learnmore</u> for additional information.

            <li><b>You have the right to ask for a credit score.</b> Credit scores are numerical summaries of your credit-worthiness based on information from credit bureaus. You may request a credit score from consumer reporting agencies that create scores or distribute scores used in residential real property loans, but you will have to pay for it. In some mortgage transactions, you will receive credit score information for free from the mortgage lender.</li>
            <li><b>You have the right to dispute incomplete or inaccurate information.</b> If you identify information in your file that is incomplete or inaccurate, and report it to the consumer reporting agency, the agency must investigate unless your dispute is frivolous. See <u>www.consumerfinance.gov/learnmore</u> for an explanation of dispute procedures.</li>
            <li><b>Consumer reporting agencies must correct or delete inaccurate, incomplete, or unverifiable information.</b> Inaccurate, incomplete or unverifiable information must be removed or corrected, usually within 30 days. However, a consumer reporting agency may continue to report information it has verified as accurate.</li>
            <li><b>Consumer reporting agencies may not report outdated negative information.</b> In most cases, a consumer reporting agency may not report negative information that is more than seven years old, or bankruptcies that are more than 10 years old.</li>
            <li><b>Access to your file is limited.</b> A consumer reporting agency may provide information about you only to people with a valid need -- usually to consider an application with a creditor, insurer, employer, landlord, or other business. The FCRA specifies those with a valid need for access.</li>
            <li><b>You must give your consent for reports to be provided to employers.</b> A consumer reporting agency may not give out information about you to your employer, or a potential employer, without your written consent given to the employer. Written consent generally is not required in the trucking industry. For more information, go to <u>www.consumerfinance.gov/learnmore.</u></li>
            <li><u>You may limit �prescreened� offers of credit and insurance you get based on information in
            your credit report.</u> Unsolicited �prescreened offers� for credit and insurance must include a toll-free phone number you can call if you choose to remove your name and address from the lists these offers are based on. You may opt-out with the nationwide credit bureaus at 1-888-567-8688.</li>
            <li><b>The following FCRA right applies with respect to nationwide consumer reporting agencies:</b></li>
            </ul>

            </td>

            </tr>
            <tr><th>CONSUMERS HAVE THE RIGHT TO OBTAIN A SECURITY FREEZE</th></tr>
            <tr>
            <td>
            <b>You have a right to place a �security freeze� on your credit report, which will prohibit a consumer reporting agency from releasing information in your credit report without your express authorization.</b> The security freeze is designed to prevent credit, loans, and services from being approved in your name without your consent. However, you should be aware
            that using a security freeze to take control over who gets access to the personal and financial information in your credit report may delay, interfere with, or prohibit the timely approval of any subsequent request or application you make regarding a new loan, credit, mortgage, or any other account involving the extension of credit.
            </td>
            </tr>
            <tr>
            <td>
            As an alternative to a security freeze, you have the right to place an initial or extended fraud alert on your credit file at no cost. An initial fraud alert is a 1-year alert that is placed on a consumer�s credit file. Upon seeing a fraud alert display on a consumer�s credit file, a business is required to take steps to verify the consumer�s identity before extending new credit. If you are a victim of identity theft, you are entitled to an extended fraud alert, which is a fraud alert lasting 7 years.
            <br>
            A security freeze does not apply to a person or entity, or its affiliates, or collection agencies acting on behalf of the person or entity, with which you have an existing account that requests information in your credit report for the purposes of reviewing or collecting the account. Reviewing the account includes activities related to account maintenance, monitoring, credit line increases, and account upgrades and enhancements.
            </td>
            </tr>
            <tr>
            <td>
            <ul>
            <li><b>You may seek damages from violators.</b> If a consumer reporting agency, or, in some cases, a user of consumer reports or a furnisher of information to a consumer reporting agency violates the FCRA, you may be able to sue in state or federal court.</li>
            <li><b>Identity theft victims and active duty military personnel have additional rights.</b> For more information, visit www.consumerfinance.gov/learnmore.</li>
            <li><b>States may enforce the FCRA, and many states have their own consumer reporting laws. In some cases, you may have more rights under state law. For more information, contact your state or local consumer protection agency or your state Attorney General. For information about your federal rights, contact</b></li>

            </ul>

            </td>

            </tr>
            </table>


            <table class="contactTable">
            <tr>
            <th width="50%">TYPE OF BUSINESS:</th>
            <th width="50%">CONTACT:</th>
            </tr>
            <tr>
            <td>
            1.a. Banks, savings associations, and credit unions with total assets of over $10 billion and their affiliates<br><br>
            b. Such affiliates that are not banks, savings associations, or credit unions also should list, in addition to the CFPB:

            </td>
            <td>
            a. Consumer Financial Protection Bureau<br>
            1700 G Street NW<br>
            Washington, DC 20552<br><br>
            b. Federal Trade Commission: Consumer Response Center--FCRA<br>
            Washington, DC 20580<br>
            (877) 382- 4357<br>
            </td>
            </tr>

            <tr>
            <td>
            2. To the extent not included in item 1 above:<br>
            a. National banks, federal savings associations, and federal branches and federal agencies of foreign banks<br><br>
            b. State member banks, branches and agencies of foreign banks (other than federal branches, federal agencies, and Insured State Branches of Foreign Banks), commercial lending companies owned or controlled by foreign banks, and organizations operating under section 25 or 25A of the Federal Reserve Act<br><br>
            c. Nonmember Insured Banks, Insured State Branches of Foreign
            Banks, and insured state savings associations<br><br>
            d. Federal Credit Unions
            </td>
            <td>

            a. Office of the Comptroller of the Currency<br>
            Customer Assistance Group<br>
            1301 McKinney Street, Suite 3450<br><br>
            Houston, TX 77010-9050<br>
            b. Federal Reserve Consumer Help Center<br>
            P.O. Box 1200<br>
            Minneapolis, MN 55480<br><br>
            c. FDIC Consumer Response Center<br>
            1100 Walnut Street, Box #11<br>
            Kansas City, MO 64106<br><br>
            d. National Credit Union Administration<br>
            Office of Consumer Protection (OCP)<br>
            Division of Consumer Compliance and Outreach (DCCO)<br>
            1775 Duke Street<br>
            Alexandria, VA 22314<br>

            </td>
            </tr>

            <tr>
            <td>3. Air carriers</td>
            <td>
            Asst. General Counsel for Aviation Enforcement & Proceedings<br>
            Aviation Consumer Protection Division<br>
            Department of Transportation<br>
            1200 New Jersey Avenue, S.E.<br>
            Washington, DC 20590<br>
            </td>
            </tr>

            <tr>
            <td>4. Creditors Subject to the Surface Transportation Board</td>
            <td>
            Office of Proceedings, Surface Transportation Board<br>
            Department of Transportation<br>
            395 E. Street, S.W.<br>
            Washington, DC 20423
            </td>
            </tr>

            <tr>
            <td>5. Creditors Subject to Packers and Stockyards Act, 1921</td>
            <td>Nearest Packers and Stockyards Administration area supervisor</td>
            </tr>

            <tr>
            <td>6. Small Business Investment Companies</td>
            <td>
            Associate Deputy Administrator for Capital Access<br>
            United States Small Business Administration<br>
            409 Third Street, SW, 8th Floor<br>
            Washington, DC 20416<br>
            </td>
            </tr>

            <tr>
            <td>7. Brokers and Dealers</td>
            <td>
            Securities and Exchange Commission<br>
            100 F St., N.E.<br>
            Washington, DC 20549<br>
            </td>
            </tr>

            <tr>
            <td>
            8. Federal Land Banks, Federal Land Bank Associations, Federal<br>
            Intermediate Credit Banks, and Production Credit Associations
            </td>
            <td>
            Farm Credit Administration<br>
            1501 Farm Credit Drive<br>
            McLean, VA 22102-5090<br>
            </td>
            </tr>

            <tr>
            <td>
            9. Retailers, Finance Companies, and All Other Creditors Not Listed Above
            </td>
            <td>
            FTC Regional Office for region in which the creditor operates or<br>
            Federal Trade Commission: Consumer Response Center � FCRA<br>
            Washington, DC 20580<br>
            (877) 382-4357
            </td>
            </tr>

            </table>

            <table>
            <tr><th>Notice of Users of Consumer Reports: Obligations of Users under FCRA</th></tr>
            <tr>
            <td><b>All users of consumer reports must comply with all applicable regulations. Information about applicable regulations currently in effect can be found at the Consumer Financial Protection Bureau�s website,<u> www.consumerfinance.gov/learnmore.</u></b></td>
            </tr>

            <tr>
            <td>The Fair Credit Reporting Act (FCRA), 15 U.S.C. �1681-1681y, requires that this notice be provided to inform users of consumer reports of their legal obligations. State law may impose additional requirements. The text of the FCRA is set forth in full at the Consumer Financial Protection Bureau�s (CFPB) website at <u>www.consumerfinance.gov/learnmore</u>. At the end of this document is a list of United States Code citations for the FCRA. Other information about user duties is also available at the CFPB�s website. <b>Users must consult the relevant provisions of the FCRA for details about their obligations under the FCRA.</b></td>
            </tr>

            <tr>
            <td>The first section of this summary sets forth the responsibilities imposed by the FCRA on all users of consumer reports. The subsequent sections discuss the duties of users of reports that contain specific types of information, or that are used for certain purposes, and the legal consequences of violations. If you are a furnisher of information to a consumer reporting agency (CRA), you have additional obligations and will receive a separate notice from the CRA describing your duties as a furnisher.</td>
            </tr>

            </table>

            <table>
            <tr>
            <td><b>I. OBLIGATIONS OF ALL USERS OF CONSUMER REPORTS</b></td>
            </tr>

            <tr>
            <td><u><b>A. Users Must Have a Permissible Purpose</b></u></td>
            </tr>

            <tr>
            <td>Congress has limited the use of consumer reports to protect consumers� privacy. All users must have a permissible purpose under the FCRA to obtain a consumer report. Section 604 contains a list of the permissible purposes under the law. These are:</td>
            </tr>

            <tr>
            <td>
            <ul>
                <li>As ordered by a court or a federal grand jury subpoena. <u>Section 604(a)(1)</u></li>
                <li>As instructed by the consumer in writing. <u>Section 604(a)(2)</u></li>
                <li>For the extension of credit as a result of an application from a consumer, or the review or collection of a consumer�s account. <u>Section 604(a)(3)(A)</u></li>
                <li>For employment purposes, including hiring and promotion decisions, where the consumer has given written permission. Sections 604(a)(3)(B) and 604(b)</li>
                <li>For the underwriting of insurance as a result of an application from a consumer. <u>Section 604(a)(3)(C)</u></li>
                <li>When there is a legitimate business need, in connection with a business transaction that is initiated by the consumer. <u>Section 604(a)(3)(F)(i)</u></li>
                <li>To review a consumer�s account to determine whether the consumer continues to meet the terms of the account. <u>Section 604(a)(3)(F)(ii)</u></li>
                <li>To determine a consumer�s eligibility for a license or other benefit granted by a governmental instrumentality required by law to consider an applicant�s financial responsibility or status. <u>Section 604(a)(3)(D)</u></li>
                <li>For use by a potential investor or servicer, or current insurer, in a valuation or assessment of the credit or prepayment risks associated with an existing credit obligation. <u>Section 604(a)(3)(E)</u></li>
                <li>For use by state and local officials in connection with the determination of child support payments, or modifications and enforcement thereof. <u>Sections 604(a)(4) and 604(a)(5)</u></li>
            </ul>

            </td>
            </tr>

            <tr>
            <td>In addition, creditors and insurers may obtain certain consumer report information for the purpose of making �prescreened� unsolicited offers of credit or insurance. <u>Section 604(c)</u>. The particular obligations of users of �prescreened� information are described in Section II below.</td>
            </tr>
            </table>

            <table>
            <tr>
            <td><b><u>B. Users Must Provide Certifications</u></b></td>
            </tr>

            <tr>
            <td>Section 604(f) prohibits any person from obtaining a consumer report from a consumer reporting agency (CRA) unless the person has certified to the CRA the permissible purpose(s) for which the report is being obtained and certifies that the report will not be used for any other purpose.</td>
            </tr>
            </table>

            <table>
            <tr>
                <td><b><u>C. Users Must Notify Consumers When Adverse Actions Are Taken</u></b></td>
            </tr>
            <tr>
                <td>The term �adverse action� is defined very broadly by Section 603. �Adverse actions� include all business, credit, and employment actions affecting consumers that can be considered to have a negative impact as defined by Section 603(k) of the FCRA � such as denying or canceling credit or insurance, or denying employment or promotion. No adverse action occurs in a credit transaction where the creditor makes a counteroffer that is accepted by the consumer.</td>
            </tr>
            <tr>
                <td><b>1. Adverse Actions Based on Information Obtained From a CRA</b></td>
            </tr>
            <tr>
                <td>If a user takes any type of adverse action as defined by the FCRA that is based at least in part on information contained in a consumer report, Section 615(a) requires the user to notify the consumer. The notification may be done in writing, orally, or by electronic means. It must include the following:</td>
            </tr>

            <tr>
                <td>
                <ul><li>The name, address, and telephone number of the CRA (including a toll-free telephone number, if it is a nationwide CRA) that provided the report.</li>
                <li>A statement that the CRA did not make the adverse decision and is not able to explain why the decision was made.</li>
                <li>A statement setting forth the consumer�s right to obtain a free disclosure of the consumer�s file from the CRA if the consumer makes a request within 60 days.</li>
                <li>A statement setting forth the consumer�s right to dispute directly with the CRA the accuracy or completeness of any information provided by the CRA.</li>
                </ul>
                
                </td>
            </tr>
            <tr>
                <td><b>2. Adverse Actions Based on Information Obtained From Third Parties Who Are Not Consumer Reporting Agencies</b></td>
            </tr>

            <tr>
                <td>If a person denies (or increases the charge for) credit for personal, family, or household purposes based either wholly or partly upon information from a person other than a CRA, and the information is the type of consumer information covered by the FCRA, Section 615(b)(1) requires that the user clearly and accurately disclose to the consumer his or her right to be told the nature of the information that was relied upon if the consumer makes a written request within 60 days of notification. The user must provide the disclosure within a reasonable period of time following the consumer�s written request.</td>
            </tr>

            <tr>
                <td><b>3. Adverse Actions Based on Information Obtained From Affiliates</b></td>
            </tr>

            <tr>
                <td>If a person takes an adverse action involving insurance, employment, or a credit transaction initiated by the consumer, based on information of the type covered by the FCRA, and this information was obtained from
            an entity affiliated with the user of the information by common ownership or control, Section 615(b)(2) requires the user to notify the consumer of the adverse action. The notice must inform the consumer that he or she may obtain a disclosure of the nature of the information relied upon by making a written request within 60 days of receiving the adverse action notice. If the consumer makes such a request, the user must disclose the nature of the information not later than 30 days after receiving the request. If consumer report information is shared among affiliates and then used for an adverse action, the user must make an adverse action disclosure as set forth in I.C.1 above.</td>
            </tr>

            <tr>
                <td><b><u>D. Users Have Obligations When Fraud and Active Duty Military Alerts are in Files</u></b></td>
            </tr>

            <tr>
                <td>When a consumer has placed a fraud alert, including one relating to identity theft, or an active duty military alert with a nationwide consumer reporting agency as defined in Section 603(p) and resellers, Section 605A(h) imposes limitations on users of reports obtained from the consumer reporting agency in certain circumstances, including the establishment of a new credit plan and the issuance of additional credit cards. For initial fraud alerts and active duty alerts, the user must have reasonable policies and procedures in place to form a belief that the user knows the identity of the applicant or contact the consumer at a telephone number specified by the consumer; in the case of extended fraud alerts, the user must contact the consumer in accordance with the contact information provided in the consumer�s alert.</td>
            </tr>


            <tr>
                <td><b><u>E. Users Have Obligations When Notified of an Address Discrepancy</u></b></td>
            </tr>

            <tr>
                <td>Section 605(h) requires nationwide CRAs, as defined in Section 603(p), to notify users that request reports when the address for a consumer provided by the user in requesting the report is substantially different from the addresses in the consumer�s file. When this occurs, users must comply with regulations specifying the procedures to be followed. Federal regulations are available at <u>www.consumerfinance.gov/learnmore</u>.</td>
            </tr>

            <tr>
                <td><b><u>F. Users Have Obligations When Disposing of Records</u></b></td>
            </tr>

            <tr>
                <td>Section 628 requires that all users of consumer report information have in place procedures to properly dispose of records containing this information. Federal regulations are available at www.consumerfinance.gov/learnmore.</td>
            </tr>



            </table>

            <table>
            <tr>
                <td><b>II. CREDITORS MUST MAKE ADDITIONAL DISCLOSURES</b></td>
            </tr>

            <tr>
                <td>If a person uses a consumer report in connection with an application for, or a grant, extension, or provision of, credit to a consumer on material terms that are materially less favorable than the most favorable terms available to a substantial proportion of consumers from or through that person, based in whole or in part on a consumer report, the person must provide a risk-based pricing notice to the consumer in accordance with regulations prescribed by the CFPB.</td>
            </tr>

            <tr>
                <td>Section 609(g) requires a disclosure by all persons that make or arrange loans secured by residential real property (one to four units) and that use credit scores. These persons must provide credit scores and other information about credit scores to applicants, including the disclosure set forth in Section 609(g)(1)(D) (�Notice to the Home Loan Applicant�).</td>
            </tr>

            </table>

            <table>
            <tr>
                <td><b>III. OBLIGATIONS OF USERS WHEN CONSUMER REPORTS ARE OBTAINED FOR EMPLOYMENT PURPOSES</b></td>
            </tr>

            <tr>
                <td><b><u>A. Employment Other Than in the Trucking Industry</u></b></td>
            </tr>

            <tr>
                <td>If the information from a CRA is used for employment purposes, the user has specific duties, which are set forth in Section 604(b) of the FCRA. The user must:</td>
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                <td>
                    <ul><li>Make a clear and conspicuous written disclosure to the consumer before the report is obtained, in a document that consists solely of the disclosure, that a consumer report may be obtained.</li>
                    <li>Obtain from the consumer prior written authorization. Authorization to access reports during the term of employment may be obtained at the time of employment.</li>
                    <li>Certify to the CRA that the above steps have been followed, that the information being obtained will not be used in violation of any federal or state equal opportunity law or regulation, and that, if any adverse action is to be taken based on the consumer report, a copy of the report and a summary of the consumer�s rights will be provided to the consumer.</li>
                    <li>Before taking an adverse action, the user must provide a copy of the report to the consumer as well as the summary of consumer�s rights (The user should receive this summary from the CRA.) A Section 615(a) adverse action notice should be sent after the adverse action is taken.</li>
                    </ul>
                </td>
            </tr>

            <tr>
                <td>An adverse action notice also is required in employment situations if credit information (other than transactions and experience data) obtained from an affiliate is used to deny employment. Section 615(b)(2).</td>
            </tr>

            <tr>
                <td>The procedures for investigative consumer reports and employee misconduct investigations are set forth below.</td>
            </tr>

            <tr>
                <td><b><u>B. Employment in the Trucking Industry</u></b></td>
            </tr>

            <tr>
                <td>Special rules apply for truck drivers where the only interaction between the consumer and the potential employer is by mail, telephone, or computer. In this case, the consumer may provide consent orally or electronically, and an adverse action may be made orally, in writing, or electronically. The consumer may obtain a copy of any report relied upon by the trucking company by contacting the company.</td>
            </tr>

            </table>

            <table>
            <tr>
                <td><b>IV. OBLIGATIONS WHEN INVESTIGATIVE CONSUMER REPORTS ARE USED</b></td>
            </tr>

            <tr>
                <td>Investigative consumer reports are a special type of consumer report in which information about a consumer�s character, general reputation, personal characteristics, and mode of living is obtained through personal interviews by an entity or person that is a consumer reporting agency. Consumers who are the subjects of such reports are given special rights under the FCRA. If a user intends to obtain an investigative consumer report, Section 606 requires the following:</td>
            </tr>

            <tr>
                <td>
                    <ul>
                        <li>The user must disclose to the consumer that an investigative consumer report may be obtained. This must be done in a written disclosure that is mailed, or otherwise delivered, to the consumer at some time before or not later than three days after the date on which the report was first requested. The disclosure must include a statement informing the consumer of his or her right to request additional disclosures of the nature and scope of the investigation as described below, and the summary of consumer rights required by Section 609 of the FCRA. (The summary of consumer rights will be provided by the CRA that conducts the investigation.)</li>
                        <li>The user must certify to the CRA that the disclosures set forth above have been made and that the user will make the disclosure described below. Upon the written request of a consumer made within a reasonable period of time after the disclosures required above, the user must make a complete disclosure of the nature and scope of the investigation. This must be made in a written statement that is mailed or otherwise delivered, to the consumer no later than five days after the date on which the request was received from the consumer or the report was first requested, whichever is later in time.</li>
                    </ul>
                </td>
            </tr>

            </table>

            <table>
            <tr>
                <td><b>V. SPECIAL PROCEDURES FOR EMPLOYEE INVESTIGATIONS</b></td>
            </tr>

            <tr>
                <td>Section 603(x) provides special procedures for investigations of suspected misconduct by an employee or for compliance with Federal, state or local laws and regulations or the rules of a self-regulatory organization, and compliance with written policies of the employer. These investigations are not treated as consumer reports so long as the employer or its agent complies with the procedures set forth in Section 603(x), and a summary describing the nature and scope of the inquiry is made to the employee if an adverse action is taken based on the investigation. </td>
            </tr>
            </table>
            <table>
            <tr>
                <td><b>VI. OBLIGATIONS OF USERS OF MEDICAL INFORMATION</b></td>
            </tr>
            <tr>
                <td>Section 604(g) limits the use of medical information obtained from consumer reporting agencies (other than payment information that appears in a coded form that does not identify the medical provider). If the information is to be used for an insurance transaction, the consumer must give consent to the user of the report or the information must be coded. If the report is to be used for employment purposes � or in connection with a credit transaction (except as provided in federal regulations) � the consumer must provide specific written consent and the medical information must be relevant. Any user who receives medical information shall not disclose the information to any other person (except where necessary to carry out the purpose for which the information was disclosed, or as permitted by statute, regulation, or order).</td>
            </tr>

            </table>

            <table>
            <tr>
                <td><b>VII. OBLIGATIONS OF USERS OF �PRESCREENED� LISTS</b></td>
            </tr>

            <tr>
                <td>The FCRA permits creditors and insurers to obtain limited consumer report information for use in connection with unsolicited offers of credit or insurance under certain circumstances. Sections 603(1), 604(c), 604(e), and 614(d). This practice is known as �preConsumer� and typically involves obtaining from a CRA a list of consumers who meet certain pre-established criteria. If any person intends to use prescreened lists, that person must (1) before the offer is made, establish the criteria that will be relied upon to make the offer and grant credit or insurance, and (2) maintain such criteria on file for a three-year period beginning on the date on which the offer is made to each consumer. In addition, any user must provide with each written solicitation a clear and conspicuous statement that:</td>
            </tr>

            <tr>
                <td>
                    <ul>
                        <li>Information contained in a consumer�s CRA file was used in connection with the transaction.</li>
                        <li>The consumer received the offer because he or she satisfied the criteria for credit worthiness or insurability used to screen for the offer.</li>
                        <li>Credit or insurance may not be extended if, after the consumer responds, it is determined that the consumer does not meet the criteria used for Consumer or any applicable criteria bearing on credit worthiness or insurability, or the consumer does not furnish required collateral.</li>
                        <li>The consumer may prohibit the use of information in his or her file in connection with future prescreened offers of credit or insurance by contacting the notification system established by the CRA that provided the report. The statement must include the address and toll-free telephone number of the appropriate notification system.</li>
                        <li>In addition, the CFPB has established the format, type size, and manner of the disclosure required by Section 615(d), with which users must comply. The regulation is 12 CFR 1022.54.</li>
                    </ul>
                </td>
            </tr>
            </table>

            <table>
            <tr>
                <td><b>VIII. OBLIGATIONS OF RESELLERS</b></td>
            </tr>
            <tr>
                <td><b><u>A. Disclosure and Certification Requirements</u></b></td>
            </tr>
            <tr>
                <td>Section 607(e) requires any person who obtains a consumer report for resale to take the following steps:</td>
            </tr>

            <tr>
                <td>
                    <ul>
                        <li>Disclose the identity of the end-user to the source CRA.</li>
                        <li>Identify to the source CRA each permissible purpose for which the report will be furnished to the end-user.</li>
                        <li>Establish and follow reasonable procedures to ensure that reports are resold only for permissible purposes, including procedures to obtain:
                        <br>
                        (1) the identity of all end-users;
                        <br>
                        (2) certifications from all users of each purpose for which reports will be used; and
                        <br>
                        (3) certifications that reports will not be used for any purpose other than the purpose(s) specified to the reseller. Resellers must make reasonable efforts to verify this information before selling the report.
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <td><b><u>B. Reinvestigations by Resellers</u></b></td>
            </tr>

            <tr>
                <td>Under Section 611(f), if a consumer disputes the accuracy or completeness of information in a report prepared by a reseller, the reseller must determine whether this is a result of an action or omission on its part and, if so, correct or delete the information. If not, the reseller must send the dispute to the source CRA for reinvestigation. When any CRA notifies the reseller of the results of an investigation, the reseller must immediately convey the information to the consumer.</td>
            </tr>

            <tr>
                <td><b><u>C. Fraud Alerts and Resellers</u></b></td>
            </tr>
            <tr>
                <td>Section 605A(f) requires resellers who receive fraud alerts or active duty alerts from another consumer reporting agency to include these in their reports.</td>
            </tr>
            </table>

            <table>
            <tr>
                <td><b>IX. LIABILITY FOR VIOLATIONS OF THE FCRA</b></td>
            </tr>

            <tr>
                <td>Failure to comply with the FCRA can result in state government or federal government enforcement actions, as well as private lawsuits. Sections 616, 617, and 621. In addition, any person who knowingly and willfully obtains a consumer report under false pretenses may face criminal prosecution. Section 619.</td>
            </tr>

            <tr>
                <td><b>The CFPB�s website, <u>www.consumerfinance.gov/learnmore</u>, has more information about the FCRA, including publications for businesses and the full text of the FCRA.</b></td>
            </tr>
            </table>
            <br><br>
            <span style="color:white;">/sn1/</span>

            </body>
            </html>
    heredoc;
        }
        if ($type == 'anaf') {
            return <<< heredoc
            <!DOCTYPE html>
            <html>
            <head>
            <style>
            body{
                width:70%;
                margin-left: auto;
                margin-right: auto;
            }
            table {
                border: 2px solid #d4d4d4;
                border-collapse: collapse;
            }

            tr {
                border: 2px solid #d4d4d4;
                border-collapse: collapse;
            }

            th {
                background-color: #d4d4d4;
                text-align: left;
            }

            .content {
                margin: 150 auto;
                font-family: serif;
            }

            @page {
                size: 7in 9.25in;
                margin: 27mm 16mm 27mm 16mm;
            }
            </style>


            </head>



            <body>
            <br>
                <div class="content">
                    <table width="100%">
                        <tr>
                            <th colspan=8>APPLICANT INFORMATION</th>
                        </tr>
                        <tr>
                            <td>Last Name</td>
                            <td><span style="color:white;">/sn1/</span></td>
                            <td>First Name</td>
                            <td><span style="color:white;">/sn2/</span></td>
                            <td>M.I.</td>
                            <td><span style="color:white;">/sn3/</span></td>
                            <td>Date</td>
                            <td><span style="color:white;">/sn4/</span></td>
                        </tr>

                        <tr>
                            <td>Street Address</td>
                            <td><span style="color:white;">/sn5/</span></td>
                            <td>Apartment/Unit #</td>
                            <td><span style="color:white;">/sn6/</span></td>
                        </tr>


                        <tr>
                            <td>City</td>
                            <td><span style="color:white;">/sn7/</span></td>
                            <td>Prov./State</td>
                            <td><span style="color:white;">/sn8/</span></td>
                            <td>Postal Code</td>
                            <td><span style="color:white;">/sn9/</span></td>
                        </tr>


                        <tr>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn10/</span></td>
                            <td>E-mail Address</td>
                            <td><span style="color:white;">/sn11/</span></td>
                        </tr>


                        <tr>
                            <td>Date of Birth</td>
                            <td><span style="color:white;">/sn12/</span></td>
                            <td>Social Sec. #</td>
                            <td><span style="color:white;">/sn13/</span></td>
                            <td>Position Applied for</td>
                            <td><span style="color:white;">/sn14/</span></td>
                        </tr>

                        <tr>
                            <td>Are you a U.S. citizen?</td>
                            <td></td>
                            <td><span style="color:white;">/sn15/</span></td>
                            <td></td>
                            <td>If no, explain</td>
                            <td><span style="color:white;">/sn16/</span></td>
                        </tr>

                        <tr>
                            <td>Have you ever been convicted of a felony?</td>
                            <td></td>
                            <td><span style="color:white;">/sn17/</span></td>
                            <td></td>
                            <td>If yes, explain</td>
                            <td><span style="color:white;">/sn18/</span></td>
                        </tr>

                    </table>
                <br>

                    <table width="100%">
                        <tr>
                            <th colspan=6>EDUCATION</th>
                        </tr>


                        <tr>
                            <td>High School</td>
                            <td><span style="color:white;">/sn19/</span></td>
                            <td>Did you graduate?</td>
                            <td><span style="color:white;">/sn20/</span></td>
                            <td>Diploma</td>
                            <td><span style="color:white;">/sn21/</span></td>
                        </tr>

                        <tr>
                            <td>School Name & Address</td>
                            <td colspan=5><span style="color:white;">/sn22/</span></td>
                        </tr>

                        <tr>
                            <td>College/University</td>
                            <td><span style="color:white;">/sn23/</span></td>
                            <td>Did you graduate?</td>
                            <td><span style="color:white;">/sn24/</span></td>
                            <td>Degree</td>
                            <td><span style="color:white;">/sn25/</span></td>
                        </tr>

                        <tr>
                            <td>University Name & Address</td>
                            <td colspan=5><span style="color:white;">/sn26/</span></td>
                        </tr>

                    </table>

            <br>
                    <table width="100%">
                        <tr>
                            <th colspan=6>REFERENCES</th>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td><span style="color:white;">/sn27/</span></td>
                            <td>Relationship</td>
                            <td><span style="color:white;">/sn28/</span></td>
                        </tr>

                        <tr>
                            <td>Company</td>
                            <td><span style="color:white;">/sn29/</span></td>
                            <td>Address</td>
                            <td><span style="color:white;">/sn30/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn31/</span></td>
                        </tr>

                        <tr>
                            <td>Full Name</td>
                            <td><span style="color:white;">/sn32/</span></td>
                            <td>Relationship</td>
                            <td><span style="color:white;">/sn33/</span></td>
                        </tr>

                        <tr>
                            <td>Company</td>
                            <td><span style="color:white;">/sn34/</span>/td>
                            <td>Address</td>
                            <td><span style="color:white;">/sn35/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn36/</span></td>
                        </tr>
                    </table>
            <br>
                    <table width="100%">
                        <tr>
                            <th colspan=6>PREVIOUS EMPLOYMENT</th>
                        </tr>

                        <tr>
                            <td>Company</td>
                            <td><span style="color:white;">/sn37/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn38/</span></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Address</td>
                            <td><span style="color:white;">/sn39/</span></td>
                            <td>Supervisor</td>
                            <td><span style="color:white;">/sn40/</span></td>

                        </tr>

                        <tr>
                            <td>City</td>
                            <td><span style="color:white;">/sn41/</span></td>
                            <td>State</td>
                            <td><span style="color:white;">/sn42/</span></td>
                            <td>Job Title</td>
                            <td><span style="color:white;">/sn43/</span></td>
                        </tr>

                        <tr>
                            <td>From</td>
                            <td><span style="color:white;">/sn44/</span></td>
                            <td>To</td>
                            <td><span style="color:white;">/sn45/</span></td>
                            <td>Reason for Leaving</td>
                            <td><span style="color:white;">/sn46/</span></td>
                        </tr>

                        <tr>
                            <td>May we contact your previous supervisor for a reference?</td>
                            <td><span style="color:white;">/sn47/</span></td>

                        </tr>

                        <tr>
                            <td>Company</td>
                            <td><span style="color:white;">/sn48/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn49/</span></td>
                            <td></td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Address</td>
                            <td><span style="color:white;">/sn50/</span></td>
                            <td>Supervisor</td>
                            <td><span style="color:white;">/sn51/</span></td>

                        </tr>

                        <tr>
                            <td>City</td>
                            <td><span style="color:white;">/sn52/</span></td>
                            <td>State</td>
                            <td><span style="color:white;">/sn53/</span></td>
                            <td>Job Title</td>
                            <td><span style="color:white;">/sn54/</span></td>
                        </tr>

                        <tr>
                            <td>From</td>
                            <td><span style="color:white;">/sn55/</span></td>
                            <td>To</td>
                            <td><span style="color:white;">/sn56/</span></td>
                            <td><span style="color:white;">/sn57/</span></td>
                        </tr>

                        <tr>
                            <td>May we contact your previous supervisor for a reference?</td>
                            <td><span style="color:white;">/sn58/</span></td>

                        </tr>

                    </table>

            <br>

                    <table width="100%">
                        <tr>
                            <th colspan=6>EMERGENCY CONTACT</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td><span style="color:white;">/sn59/</span></td>
                            <td>Relationship</td>
                            <td><span style="color:white;">/sn60/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn61/</span></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td><span style="color:white;">/sn62/</span></td>
                            <td>Relationship</td>
                            <td><span style="color:white;">/sn63/</span></td>
                            <td>Phone</td>
                            <td><span style="color:white;">/sn64/</span></td>
                        </tr>

                    </table>
            <br>
                    <table width="100%">
                        <tr>
                            <th>DISCLAIMER AND SIGNATURE</th>
                        </tr>
                        <tr>
                            <td>
                                <p>
                                    I, <span style="color:white;">/sn65/</span>(PRINT
                                    NAME), certify that my answers are true and complete to the best
                                    of my knowledge. If this application leads to employment, I
                                    understand that false or misleading information in my application
                                    or interview may result in my release. If a job offer is made, I
                                    understand and am hereby notified and authorize to run a
                                    background check and procure a consumer report from a consumer
                                    reporting agency in accordance with the Fair Credit Reporting Act,
                                    15 U.S.C. 1681 et seq.(the �FCRA�),or any �person� as defined
                                    under the California Consumer Credit Reporting Agencies Act (if a
                                    CA applicant) for evaluation of me for employment (i.e.
                                    employment, promotion, reassignment, or retention as an employee).
                                    I understand that these consumer reports may contain information
                                    from public records, including written, oral, or other
                                    communications bearing on my credit worthiness, credit standing,
                                    credit capacity, character, general reputation, personal
                                    characteristics, or mode of living, which may or may not be used
                                    as a factor for employment purposes. I further understand that
                                    such inquires may include, but are not limited to, criminal
                                    history, motor vehicle records, employment history and
                                    verification, income verification, DOT verifications, military
                                    background, civil listings, education background, and professional
                                    background, from any individual, corporation, partnership, law
                                    enforcement agency, institution, school, organization, credit
                                    bureau, state board, licensing agency, and other entities,
                                    including present and past employers. In connection with my
                                    application for employment and/or employment with Company, I
                                    further understand and am hereby notified that Company may procure
                                    an investigative consumer report concerning me from a consumer
                                    reporting agency or any �person" as defined by the California
                                    Consumer Credit Reporting Agencies Act (if a CA applicant). I
                                    understand that an investigative consumer report may contain
                                    information from public records, including but not limited to,
                                    written, oral or other communications bearing on my credit
                                    worthiness, credit standing, character, general reputation,
                                    personal characteristics, or mode of living, which may be obtained
                                    through personal interviews with neighbors, friends or associates
                                    of me and may or may not be used as a factor for employment
                                    purposes. I further understand that such inquires may include, but
                                    are not limited to, investigations regarding worker�s
                                    compensation, harassment, violence, theft, or fraud. I have
                                    received and reviewed a copy of the Summary of Rights under the
                                    FCRA and the California Investigative Consumer Reporting Agencies
                                    Act (If a California applicant). I understand that I have the
                                    right to request, in writing, information regarding the nature and
                                    scope of any investigative report prepared on me. I authorize
                                    without reservation any party or agency contacted by this employer
                                    to furnish the above- referenced information. I further authorize
                                    ongoing procurement of the above-referenced reports at any time,
                                    either during the time my application for employment is being
                                    considered or throughout the duration of my employment in the
                                    event that I am hired or am a current Company employee. <br>Oklahoma,
                                    Minnesota and California applicants only: You have the right to
                                    receive a copy of your Consumer Credit Report free of charge
                                    should one be requested for employment purposes. I wish to be
                                    furnished with a copy of my consumer credit report should one be
                                    ordered. <br>If you knowingly have background issues, you must inform
                                    us prior to us conducting the background information check in
                                    order not to be penalized for the background reimbursement cost.
                                    By signing below you accept the background clause, acknowledging
                                    that if you fail the required background check, you are liable to
                                    pay the background fees within 24 hours of being notified of the
                                    failed results. Additionally, if you accept an offered position
                                    and you later decide not to take the position after your drug and
                                    background screening, you are liable for the cost of the
                                    background processing. If you accept the offered position and are
                                    terminated for inability (or willfully quit) within 72 hours of
                                    employment, you will not be eligible for compensation for that
                                    time period.<br> **The Age Discrimination in Employment Act
                                    of 1967 prohibits discrimination on the basis of age with respect
                                    to individuals who are at least 40 years of age. *If ME, MI, MN,
                                    OH, PA, RI, or WV applicant DO NOT provide DOB. Instead call
                                    630-635-7410 within 2 hours of submitting your application.<br>
                                    I acknowledge that I have voluntarily provided the information
                                    contained in this form for employment purposes, and I have
                                    carefully read, and I understand this authorization. Signature <span style="color:white;">/sn66/</span><br>
                                    Date <span style="color:white;">/sn67/</span>

                                </p>

                            </td>
                        </tr>
                    </table>
                </div>
            </body>
            </html>
    heredoc;
    }
    if ($type == 'drug_d') {
        return <<< heredoc
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>SSA-89</title>
            <style type="text/css">
            .card{
                margin-bottom: 27px;
                margin-top: 27px;
            }
            .vertical-line {
              border-right: 1px solid #333;
              margin-top: -16px;
            }
            h2{
                font-size: 18px;
                font-weight: 700;
            }
            hr {
                margin-top: 1rem;
                margin-bottom: 1rem;
                border: 0;
                border-top: 2px solid rgba(0,0,0,.1);
                border-color: #00000070;
            }
            .content {
                margin: 150 auto;
                font-family: serif;
            }
            </style>
        </head>
        <body>
        <div class="content">
        <br><br>
        <h2 style="margin-bottom: 15px;"><center>CONSENT AND RELEASE FOR EMPLOYMENT DRUG SCREENING</center></h2>
        <br>
        <p>
            As a condition to my employment/prospective employment at_______________<span style="color:white;">/sn1/</span>___________________ 
            (Employer), I agree to submit to a drug test through the use of urine, hair, blood, breath, or any sample as 
            specified by statute and regulation at the time of consideration of employment or on an ongoing basis 
            during employment. The purpose of this test is to determine the use of alcohol, Class A drugs or other 
            controlled substances in my body. A positive test indicates the presence of marijuana, cocaine, opiates, 
            amphetamines, and/or phencyclidine etc. <br><br>
            For the sole purpose of this test, I authorize my Employer’s authorized agents or Vetzu Inc. (Vetzu) to 
            collect samples of my urine, blood etc. and to use these samples or to forward these samples to a testing 
            laboratory chosen by Vetzu Inc (Vetzu). for analysis. I also authorize these results to be reviewed by a 
            Medical Review Officer (MRO). <br><br>
            Further, I authorize Vetzu to release the results of this test, and any other related documentation to my 
            Employer’s employees with a need-to-know basis. <br><br>
            I understand that the results of this test, if confirmed positive, may remove me from consideration for 
            employment at ________________<span style="color:white;">/sn2/</span>__________________, in accordance with applicable law. <br><br>
            I agree that a reproduced copy of this Consent and Release for Employment Drug Screening shall have the 
            same force and effect as the original.  <br><br>
            I further understand that if I am taking prescription drugs approved by a medical physician, I am encouraged to
            furnish said prescription to an agent of the testing laboratory prior to the collection of my sample. <br><br>
            I have carefully read the foregoing, and I fully understand its contents. I agree that my signing of this Consent 
            and Release for Employment Drug Screening is voluntary, and that I have not been coerced into signing this 
            document. <br><br>
            I give my consent to release the results of the test(s) and other medical information from the laboratory to 
            my employer pursuant to statute or regulation with the condition that the results may not be used in any 
            criminal proceeding. <br>
        </p>
        <br>
        <table align="center" border="1" width="100%">
            <tr>
                <td>
                    Applicant Name
                    <br>
                    <br>
                    <span style="color:white;">/sn3/</span>
                </td>
                <td>
                    Applicant Email
                    <br>
                    <br>
                    <span style="color:white;">/sn4/</span>
                </td>
            </tr>
            <tr>
                <td>
                    Applicant Signature
                    <br>
                    <br>
                    <span style="color:white;">/sn5/</span>
                </td>
                <td>
                    Date
                    <br>
                    <br>
                    <span style="color:white;">/sn6/</span>
                </td>
            </tr>
        </table>
        </div>
        <br>
        </body>
        </html>
heredoc;
}
    }
}
