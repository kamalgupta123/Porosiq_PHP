<!DOCTYPE html>
<html lang="en">
<head>
    <title>Subcontractor Mandatory Insurance Requirements</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            margin: 20px 0;
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

        .container {
            width: 800px;
        }

        .space {
            margin: 30px 0;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .work {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: underline;
        }

        .work1 {
            text-align: center;
            font-size: 16px;
            font-weight: bold;;
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

    $vendor_ip = $form_data_arr->vendor_ip;
}
?>
<div class="container">
    <div class="image">
        <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

        <h2>Subcontractor Mandatory Insurance Requirements</h2>
    </div>
        <div class="row space">
            <div class="col-sm-6 work">Workers Compensation</div>
            <div class="col-sm-6 work"> Statutory Limits</div>
        </div>
        <div class="row space">
            <div class="col-sm-6 work1">General Liability Limit</div>
            <div class="col-sm-6"></div>
        </div>
        <div class="row space">
            <div class="col-sm-6 work1">Each Occurrence</div>
            <div class="col-sm-6 work1">$1,000,000</div>
        </div>
        <div class="row space">
            <div class="col-sm-6 work1">Annual Aggregate</div>
            <div class="col-sm-6 work1">$2,000,000</div>
        </div>
        <div class="row space">
            <div class="col-sm-6 work1">Automobile Liability</div>
            <div class="col-sm-6 work1"></div>
        </div>
        <div class="row space">
            <div class="col-sm-6 work1">Business Auto</div>
            <div class="col-sm-6 work1">$1,000,000</div>
        </div>
        <p>(If no owned vehicles – This would be satisfied by showing hired & non-owned auto liability on the
            certificate) </p>

        <div class="row space">
            <div class="col-sm-6 work1">Umbrella Liability Limit</div>
            <div class="col-sm-6 work1">$1,000,000</div>
        </div>
        <p><strong>Workers Compensation Coverage</strong> – State Statutory coverage with the owners included for
            coverage
            for $1 Million</p>

        <div class="image">
            <span><strong>Certificate Holder should read:</strong>	</span>
            <span>PNC	Capital	LLC,	DBA	Procuretechstaff	Consulting	Services</span>
            <span>155	N	Michigan	Avenue,	Suite	513</span>
            <span>Chicago,	IL	60601</span>
        </div>

        <div class="image">
            <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
            <span>Tel: 773-304-3630</span>
            <span>Fax: 773-747-4056</span>
            <span><a href="#"> www.procuretechstaff.com</a></span>
        </div>
    <div style="text-align:left;font-size: 12px;"> <?php if(isset($vendor_ip) && $vendor_ip != ''){ echo "IP". " - ".$vendor_ip; } ?></div>
    <div style="text-align: center;">
        <a href="javascript:void(0)" id="print" onclick="window.print();" class="btn btn-default"><i class="fa fa-print" aria-hidden="true"></i> Print</a>
    </div>
</div>

</body>
</html>
