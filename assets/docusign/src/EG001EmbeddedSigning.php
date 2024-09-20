<?php
/**
 * Example 001: Use embedded signing
 */

namespace Example;

use DocuSign\eSign\Client\ApiException;
use DocuSign\eSign\Model\Document;
use DocuSign\eSign\Model\EnvelopeDefinition;
use DocuSign\eSign\Model\Recipients;
use DocuSign\eSign\Model\Signer;
use DocuSign\eSign\Model\SignHere;
use DocuSign\eSign\Model\Tabs;
use DocuSign\eSign\Model\Text;
use DocuSign\eSign\Model\Date;
use DocuSign\eSign\Model\InitialHere;
use DocuSign\eSign\Model\DateSigned;
use DocuSign\eSign\Model\Checkbox;
use Example\Controllers\eSignBaseController;
use Example\Services\SignatureClientService;
use Example\Services\RouterService;

class EG001EmbeddedSigning extends eSignBaseController
{
    /** signatureClientService */
    private $clientService;

    /** RouterService */
    private $routerService;

    /** Specific template arguments */
    private $args;

    private $eg = "eg001";            # reference (and url) for this example
    private $signer_client_id = 1000; # Used to indicate that the signer will use embedded
                                      # Signing. Represents the signer's userId within your application.

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($signer_email, $signer_name, $pdf_doc, $order_report_id)
    {
        $this->args = $this->getTemplateArgs($signer_email, $signer_name, $pdf_doc, $order_report_id);
        $this->clientService = new SignatureClientService($this->args);
        $this->routerService = new RouterService();
    }

    /**
     * 1. Check the token
     * 2. Call the worker method
     * 3. Redirect the user to the signing
     *
     * @return void
     * @throws ApiException for API problems and perhaps file access \Exception too.
     */
    public function createController(): void
    {
        $minimum_buffer_min = 3;
        if ($this->routerService->ds_token_ok($minimum_buffer_min)) {
            # 1. Call the worker method
            # More data validation would be a good idea here
            # Strip anything other than characters listed
            $results = $this->worker($this->args);

            if ($results) {
                # Redirect the user to the embedded signing
                # Don't use an iFrame!
                # State can be stored/recovered using the framework's session or a
                # query parameter on the returnUrl (see the make recipient_view_request method)
                header('Location: ' . $results["redirect_url"]);
                exit;
            }
        } else {
            $this->clientService->needToReAuth($this->eg);
        }
    }


    /**
     * Do the work of the example
     * 1. Create the envelope request object
     * 2. Send the envelope
     * 3. Create the Recipient View request object
     * 4. Obtain the recipient_view_url for the embedded signing
     *
     * @param  $args array
     * @return array ['redirect_url']
     * @throws ApiException for API problems and perhaps file access \Exception too.
     */
    # ***DS.snippet.0.start
    public function worker(array $args): array
    {
        # 1. Create the envelope request object
        $envelope_definition = $this->make_envelope($args["envelope_args"]);
        $envelope_api = $this->clientService->getEnvelopeApi();

        # 2. call Envelopes::create API method
        # Exceptions will be caught by the calling function
        try {
            $results = $envelope_api->createEnvelope($args['account_id'], $envelope_definition);
        } catch (ApiException $e) {
            $this->clientService->showErrorTemplate($e);
            exit;
        }

        $envelope_id = $results->getEnvelopeId();
        $_SESSION['envelope_id'] = $envelope_id;

        # 3. Create the Recipient View request object
        $authentication_method = 'None'; # How is this application authenticating
        # the signer? See the `authentication_method' definition
        # https://developers.docusign.com/esign-rest-api/reference/Envelopes/EnvelopeViews/createRecipient
        $recipient_view_request = $this->clientService->getRecipientViewRequest(
            $authentication_method,
            $args["envelope_args"]
        );

        # 4. Obtain the recipient_view_url for the embedded signing
        # Exceptions will be caught by the calling function
        $results = $this->clientService->getRecipientView($args['account_id'], $envelope_id, $recipient_view_request);

        return ['envelope_id' => $envelope_id, 'redirect_url' => $results['url']];
    }

    /**
     *  Creates envelope definition
     *  Parameters for the envelope: signer_email, signer_name, signer_client_id
     *
     * @param  $args array
     * @return EnvelopeDefinition -- returns an envelope definition
     */
    private function make_envelope(array $args): EnvelopeDefinition
    {
        # document 1 (pdf) has tag /sn1/
        #
        # The envelope has one recipient.
        # recipient 1 - signer
        #
        # Read the file
        $base64_file_content = '';
        $type = '';
            
        //     $type = 'scr';
        //     $base64_file_content2 = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));
        // }
        if ($args['pdf'] == 'ssa') {
            // $content_bytes = file_get_contents(self::DEMO_DOCS_PATH . $GLOBALS['DS_CONFIG']['doc_pdf']); 
            $type = 'ssa';   
            $base64_file_content = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));   
            $ext = 'html'; 
        }
        if ($args['pdf'] == 'appl_discl_form') {
            // $content_bytes = file_get_contents(self::DEMO_DOCS_PATH . $GLOBALS['DS_CONFIG']['doc_pdf_2']);
            $type = 'adf';
            $base64_file_content = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));
            // $base64_file_content = base64_encode($content_bytes);
            $ext = 'html';
        }
        if ($args['pdf'] == 'summ_of_consumer_rights') {
            $type = 'scr';
            $base64_file_content = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));
            $ext = 'html';
        }
        if ($args['pdf'] == 'anaf') {
            $type = 'anaf';
            $base64_file_content = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));
            $ext = 'html';
        }
        if ($args['pdf'] == 'drug_d') {
            $type = 'drug_d';
            $base64_file_content = base64_encode($this->clientService->createDocumentForEnvelope($args, $type));
            $ext = 'html';
        }

        if ($args['pdf'] == 'mixed_envelope') {
            $type1 = 'scr';
            $base64_file_content1 = base64_encode($this->clientService->createDocumentForEnvelope($args, $type1));
            $ext1 = 'html';

            $document1 = new Document([ # create the DocuSign document object
            'document_base64' => $base64_file_content1,
            'name' => 'Example document', # can be different from actual file name
            'file_extension' => $ext1, # many different document types are accepted
            'document_id' => 1 # a label used to reference the doc
            ]);

            $type2 = 'anaf';
            $base64_file_content2 = base64_encode($this->clientService->createDocumentForEnvelope($args, $type2));
            $ext2 = 'html';

            $document2 = new Document([ # create the DocuSign document object
            'document_base64' => $base64_file_content2,
            'name' => 'Example document', # can be different from actual file name
            'file_extension' => $ext2, # many different document types are accepted
            'document_id' => 2 # a label used to reference the doc
            ]);


            $type3 = 'drug_d';
            $base64_file_content3 = base64_encode($this->clientService->createDocumentForEnvelope($args, $type3));
            $ext3 = 'html';

            $document3 = new Document([ # create the DocuSign document object
            'document_base64' => $base64_file_content3,
            'name' => 'Example document', # can be different from actual file name
            'file_extension' => $ext3, # many different document types are accepted
            'document_id' => 3 # a label used to reference the doc
            ]);

            # Create a sign_here tab (field on the document)
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0'
            ]);

            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types

            $signer = new Signer([ # The signer
            'email' => $args['signer_email'], 'name' => $args['signer_name'],
            'recipient_id' => "1", 'routing_order' => "1",
            # Setting the client_user_id marks the signer as embedded
            'client_user_id' => $args['signer_client_id']
            ]);

            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here]]));

            # Next, create the top level envelope definition and populate it.
            $envelope_definition = new EnvelopeDefinition([
                'email_subject' => "Please sign this document sent from the PHP SDK",
                'documents' => [$document1,$document2,$document3],
                # The Recipients object wants arrays for each recipient type
                'recipients' => new Recipients(['signers' => [$signer]]),
                'status' => "sent" # requests that the envelope be created and sent.
            ]);

            return $envelope_definition;

        }

        # Create the document model
        $document = new Document([ # create the DocuSign document object
            'document_base64' => $base64_file_content,
            'name' => 'Example document', # can be different from actual file name
            'file_extension' => $ext, # many different document types are accepted
            'document_id' => 1 # a label used to reference the doc
        ]);

        # Create the signer recipient model
        $signer = new Signer([ # The signer
            'email' => $args['signer_email'], 'name' => $args['signer_name'],
            'recipient_id' => "1", 'routing_order' => "1",
            # Setting the client_user_id marks the signer as embedded
            'client_user_id' => $args['signer_client_id']
        ]);

        if ($args['pdf'] == 'ssa') {
            # Create a sign_here tab (field on the document)
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn21/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0'
            ]);

            $initial_here = new InitialHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn20/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0.09'
            ]);

            $text_pname = new Text([
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.03', 'anchor_x_offset' => '-0.12',
                "width" => "60",
                'tab_label' => 'Legal name 1'
            ]);

            $text_dob = new Date([
                'anchor_string' => '/sn2/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.12',
                'document_id' => 1,  
                'height' => 12,  
                'max_length' => 10,  
                'name' => "Please use this format DD/MM/YYYY",  
                'page_number' => 1,  
                'recipient_id' => "1",  
                'required' => true,  
                'tab_label' => "DatePicker",  
                'tab_type' => "date",  
                'validation_message' => "Enter date with format DD/MM/YYYY ",  
                'validation_pattern' => "^(|by DocuSign)((|0)[1-9]|[1-2][0-9]|3[0-1])/((|0)[1-9]|1[0-2])/[0-9]{4}$",  
                'value' => "",  
                'width' => 62
            ]);

            $text_ssn = new Text([
                'anchor_string' => '/sn3/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.14',
                "width" => "40",
                'tab_label' => 'Legal name 3'
            ]);

            $text_cname = new Text([
                'anchor_string' => '/sn14/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 4'
            ]);

            $text_caddr = new Text([
                'anchor_string' => '/sn13/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 5'
            ]);

            $c1 = new Checkbox([
                'anchor_string' => '/sn7/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c1'
            ]);

            $c2 = new Checkbox([
                'anchor_string' => '/sn8/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c2'
            ]);

            $c3 = new Checkbox([
                'anchor_string' => '/sn9/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c3'
            ]);

            $c4 = new Checkbox([
                'anchor_string' => '/sn10/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c4'
            ]);

            $c5 = new Checkbox([
                'anchor_string' => '/sn11/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c5'
            ]);

            $c6 = new Checkbox([
                'anchor_string' => '/sn6/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c6'
            ]);

            $c7 = new Checkbox([
                'anchor_string' => '/sn5/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c7'
            ]);

            $c8 = new Checkbox([
                'anchor_string' => '/sn4/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c8'
            ]);

            $text_15 = new Text([
                'anchor_string' => '/sn15/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 6'
            ]);

            $text_16 = new Text([
                'anchor_string' => '/sn16/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 7'
            ]);

            $text_17 = new Text([
                'anchor_string' => '/sn17/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.07', 'anchor_x_offset' => '-0.02',
                "width" => "20",
                'tab_label' => 'Legal name 8'
            ]);

            $text_18 = new Text([
                'anchor_string' => '/sn18/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 9'
            ]);

            $text_20 = new Text([
                'anchor_string' => '/sn19/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.07', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 10'
            ]);

            $text_21 = new Text([
                'anchor_string' => '/sn23/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.07', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 12'
            ]);

            $text_19 = new DateSigned([
                'anchor_string' => '/sn22/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);
            
            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types
            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here], 'text_tabs' => [$text_pname, $text_ssn, $text_cname, $text_caddr, $text_15, $text_16, $text_17,$text_18, $text_20, $text_21], 'date_signed_tabs' => [$text_19], 'checkbox_tabs' => [$c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8], 'date_tabs' => [$text_dob], 'initial_here_tabs' => [$initial_here]]));
        }
        if ($args['pdf'] == 'appl_discl_form') {
            # Create a sign_here tab (field on the document)
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn16/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '1.7'
            ]);

            $text_pname = new Text([
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.1', 'anchor_x_offset' => '-0.5',
                "width" => "100",
                'tab_label' => 'Legal name 1'
            ]);

            $text_dob3 = new Date([
                'anchor_string' => '/sn13/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.10',
                'document_id' => 1,  
                'height' => 16,  
                'max_length' => 10,  
                'name' => "Please use this format DD/MM/YYYY",  
                'page_number' => 1,  
                'recipient_id' => "1",  
                'required' => true,  
                'tab_label' => "DatePicker",  
                'tab_type' => "date",  
                'validation_message' => "Enter date with format DD/MM/YYYY ",  
                'validation_pattern' => "^(|by DocuSign)((|0)[1-9]|[1-2][0-9]|3[0-1])/((|0)[1-9]|1[0-2])/[0-9]{4}$",  
                'value' => "",  
                'width' => 62
            ]);

            $text_dob2 = new Date([
                'anchor_string' => '/sn4/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.10',
                'document_id' => 1,  
                'height' => 22,  
                'max_length' => 10,  
                'name' => "Please use this format DD/MM/YYYY",  
                'page_number' => 1,  
                'recipient_id' => "1",  
                'required' => true,  
                'tab_label' => "DatePicker",  
                'tab_type' => "date",  
                'validation_message' => "Enter date with format DD/MM/YYYY ",  
                'validation_pattern' => "^(|by DocuSign)((|0)[1-9]|[1-2][0-9]|3[0-1])/((|0)[1-9]|1[0-2])/[0-9]{4}$",  
                'value' => "",  
                'width' => 62
            ]);

            $text_fname = new Text([
                'anchor_string' => '/sn2/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.1', 'anchor_x_offset' => '0.02',
                "width" => "40",
                'tab_label' => 'Legal name 3'
            ]);

            $sign_here2 = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn3/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0.6'
            ]);

            $text_caddr = new Text([
                'anchor_string' => '/sn7/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 5'
            ]);

            $c1 = new Checkbox([
                'anchor_string' => '/sn5/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                'tab_label' => 'c1'
            ]);

            $c2 = new Text([
                'anchor_string' => '/sn8/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 8'
            ]);

            $c3 = new Text([
                'anchor_string' => '/sn9/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 9'
            ]);

            $c4 = new Text([
                'anchor_string' => '/sn10/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 10'
            ]);

            $c5 = new Text([
                'anchor_string' => '/sn11/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);

            $c6 = new Text([
                'anchor_string' => '/sn12/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 12'
            ]);

            $c8 = new Text([
                'anchor_string' => '/sn14/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 21'
            ]);

            $text_15 = new Text([
                'anchor_string' => '/sn15/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 6'
            ]);

            // $text_18 = new Text([
            //     'anchor_string' => '/sn18/', 'anchor_units' => 'inches',
            //     'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
            //     "width" => "40",
            //     "value" => $this->args['envelope_args']['signer_name'],
            //     'tab_label' => 'Legal name 9'
            // ]);
            $text_finame = new Text([
                'anchor_string' => '/sn6/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.1', 'anchor_x_offset' => '0',
                "width" => "100",
                'tab_label' => 'Legal name 1'
            ]);

            $text_17 = new DateSigned([
                'anchor_string' => '/sn17/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);

            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types
            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here, $sign_here2], 'text_tabs' => [$text_pname, $text_fname, $text_caddr, $text_finame, $text_15,$c1,$c2,$c3,$c4,$c5,$c6,$c8], 'date_signed_tabs' => [$text_17], 'checkbox_tabs' => [$c1], 'date_tabs' => [$text_dob3,$text_dob2]]));
        }
        if ($args['pdf'] == 'summ_of_consumer_rights') {
            # Create a sign_here tab (field on the document)
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '0'
            ]);

            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types
            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here]]));
        }
        if ($args['pdf'] == 'anaf') {
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn65/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '1.7'
            ]);

            $text_pname = new Text([
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-1.5',
                "width" => "100",
                'tab_label' => 'Legal name 1'
            ]);

            $text_dob3 = new Date([
                'anchor_string' => '/sn12/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-1.2',
                'document_id' => 1,  
                'height' => 16,  
                'max_length' => 10,  
                'name' => "Please use this format DD/MM/YYYY",  
                'page_number' => 1,  
                'recipient_id' => "1",  
                'required' => true,  
                'tab_label' => "DatePicker",  
                'tab_type' => "date",  
                'validation_message' => "Enter date with format DD/MM/YYYY ",  
                'validation_pattern' => "^(|by DocuSign)((|0)[1-9]|[1-2][0-9]|3[0-1])/((|0)[1-9]|1[0-2])/[0-9]{4}$",  
                'value' => "",  
                'width' => 62
            ]);

            $text_fname = new Text([
                'anchor_string' => '/sn2/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 3'
            ]);

            $text_caddr = new Text([
                'anchor_string' => '/sn3/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 10'
            ]);

            $c1 = new Text([
                'anchor_string' => '/sn4/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);

            $c2 = new Text([
                'anchor_string' => '/sn5/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-1.2',
                "width" => "40",
                'tab_label' => 'Legal name 12'
            ]);

            $c3 = new Text([
                'anchor_string' => '/sn6/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.9',
                "width" => "40",
                'tab_label' => 'Legal name 13'
            ]);

            $c4 = new Text([
                'anchor_string' => '/sn7/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-1.7',
                "width" => "40",
                'tab_label' => 'Legal name 14'
            ]);

            $c5 = new Text([
                'anchor_string' => '/sn8/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);

            $c6 = new Text([
                'anchor_string' => '/sn9/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 12'
            ]);

            $c8 = new Text([
                'anchor_string' => '/sn10/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-1.7',
                "width" => "40",
                'tab_label' => 'Legal name 21'
            ]);

            $text_15 = new Text([
                'anchor_string' => '/sn11/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.18',
                "width" => "40",
                'tab_label' => 'Legal name 6'
            ]);

            // $text_18 = new Text([
            //     'anchor_string' => '/sn18/', 'anchor_units' => 'inches',
            //     'anchor_y_offset' => '0', 'anchor_x_offset' => '0',
            //     "width" => "40",
            //     "value" => $this->args['envelope_args']['signer_name'],
            //     'tab_label' => 'Legal name 9'
            // ]);
            $text_finame = new Text([
                'anchor_string' => '/sn12/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.1', 'anchor_x_offset' => '0',
                "width" => "100",
                'tab_label' => 'Legal name 1'
            ]);

            $text_17 = new Text([
                'anchor_string' => '/sn13/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '5', 'anchor_x_offset' => '0.5',
                "width" => "40",
                'tab_label' => 'Legal name 22'
            ]);

            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types
            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here], 'text_tabs' => [$text_pname, $text_fname, $text_caddr, $text_finame, $text_15,$c1,$c2,$c3,$c4,$c5,$c6,$c8], 'date_tabs' => [$text_dob3]]));
        }
        if ($args['pdf'] == 'drug_d') {
            $sign_here = new SignHere([ # DocuSign SignHere field/tab
                'anchor_string' => '/sn7/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '1.7'
            ]);

            $text_pname = new Text([
                'anchor_string' => '/sn1/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-1.5',
                "width" => "100",
                'tab_label' => 'Legal name 1'
            ]);

            $text_fname = new Text([
                'anchor_string' => '/sn2/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '0', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 3'
            ]);

            $text_caddr = new Text([
                'anchor_string' => '/sn3/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '0',
                "width" => "40",
                'tab_label' => 'Legal name 10'
            ]);

            $c1 = new Text([
                'anchor_string' => '/sn4/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 11'
            ]);

            $c2 = new Text([
                'anchor_string' => '/sn5/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 12'
            ]);

            $c3 = new Text([
                'anchor_string' => '/sn6/', 'anchor_units' => 'inches',
                'anchor_y_offset' => '-0.05', 'anchor_x_offset' => '-0.3',
                "width" => "40",
                'tab_label' => 'Legal name 13'
            ]);

            # Add the tabs model (including the sign_here tab) to the signer
            # The Tabs object wants arrays of the different field/tab types
            $signer->settabs(new Tabs(['sign_here_tabs' => [$sign_here], 'text_tabs' => [$text_pname, $text_fname, $text_caddr, $c1,$c2,$c3]]));
        }

        # Next, create the top level envelope definition and populate it.
        $envelope_definition = new EnvelopeDefinition([
            'email_subject' => "Please sign this document sent from the PHP SDK",
            'documents' => [$document],
            # The Recipients object wants arrays for each recipient type
            'recipients' => new Recipients(['signers' => [$signer]]),
            'status' => "sent" # requests that the envelope be created and sent.
        ]);

        return $envelope_definition;
    }
    # ***DS.snippet.0.end


    /**
     * Get specific template arguments
     *
     * @return array
     */
    private function getTemplateArgs($signer_email_arg, $signer_name_arg, $pdf_doc_arg, $order_report_id): array
    {
        $signer_email = $signer_email_arg;
        $signer_name = $signer_name_arg;
        $envelope_args = [
            'pdf' => $pdf_doc_arg,
            'signer_email' => $signer_email,
            'signer_name' => $signer_name,
            'signer_client_id' => $this->signer_client_id,
            'ds_return_url' => $GLOBALS['app_url'] . "../src/index.php?page=$pdf_doc_arg&order_id=$order_report_id"
        ];
        $args = [
            'account_id' => $_SESSION['ds_account_id'],
            'base_path' => $_SESSION['ds_base_path'],
            'ds_access_token' => $_SESSION['ds_access_token'],
            'envelope_args' => $envelope_args
        ];

        return $args;
    }
}
