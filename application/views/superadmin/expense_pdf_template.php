<!DOCTYPE html><html lang="en"><head>
        <title>WORK ORDER</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            img {
                text-align: center;
                width: 24%;
            }
            span {
                display: block;
            }
            .form-control {
                background-color: #fff;
                box-shadow:none;
                border-radius:0px;
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
            .image{ text-align:center;}
            .image h4 {
                margin: 30px 0 0;
            }
            .area{background-color: #fff;
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
            td{ border:1px solid #000; width:50%;}
            .text {
                border: medium none;
                outline: medium none;
                padding: 10px;
                width: 100%;
            }
            .container{ max-width:800px; text-align: center;}
            .container img {width:100%}
            .container h2{text-align: center;}
            .container table{width:100%; margin: 0 auto;}
            .leftDiv {text-align: left;}
            .space{ margin:30px 0 ;}
            .form-control:focus {
                box-shadow:none;
            }
            @media print {
                #print {
                    display: none;
                }
            }
            .mainTable {margin: 0; padding: 0; border: 1px solid black; border-collapse: collapse; text-align: center;}
            .mainTable td{ border: 1px solid #000; width: 50%; padding: 10px 0;}
            .secondaryTable td{border: none; text-align: left;}
            td.sign{border-bottom: 1px solid; }
            label{font-weight: bold;}
        </style>
    </head><body>
        <?php
        // Defining the required view variables
        $agreement_parties = '';

        if (empty($vendor_company_name)) {
            $agreement_parties = 'with <label>' . CLIENT_NAME . '</label>';
        } else {
            $agreement_parties = 'between <label>' . CLIENT_NAME . '</label> and <label>' . $vendor_company_name . '</label>';
        }
        ?>
        <div class="container">
            <div style="align-content: center; text-align: center;">
            	<img src="./assets/images/LetterHead.png" alt="">
            </div>

            <div class="container">
                <h2>Work Order </h2>
                <p align="left">This Work Order (WO) is being generated pursuant to the Agreement dated <label><?php echo $agreement_date; ?></label> 
                <?php echo $agreement_parties; ?>.
            </div>
            <table class="mainTable">
                <tr>
                    <td>Consultant Name</td>
                    <td>
                        <label>
                            <label><?php echo $consultant_name; ?></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Vendor Name</td>
                    <td>
                        <label><?php echo $vendor_company_name; ?></label>
                    </td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>
                        <label>
                            <?php echo $cons_start_date; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Duration of Project</td>
                    <td>
                        <label>
                            <?php echo $project_duration; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Bill Rate</td>
                    <td>
                        <label>
                            <?php echo $bill_rate; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>OT Bill Rate</td>
                    <td>
                        <label>
                            <?php echo $ot_rate; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Client Name</td>
                    <td>
                        <label>
                            <?php echo $client_name_str; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Invoicing Terms</td>
                    <td>
                        <label>
                            <?php echo $invoicing_terms; ?>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>Payment Terms</td>
                    <td>
                        <label>
                            <?php echo $payment_terms; ?>
                        </label>
                    </td>
                </tr>
            </table>

            <p>&nbsp;</p>

            <p class="work-note" align="left">
                <span><label>Note:&nbsp;</label><?php echo $work_note; ?></span>
            </p>

            <p style="text-align: center;">Accepted by:</p>

            <table width="100%" style="border:none; text-align:left;" class="secondaryTable">
            	<tr>
                	<td colspan="2">
                        <label><?php echo CLIENT_NAME; ?></label>
                    </td>
                	<td colspan="2">
                        <label><?php echo $vendor_company_name; ?></label>
                    </td>
            	</tr>
                <tr>
                	<td width="15%">Name:</td>
                	<td width="35%">
                        <p><?php echo $asp_name; ?><P>
                    </td>
                	<td width="15%">Name:</td>
                	<td>
                        <p><?php echo $vendor_poc_name; ?></p>
                    </td>
            	</tr>
                <tr>
                	<td>Designation:</td>
                	<td>
                        <p><?php echo $asp_designation; ?></p>
                    </td>
                	<td>Designation:</td>
                	<td>
                        <p><?php echo $vendor_poc_designation; ?></p>   
                    </td>
            	</tr>
                <tr>
                	<td>Company Name:</td>
                	<td>
                    	<p><?php echo CLIENT_NAME; ?></p>
                	</td>
                	<td>Company Name:</td>
                	<td>
                        <p><?php echo $vendor_company_name; ?></p>   
                    </td>
            	</tr>
                <tr>
                	<td>Date:</td>
                	<td>
                        <p><?php echo $asp_signature_date; ?></p>   
                    </td>
                	<td>Date:</td>
                	<td>
                        <p><?php echo $vendor_signature_date; ?></p>   
                    </td>
            	</tr>
                <tr>
                	<td>Signature:</td>
                	<td class="sign">
                	   <label style="font-family: 'Dancing Script', cursive; font-size: 18px; font-weight: normal;">
                            <?php echo $asp_signature; ?>
                        </label> 
    				</td>
                	<td>Signature:</td>
                	<td class="sign">
                        <label style="font-family: 'Dancing Script', cursive; font-size: 18px; font-weight: normal;">
                            <?php echo $vendor_signature; ?>
                        </label>   
                    </td>
            	</tr>
            </table>
            <p>&nbsp;</p>
            <div class="leftDiv">
                <span><label>IP:</label>
                    <?php echo $vendor_ip; ?>              
                </span>
            </div>
        </div>
    </body></html>