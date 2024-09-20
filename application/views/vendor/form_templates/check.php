<!DOCTYPE html>
<html lang="en">
<head>
    <title>ACH FORM</title>
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
    </style>
</head>
<body>

<div class="container">
    <div class="image">
        <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="">

        <h2>ACH Form </h2>
    </div>

        <table width="100%" style="border:1px solid black; text-align:center; overflow:hidden">
            <tr>
                <td>Name Of The Corporation</td>
                <td>
                    <?= $name_of_corporation ?>
                </td>
            </tr>
            <tr>
                <td>Address</td>
                <td></td>
            </tr>
            <tr>
                <td>A/R Point of Contact</td>
                <td></td>
            </tr>
            <tr>
                <td>A/R Telephone Number</td>
                <td></td>
            </tr>
            <tr>
                <td>A/R Email</td>
                <td></td>
            </tr>
            <tr>
                <td>Financial Institution</td>
                <td></td>
            </tr>
            <tr>
                <td>Account Number</td>
                <td></td>
            </tr>
            <tr>
                <td>Routing Number</td>
                <td></td>
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
            <div class="col-sm-3"></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label">Name</label>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <label class="control-label">Name</label>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Designation: </label>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <label class="control-label">Designation:</label>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Company Name: </label>
            </div>
            <div class="col-sm-3"></div>
                <label class="control-label">Company Name</label>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="row space">
            <div class="col-sm-3">
                <label class="control-label"> Signature </label>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <label class="control-label">Signature</label>
            </div>
            <div class="col-sm-3"></div>
        </div>
        <div class="image">
            <span>155 N Michigan Ave, Suite 513  Chicago, IL 60601 </span>
            <span>Tel: 773-304-3630</span>
            <span>Fax: 773-747-4056</span>
            <span><a href="#"> www.procuretechstaff.com</a></span>
        </div>


</div>

</body>
</html>
