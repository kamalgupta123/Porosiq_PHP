<!DOCTYPE html>
<html lang="en">
<head>
    <title>WORK ORDER</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans|Rock+Salt|Shadows+Into+Light|Cedarville+Cursive">
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
        .container{ width:800px;}
        .space{ margin:30px 0 ;}
        .form-control:focus {
            box-shadow:none;
        }
    </style>
</head>
<body>
<?php
$get_admin_details = $this->employee_model->getAdminDetails($get_work_order[0]['admin_id']);
?>

<div class="container">
    <div class="image">
        <img src="<?php echo $img_src; ?>" alt="">
        <h2>Work Order </h2>
    </div>
    <table width="85%" style="border:1px solid black; text-align:center; overflow:hidden;border-collapse: collapse;">
        <tr>
            <td>Consultant</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['consultant'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Vendor</td>
            <td style="padding:15px 0;">&nbsp;</td>
        </tr>
        <tr>
            <td>Start Date</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['start_date'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Duration of Project</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['project_duration'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Bill Rate</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['bill_rate'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>OT Rate</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['ot_rate'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Client Name</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['client_name'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Invoicing Terms</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['invoicing_terms'];
                    ?>
                </label>
            </td>
        </tr>
        <tr>
            <td>Payment Terms</td>
            <td style="padding:15px 0;">
                <label>
                    <?php
                    echo $get_work_order[0]['payment_terms'];
                    ?>
                </label>
            </td>
        </tr>
    </table>



    <div class="image">
        <p>Note: UHG 5% Tenure discount after the first 6 months and then another 5% for the following 6 months.</p>

        <h4>Accepted by: </h4>
    </div>

    <table width="80%" style="border:none; text-align:center; overflow:hidden;border-collapse: collapse; border-spacing: 0;">
        <tr class="mar">
            <td style="border: none;width: 50%;">Procuretechstaff</td>
            <td style="border: none;width: 50%;">&nbsp;</td>
            <td style="border: none;width: 50%;">&nbsp;</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%;">&nbsp;</td>
        </tr>
        <tr class="mar">
            <td style="border: none;width: 50%;">Name</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">
                <label>
                    <?php
                    echo $get_admin_details[0]['first_name']." ".$get_admin_details[0]['last_name'];
                    ?>
                </label>
            </td>
            <td style="border: none;width: 50%;">Name</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">&nbsp;</td>
        </tr>
        <tr class="mar">
            <td style="border: none;width: 50%;">Designation</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">
                <label>
                    <?php
                    echo $get_admin_details[0]['admin_designation'];
                    ?>
                </label>
            </td>
            <td style="border: none;width: 50%;">Designation</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">&nbsp;</td>
        </tr>
        <tr class="mar">
            <td style="border: none;width: 50%;">Company Name</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">
                <label>
                    <?php
                    echo $get_admin_details[0]['admin_company_name'];
                    ?>
                </label>
            </td>
            <td style="border: none;width: 50%;">Company Name</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%; font-weight: bold;">&nbsp;</td>
        </tr>
        <tr class="mar">
            <td style="border: none;width: 50%;">Signature</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%;">
                <label>
                    <?php
                    echo $get_work_order[0]['admin_signature'];
                    ?>
                </label>
            </td>
            <td style="border: none;width: 50%;">Signature</td>
            <td style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px;width: 50%;">&nbsp;</td>
        </tr>

    </table>
    <div class="image">
        <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
        <span>Tel: 773-304-3630</span>
        <span>Fax: 773-747-4056</span>
        <span><a href="#">  www.procuretechstaff.com</a></span>
    </div>
</div>

</body>
</html>
