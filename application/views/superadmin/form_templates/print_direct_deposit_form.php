<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Direct Deposit Form</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                margin: 65px 0 0;
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
            td {
                border: 1px solid #000;
                padding: 0 5px;
                text-align: left;
                /* width: 50%;*/
            }
            .text {
                border: medium none;
                outline: medium none;
                padding: 8px;
                width: 63%;
                font-weight: bold;
            }
            .container{ width:800px;}
            .space{ margin:30px 0 ;}
            .form-control:focus {
                box-shadow:none;
            }
            .form-control1 {
                border-color: currentcolor currentcolor #000;
                border-style: none none solid;
                border-width: medium medium 1px;
                color: #555;
                font-size: 14px;
                height: 28px;
                margin: 0 0 23px;
                padding: 2px 12px;
                width: 56%;
            }

            @media print
            {    
                .btn-print
                {
                    display: none !important;
                }
            }
        </style>
    </head>
    <body style="font-size: 12px;line-height: 14px;">
        <?php
        if (!empty($form_data)) {
            $employee_ip = $form_data->employee_ip;
            $submitted_to = $form_data->submitted_to;
            $date_submitted = $form_data->date_submitted;
            $effective_date = $form_data->effective_date;
            $submitted_from = $form_data->submitted_from;
            $company = $form_data->company;
            $offce_location = $form_data->offce_location;
            $is_deposit = $form_data->is_deposit;
            $fst_bank_name = $form_data->fst_bank_name;
            $fst_bank_routing = $form_data->fst_bank_routing;
            $fst_account_no = $form_data->fst_account_no;
            $fst_amount = $form_data->fst_amount;
            $fst_deposit_type = explode(",", $form_data->fst_deposit_type);
            $scnd_bank_name = $form_data->scnd_bank_name;
            $scnd_bank_routing = $form_data->scnd_bank_routing;
            $scnd_account_no = $form_data->scnd_account_no;
            $scnd_amount = $form_data->scnd_amount;
            $scnd_deposit_type = explode(",", $form_data->scnd_deposit_type);
            $company_name = $form_data->company_name;
            $employee_signature = $form_data->employee_signature;
            $signature_date = $form_data->signature_date;
            $employee_name = $form_data->employee_name;
        }
        ?>

        <div class="container">
            <div class="image">
                <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">
                <h2>Direct Deposit Form</h2>
            </div>

            <table width="100%" style="border:1px solid black; text-align:center; overflow:hidden">
                <tr>
                    <td>To <span class="text"><?php
                            if (isset($submitted_to) && $submitted_to != '') {
                                echo $submitted_to;
                            }
                            ?></span></td>
                    <td>Date Submitted <span class="text"><?php
                            if (isset($date_submitted) && $date_submitted != '0000-00-00') {
                                echo $date_submitted;
                            }
                            ?></td>
                    <td>Effective Date <span class="text"><?php
                            if (isset($effective_date) && $effective_date != '0000-00-00') {
                                echo $effective_date;
                            }
                            ?></td>
                </tr>
                <tr>
                    <td>From <span class="text"><?php
                            if (isset($submitted_from) && $submitted_from != '') {
                                echo $submitted_from;
                            }
                            ?></span></td>
                    <td>Company <span class="text"><?php
                            if (isset($company) && $company != '') {
                                echo $company;
                            }
                            ?></span></td>
                    <td>Office Location <span class="text"><?php
                            if (isset($offce_location) && $offce_location != '') {
                                echo $offce_location;
                            }
                            ?></span></td>
                </tr>
            </table>
            <p style="padding:10px; background:#333333; color:#FFFFFF; margin:20px 0; border-radius:10px;">
                <b>Direct Deposit Disclaimer:</b> If you are eligible for and choose to enroll in Direct Deposit we recommend that you verify with your bank or financial institution when your funds would be posted to your account and made available to you. Each bank and financial institution has its own process for funds availability.
            </p>
            <p>Do You want Direct Deposit? Yes   No   ("yes. Please attach a voided check to this form and forward to your branch representative for processing).</p>  
            <div class="details clearfix">
                <h3 style="border-bottom: 2px dotted;">Account #1</h3>
                <span>Employee Bank Name: <span class="text"><?php
                        if (isset($fst_bank_name) && $fst_bank_name != '') {
                            echo $fst_bank_name;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Bank Routing {ABA) #: <span class="text"><?php
                        if (isset($fst_bank_routing) && $fst_bank_routing != '') {
                            echo $fst_bank_routing;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Account No.: <span class="text"><?php
                        if (isset($fst_account_no) && $fst_account_no != '') {
                            echo $fst_account_no;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Amount: <span class="text"><?php
                        if (isset($fst_amount) && $fst_amount != '') {
                            echo $fst_amount;
                        }
                        ?></span></span>
                <span style="width:50%; float:left; ">  
                    <?php
                    if (!empty($fst_deposit_type)) {
                        if (in_array("Checking", $fst_deposit_type)) {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/check.png" alt="" style="width: 5%;"> Checking
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Checking
                            <?php
                        }
                    } else {
                        ?>
                        <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Checking
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($fst_deposit_type)) {
                        if (in_array("Saving", $fst_deposit_type)) {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/check.png" alt="" style="width: 5%;"> Saving
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Saving
                            <?php
                        }
                    } else {
                        ?>
                        <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Checking
                        <?php
                    }
                    ?>
                </span>
            </div>
            <div class="details clearfix">
                <h3 style="border-bottom: 2px dotted;">Account #2 (Optional)</h3>
                <span>Employee Bank Name: <span class="text"><?php
                        if (isset($scnd_bank_name) && $scnd_bank_name != '') {
                            echo $scnd_bank_name;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Bank Routing {ABA) #: <span class="text"><?php
                        if (isset($scnd_bank_routing) && $scnd_bank_routing != '') {
                            echo $scnd_bank_routing;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Account No.: <span class="text"><?php
                        if (isset($scnd_account_no) && $scnd_account_no != '') {
                            echo $scnd_account_no;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">Amount: <span class="text"><?php
                        if (isset($scnd_amount) && $scnd_amount != '') {
                            echo $scnd_amount;
                        }
                        ?></span></span>
                <span style="width:50%; float:left;">
                    <?php
                                            //print_r($scnd_deposit_type);
                    if (!empty($scnd_deposit_type)) {
                        if (in_array("Checking", $scnd_deposit_type)) {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/check.png" alt="" style="width: 5%;"> Checking
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Checking
                            <?php
                        }
                    } else {
                        ?>
                        <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Checking
                        <?php
                    }
                    ?>
                    <?php
                    if (!empty($scnd_deposit_type)) {
                        
                        if (in_array("Saving", $scnd_deposit_type)) {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/check.png" alt="" style="width: 5%;"> Saving
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Saving
                            <?php
                        }
                    } else {
                        ?>
                        <img src="<?php echo base_url(); ?>assets/images/uncheck.png" alt="" style="width: 5%;"> Saving
                        <?php
                    }
                    ?>
                </span>
            </div> 
            <p style="text-align: center; text-decoration: underline"><b>Note: This  Process  May Take Up To 2-3 Weeks But Will  Not Dalay Or Hold Back Your Paycheck.</b></p> 
            <p style="margin-bottom:30px;">I hereby authorize <span class="text"><?php
                    if (isset($company_name) && $company_name != '') {
                        echo $company_name;
                    }
                    ?></span> (the Company)  to deposit any amounts  owed  me,  as instructed  by my  employer.  by .nitiating  credit  entries  to my account  at the  financial  institution(hereinafter  "Bank") Indicated on thiS form.  Further, I authorize Bank to accept and to credit any credit entnes Indicated by the Company to my account. In the event that the Company deposits funds erroneously Into my account. Iauthorize  the Company to debit my account for an amount not to exceed the original amount of the erroneous credit. This authorization will be In effect until the Company receives a wrlt1entermination  notice from myself and has a reasonable opportunity to act on it.</p>
            <span style="width:50%; float:left;">Signature <span class="text"><?php
                    if (isset($employee_signature) && $employee_signature != '') {
                        echo $employee_signature;
                    }
                    ?></span></span>
            <span style="width:50%; float:left;">Date <span class="text"><?php
                    if (isset($signature_date) && $signature_date != '0000-00-00') {
                        echo $signature_date;
                    }
                    ?></span></span>
            <span style="width:100%;">Print Name <span class="text"><?php
                    if (isset($employee_name) && $employee_name != '') {
                        echo $employee_name;
                    }
                    ?></span></span>
            <p style="font-style:italic;">Please submit completed form 10 your branch represenralive via fax or mall.  The safety and securlry of your financiai information  is of primary importance  to us.  Due lD the sensllive  natule or rhe informarJon; submlrting e/ecuonlcally  Is nor advised withour the use of 8 secure web porod, and If done so, will be at your own risk.
            </p>
            <br/>

            <div class="col-xs-12 col-sm-12 col-md-12" align="center">
                <a href="javascript:void(0)" onclick="window.print();" class="btn btn-default btn-print" style="text-align:center;">Print</a>
            </div>
        </div>

    </body>
</html>
