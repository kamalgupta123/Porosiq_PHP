<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ACH FORM</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>

            img {
                text-align: center;
                width: 40%;
            }

            span {
                display: block;
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

            .col-sm-3 {
                width: 25%;
                min-height: 1px;
                padding-left: 15px;
                padding-right: 15px;
                position: relative;
                float: left;
            }

            .image {
                text-align: center;
            }

            .image h4 {
                margin: 35px 0 0;
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
                padding: 10px 0;
            }

            .text {
                border: medium none;
                outline: medium none;
                padding: 10px;
                width: 100%;
            }

            .container {
                width: 911px;
                margin-left: 46px;

            }

            .space {
                margin: 30px 0;
            }

            .form-control:focus {
                box-shadow: none;
            }

            .mar{ margin-bottom: 10px;}
            @media print
            {    
                .btn-print
                {
                    display: none !important;
                }
            }

        </style>
    </head>
    <body style="font-size:14px;">

        <div class="container">
            <div class="image">

                <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

                <h2>ACH Form </h2>
            </div>

            <table width="100%" style="border:1px solid black; text-align:center; overflow:hidden;border-collapse: collapse;
                   border-spacing: 0;">
                <tr>
                    <td style="border: 1px solid #000;width: 50%;">Name Of The Corporation</td>
                    <td style="border: 1px solid #000;width: 50%; font-weight: bold;">
                        <?= $name_of_corporation ?>
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td style="font-weight: bold;">
                        <?= $corporation_address ?>
                    </td>
                </tr>
                <tr>
                    <td>A/R Point of Contact</td>
                    <td style="font-weight: bold;">
                        <?= $point_of_contact ?>
                    </td>
                </tr>
                <tr>
                    <td>A/R Telephone Number</td>
                    <td style="font-weight: bold;">
                        <?= $telephone_number ?>
                    </td>
                </tr>
                <tr>
                    <td>A/R Email</td>
                    <td style="font-weight: bold;">
                        <?= $email ?>
                    </td>
                </tr>
                <tr>
                    <td>Financial Institution</td>
                    <td style="font-weight: bold;">
                        <?= $fin_institution ?>
                    </td>
                </tr>
                <tr>
                    <td>Account Number</td>
                    <td style="font-weight: bold;">
                        <?= $account_no ?>
                    </td>
                </tr>
                <tr>
                    <td>Routing Number</td>
                    <td style="font-weight: bold;">
                        <?= $routing_no ?>
                    </td>
                </tr>
            </table>


            <div class="image">
                <h4>Accepted by: </h4>
            </div>
            <table width="95%" style="border:none; text-align:center; overflow:hidden;border-collapse: collapse; border-spacing: 0;">
                <tr class="mar">
                    <td style="border: none;width: 20%;">Procuretechstaff</td>
                    <td style="border: none;width: 20%;">&nbsp;</td>
                    <td style="border: none;width: 20%;">&nbsp;</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%;">&nbsp;</td>
                </tr>
                <tr class="mar">
                    <td style="border: none;width: 20%;">Name</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($admin_name) && $admin_name != '') {
                            echo $admin_name;
                        }
                        ?>
                    </td>
                    <td style="border: none;width: 20%;">Name</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($vendor_name) && $vendor_name != '') {
                            echo $vendor_name;
                        }
                        ?>
                    </td>
                </tr>
                <tr class="mar">
                    <td style="border: none;width: 20%;">Designation</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($admin_designation) && $admin_designation != '') {
                            echo $admin_designation;
                        }
                        ?>
                    </td>
                    <td style="border: none;width: 20%;">Designation</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($vendor_designation) && $vendor_designation != '') {
                            echo $vendor_designation;
                        }
                        ?>
                    </td>
                </tr>
                <tr class="mar">
                    <td style="border: none;width: 20%;">Company Name</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($admin_company_name) && $admin_company_name != '') {
                            echo $admin_company_name;
                        }
                        ?>
                    </td>
                    <td style="border: none;width: 20%;">Company Name</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-weight: bold;">
                        <?php
                        if (isset($vendor_company_name) && $vendor_company_name != '') {
                            echo $vendor_company_name;
                        }
                        ?>
                    </td>
                </tr>
                <tr class="mar">
                    <td style="border: none;width: 20%;">Signature</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-family: 'Dancing Script', cursive; font-size: 1.5em;">
                        <?php
                        if (isset($admin_name) && $admin_name != '') {
                            echo $admin_name;
                        }
                        ?>
                    </td>
                    <td style="border: none;width: 20%;">Signature</td>
                    <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 20%; font-family: 'Dancing Script', cursive; font-size: 1.5em;">
                        <?php
                        if (isset($vendor_signature) && $vendor_signature != '') {
                            echo $vendor_signature;
                        }
                        ?>
                    </td>
                </tr>

            </table>

            <br/>
            <br/>

            <div class="image">
                <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
                <span>Tel: 773-304-3630</span>
                <span>Fax: 773-747-4056</span>
                <span><a href="#"> www.procuretechstaff.com</a></span>
            </div>
            <div style="text-align:left;font-size: 12px;"> <?php
                if (isset($vendor_ip) && $vendor_ip != '') {
                    echo "IP" . " - " . $vendor_ip;
                }
                ?></div>
            <div class="col-xs-12 col-sm-12 col-md-12" align="center">
                <a href="javascript:void(0)" onclick="window.print();" class="btn btn-default btn-print" style="text-align:center;">Print</a>
            </div>
        </div>

    </body>
</html>
