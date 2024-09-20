<!DOCTYPE html>
<html lang="en">
<head>
    <title>NDA FORM</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Open+Sans|Rock+Salt|Shadows+Into+Light|Cedarville+Cursive">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        img {
            text-align: center;
            width: 45%;
        }

        span {
            display: block;
        }
        .sub-css {
            background-color: #fff;
            background-image: none;
            border-color: currentcolor currentcolor #000;
            border-image: none;
            border-radius: 0;
            border-style: none none solid;
            border-width: medium medium 1px;
            box-shadow: none;
            color: #555;
            display: inline-block;
            /*font-size: 10px;*/
            text-align: center;
            font-weight: bold;
            /*height: 34px;*/
            /*line-height: 1.42857;*/
            /*padding: 6px 12px;*/
            /*margin-top: 20px;*/
            width: 15%;
        }

        .form-control {
            background-color: #fff;
            box-shadow: none;
            border-radius: 0px;
            background-image: none;
            border-color: currentcolor currentcolor #000;
            border-image: none;
            border-style: none none solid;
            border-width: medium medium 1px;
            color: #555;
            display: block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            width: 100%;
        }

        .form-control1 {
            background-color: #fff;
            box-shadow: none;
            border-radius: 0px;
            background-image: none;
            border-color: currentcolor currentcolor #000;
            border-image: none;
            border-style: none none solid;
            border-width: medium medium 1px;
            color: #555;
            display: inline-block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            width: 20%;
        }

        .image {
            text-align: center;
        }

        .image h4 {
            margin: 65px 0 0;
        }

        .area {
            background-color: #fff;
            background-image: none;
            color: #555;
            display: block;
            font-size: 14px;
            height: 34px;
            line-height: 1.42857;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
        }

        td {
            border: 1px solid #000;
            width: 50%;
        }

        .text {
            border: medium none;
            outline: medium none;
            padding: 10px;
            width: 100%;
        }

        .subcon {
            margin: 30px 0;
        }

        .container {
            width: 800px;
        }

        .space {
            margin: 30px 0;
        }

        .form-control:focus {
            box-shadow: none;
        }
        @media print {
            #print {
                display: none;
            }
        }
    </style>
</head>
<body>
<?php
if(!empty($get_form_details)){
    $vendor_id = $get_form_details[0]['vendor_id'];
    $form_data_arr =json_decode($get_form_details[0]['form_data']);
//    echo "<pre>";
//    print_r($form_data_arr);

    $img_src = $form_data_arr->img_src;
    $nda_day = $form_data_arr->nda_day;
    $nda_month = $form_data_arr->nda_month;
    $nda_year = $form_data_arr->nda_year;
    $owner = $form_data_arr->owner;
    $location = $form_data_arr->location;
    $recipient = $form_data_arr->recipient;
    $vendor_signature = $form_data_arr->vendor_signature;
    $vendor_ip = $form_data_arr->vendor_ip;
}
?>
<div class="container">
    <div class="image">
        <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

        <h2>NON-DISCLOSURE AGREEMENT</h2>
    </div>

        <div class="subcon">
            <p style="line-height: 25px;">This Non-disclosure Agreement (this "Agreement") is made effective as
                of,<span class="sub-css"><?php echo $nda_day ?></span> day of <span
                    class="sub-css"><?php echo $nda_month ?></span>,20<span class="sub-css" style="text-align: left !important; width: 5%;"><?php echo $nda_year ?></span> (the
                "Effective Date"), by and between PNC CAPITAL LLC DBA PROCURETECHSTAFF CONSULTING SERVICES (the
                "Owner"), located at 155 N Michigan Ave. Suite 513, Chicago IL 60601 and <span
                    class="sub-css"><?php echo $owner ?></span>(the
                "Recipient"), located <span class="sub-css"><?php echo $location ?></span>.<br><br>
                The Owner is Engaged in the business of Temporary staffing and IT Consulting Services the Recipient is
                <span class="sub-css"><?php echo $recipient ?></span> will be disclosed to the Recipient to
                determine whether the Recipient could assist ProcureTechStaff with the development of better business
                model for Consulting and staffing The Owner has requested and the Recipient agrees that the Recipient
                will protect the confidential material and information which may be disclosed between the Owner and the
                Recipient. Therefore, the parties agree as follows.<br><br>
                <strong>I. CONFIDENTIAL INFORMATION.</strong> The term "Confidential Information" means any information
                or material which is proprietary to the Owner, whether or not owned or developed by the Owner, which is
                not generally known other than by the Owner, and which the Recipient may obtain through any direct or
                indirect contact with the Owner.
            </p>
        </div>
        <div class="subcon">

            <p><strong>A. "Confidential Information" </strong> includes without limitation: <br><br>
                - business records and plans - financial statements - customer lists and records - trade secrets
                - technical information - products - inventions - product design information - pricing structure
                - discounts - costs - computer programs and listings - source code and/or object code - copyrights and
                other intellectual property and other proprietary information. </p>

            <p><strong> B. "Confidential Information"</strong> does not include: <br><br>
                - matters of public knowledge that result from disclosure by the Owner; - information rightfully
                received by the Recipient from a third party without a duty of confidentiality;
                - information independently developed by the Recipient; - information disclosed by operatio of law; -
                information disclosed by the Recipient with the prior written consent of the Owner; and any other
                information that both parties agree in writing is not confidential. </p>

            <p><strong>II. PROTECTION OF CONFIDENTIAL INFORMATION.</strong> The Recipient understands and acknowledges
                that the Confidential Information has been developed or obtained by the Owner by the investment of
                significant time, effort and expense, and that the Confidential Information is a valuable, special and
                unique asset of the Owner which provides the Owner with a significant competitive advantage, and needs
                to be protected from improper disclosure. In consideration for the receipt by the Recipient of the
                Confidential Information, the Recipient agrees as follows:
            </p>

            <p>
                <strong>A. No Disclosure.</strong>The Recipient will hold the Confidential Information in confidence and
                will not disclose the Confidential Information to any person or entity without the prior written consent
                of the Owner.
            </p>

            <p>
                <strong>B. No Copying/Modifying.</strong> The Recipient will not copy or modify any Confidential
                Information without the prior written consent of the Owner.
            </p>

            <p>
                <strong> C. Unauthorized Use.</strong> The Recipient shall promptly advise the Owner if the Recipient
                becomes aware of any possible unauthorized disclosure or use of the Confidential Information.
            </p>

            <p>
                <strong>D. Application to Sub- Contractors. </strong> The Recipient shall not disclose any Confidential
                Information to any sub-contractors of the Recipient, except those sub-contractors who are required to
                have the Confidential Information in order to perform their job duties in connection with the limited
                purposes of this Agreement. Each permitted sub-contractors to whom Confidential Information is disclosed
                shall sign a non-disclosure agreement substantially the same as this Agreement at the request of the
                Owner.
            </p>

            <p>
                <strong>III. UNAUTHORIZED DISCLOSURE OF INFORMATION - INJUNCTION.</strong>If it appears that the
                Recipient has disclosed (or has threatened to disclose) Confidential Information in violation of this
                Agreement, the Owner shall be entitled to an injunction to restrain the Recipient from disclosing the
                Confidential Information in whole or in part. The Owner shall not be prohibited by this provision from
                pursuing other remedies, including a claim for losses and damages.
            </p>

            <p>
                <strong> IV. NON-CIRCUMVENTION. </strong> During the term of this Agreement, Recipient will not attempt
                to do business with, or otherwise solicit any business contacts found or otherwise referred by Owner to
                Recipient for the purpose of circumventing, the result of which shall be to prevent the Owner from
                realizing or recognizing a profit, fees, or otherwise, without the specific written approval of the
                Owner. If such circumvention shall occur the Owner shall be entitled to any commissions due pursuant to
                this Agreement or relating to such transaction.
            </p>

            <p>
                <strong>V. RETURN OF CONFIDENTIAL INFORMATION.</strong> Upon the written request ofthe Owner, the
                Recipient shall return to the Owner all written materials containing the Confidential Information. The
                Recipient shall also deliver to the Owner written statements signed by the Recipient certifying that all
                materials have been returned within five (5) days of receipt of the request.
            </p>

            <p>
                <strong>VI. RELATIONSHIP OF PARTIES.</strong> Neither party has an obligation under this Agreement to
                purchase any service or item from the other party, or commercially offer any products using or
                incorporating the Confidential Information. This Agreement does not create any agency, partnership, or
                joint venture.
            </p>

            <p><strong>VII. NO WARRANTY. </strong> The Recipient acknowledges and agrees that the Confidential
                Information is provided on an "AS IS" basis. THE OWNER MAKES NO WARRANTIES, EXPRESS OR IMPLIED, WITH
                RESPECT TO THE CONFIDENTIAL INFORMATION AND HEREBY EXPRESSLY DISCLAIMS ANYANDALLIMPLIED WARRANTIES OF
                MERCHANTABILITY ANDFITNESSFORAPARTICULAR PURPOSE. INNOEVENT SHALL THEOWNERBELIABLE FORANYDIRECT,
                INDIRECT, SPECIAL, OR CONSEQUENTIAL DAMAGES IN CONNECTION WITH OR ARIS ING OUT OFTHE PERFORMANCE
                ORUSEOFANYPORTION OFTHECONFIDENTIAL INFORMATION. The Owner does not represent or warrant that any
                product or business plans disclosed to the Recipient will be marketed or carried out as disclosed, or at
                all. Any actions taken by the Recipient in response to the disclosure of the Confidential Information
                shall be solely at the risk of the Recipient. </p>

            <p><strong>VIII. LIMITED LICENSE TO USE.</strong>The Recipient shall not acquire any intellectual property
                rights under this Agreement except the limited right to use as set forth above. The Recipient
                acknowledges that, as between the Owner and the Recipient, the Confidential Information and all related
                copyrights and other intellectual property rights, are (and at all times will be) the property of the
                Owner, even if suggestions, comments, and/or ideas made by the Recipient are incorporated into the
                Confidential Information or related materials during the period of this Agreement. </p>

            <p><strong>IX. INDEMNITY. </strong>Each party agrees to defend, indemnify, and hold harmless the other party
                and its officers, directors, agents, affiliates, distributors, representatives, and sub-contractors from
                any and all third party claims, demands, liabilities, costs and expenses, including reasonable attorneys
                fees, costs and expenses resulting from the indemnifying party's material breach of any dut y,
                representation, or warranty under this Agreement. </p>

            <p><strong> X. ATTORNEY FEES.</strong>In any legal action between the parties concerning this Agreement, the
                prevailing part y shall be entitled to recover reasonable attorneys fees and costs. </p>

            <p><strong>XI. GENERAL PROVISIONS.</strong>This Agreement sets forth the entire understanding of the parties
                regarding confidentiality. The obligations of confidentiality shall survive 12 month(s)
                fromthedateofdisclosure oftheConfidential Information. Anyamendments must bein writing and signed by
                both parties. This Agreement shall be construed under the laws of the State of Illinois. This Agreement
                shall not be assignable byeither party. Neither party may delegate its duties under this Agreement
                without the prior written consent of the other party. This agreement will be effective for a year post
                termination of the contract. If any provision of this Agreement is held to be invalid, illegal or
                unenforceable, the remaining portions of this Agreement shall remain in full force and effect and
                construed so as to best effectuate the original intent and purpose of this Agreement. All clauses are
                subjected to mutual agreement of Vendor Agreement. </p>

            <p><strong>XII. SIGNATORIES. </strong>This Agreement shall be executed by ProcureTechStaff and and delivered
                in the manner prescribed bylaw as of the date first written above. </p>

            <div class="row space">
                <div class="col-sm-3">
                    <label class="control-label" for="email"> OWNER : </label>
                </div>
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-3"><label class="control-label" for="email"> RECIPIENT : </label></div>
            </div>
            <div class="row space">
                <div class="col-sm-3"
                     style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;">
                    ProcureTechStaff
                </div>
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-3">&nbsp;</div>
                <div class="col-sm-3"
                     style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;">
                    &nbsp;</div>
            </div>
            <div class="row space">
                <div class="col-sm-3" style="width:10%;">By :</div>
                <div class="col-sm-3" style="width:40%;border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-family: 'Cedarville Cursive', cursive; font-size: 1.7em;">&nbsp;</div>
                <div class="col-sm-3" style="width:10%;">By :</div>
                <div class="col-sm-3" style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-family: 'Cedarville-Cursive', cursive; font-size: 1.5em; font-weight: bold;">
                    <?php if (isset($vendor_signature) && $vendor_signature != '') {
                        echo $vendor_signature;
                    } ?>
                </div>
            </div>
        </div>

        <br/><br/><br/><br/><br/>

        <div class="image">
            <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
            <span>Tel: 773-304-3630</span>
            <span>Fax: 773-747-4056</span>
            <span><a href="#"> www.procuretechstaff.com</a></span>
        </div>
        <br/>
    <div style="text-align:left;font-size: 12px;"> <?php if(isset($vendor_ip) && $vendor_ip != ''){ echo "IP". " - ".$vendor_ip; } ?></div>
    <div style="text-align: center;">
        <a href="javascript:void(0)" id="print" onclick="window.print();" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
    </div>
</div>

</body>
</html>
