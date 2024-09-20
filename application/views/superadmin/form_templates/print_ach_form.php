<!DOCTYPE html>
<html lang="en">
<head>
    <title>ACH FORM</title>
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
            width: 24%;
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
            /*border: medium none;*/
            outline: medium none;
            padding: 10px;
            width: 100%;
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
    $name_of_corporation = $form_data_arr->name_of_corporation;
    $corporation_address = $form_data_arr->corporation_address;
    $point_of_contact = $form_data_arr->point_of_contact;
    $telephone_number = $form_data_arr->telephone_number;
    $email = $form_data_arr->email;
    $fin_institution = $form_data_arr->fin_institution;
    $account_no = $form_data_arr->account_no;
    $routing_no = $form_data_arr->routing_no;
    $admin_name = $form_data_arr->admin_name;
    $admin_designation = $form_data_arr->admin_designation;
    $admin_company_name = $form_data_arr->admin_company_name;
    $vendor_name = $form_data_arr->vendor_name;
    $vendor_designation = $form_data_arr->vendor_designation;
    $vendor_company_name = $form_data_arr->vendor_company_name;
    $vendor_signature = $form_data_arr->vendor_signature;
    $vendor_ip = $form_data_arr->vendor_ip;
}
?>
<div class="container">
    <div class="image">
        <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

        <h2>ACH Form </h2>
    </div>

        <table width="100%" style="border:1px solid black; text-align:center; overflow:hidden">
            <tr>
                <td>Name Of The Corporation</td>
                <td class="text" style="font-weight: bold;"><?= $name_of_corporation ?></td>
            </tr>
            <tr>
                <td>Address</td>
                <td class="text" style="font-weight: bold;"><?= $corporation_address ?></td>
            </tr>
            <tr>
                <td>A/R Point of Contact</td>
                <td class="text" style="font-weight: bold;"><?= $point_of_contact ?></td>
            </tr>
            <tr>
                <td>A/R Telephone Number</td>
                <td class="text" style="font-weight: bold;"><?= $telephone_number ?></td>
            </tr>
            <tr>
                <td>A/R Email</td>
                <td class="text" style="font-weight: bold;"><?= $email ?></td>
            </tr>
            <tr>
                <td>Financial Institution</td>
                <td class="text" style="font-weight: bold;"><?= $fin_institution ?></td>
            </tr>
            <tr>
                <td>Account Number</td>
                <td class="text" style="font-weight: bold;"><?= $account_no ?></td>
            </tr>
            <tr>
                <td>Routing Number</td>
                <td class="text" style="font-weight: bold;"><?= $routing_no ?></td>
            </tr>
        </table>


        <div class="image">
            <h4>Accepted by: </h4>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label">Procuretechstaff</label>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><input type="hidden" class="form-control"></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label">Name</label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $admin_name; ?></div>
            <div class="col-sm-3">
                <label class="control-label">Name</label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $vendor_name; ?></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Designation: </label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $admin_designation; ?></div>
            <div class="col-sm-3">
                <label class="control-label">Designation:</label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $vendor_designation; ?></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Company Name: </label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $admin_company_name; ?></div>
            <div class="col-sm-3">
                <label class="control-label">Company Name</label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-weight:bold;"><?php echo $vendor_company_name; ?></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Signature </label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-family: 'Cedarville Cursive', cursive; font-size: 1.7em;">&nbsp;</div>
            <div class="col-sm-3">
                <label class="control-label">Signature</label>
            </div>
            <div class="col-sm-3"
                 style="border-color: currentcolor currentcolor #000;border-image: none;border-style: none none solid;border-width: medium medium 1px; font-family: 'Cedarville-Cursive', cursive; font-size: 1.5em; font-weight: bold;">
                <?php if(isset($vendor_signature) && $vendor_signature != ''){ echo $vendor_signature; } ?>
            </div>
        </div>
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
