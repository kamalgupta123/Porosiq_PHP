<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Purchase Order</title>
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <style>

        .invoice-title h4, .invoice-title h5 {
            display: inline-block;
        }

        .table > tbody > tr > .no-line {
            border-top: none;
        }

        td, th {
            font-size: 16px;
        }

        .table > thead > tr > .no-line {
            border-bottom: none;
        }

        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }

        @media print {
            .print-css {
                display: none;
            }

            .img-css {
                width: 40% !important;
            }
        }
    </style>
</head>

<body style="background-color: #FFFFFF;">
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-xs-12 col-sm-12 col-md-12 separator social-login-box" align="center"><br/>
                <?php //print_r($purchase_order); ?>
                <img src="<?php echo base_url()."assets/client-logo/ptslogo.png"; ?>" alt="" style="width: 30%;" class="img-css"/>
            </div>
            <div class="invoice-title">
                <h5 class="pull-right" style="line-height: 20px;">
                            <span><strong style="font-size: 36px;">PURCHASE ORDER </strong></span>
                    <br/>
                    <br>
                    <span style="margin-left: 193px;"><strong>Date:</strong> <?php echo date("jS F, Y", strtotime($purchase_order['date'])); ?></span><br/>
                    <br>
                    <span style="margin-left: 193px;"><strong> PO # </strong> <?php echo $purchase_order['PONumber']; ?> </span>
                </h5>
            </div>
            <hr/>

            <div class="row">
                <div class="col-xs-5">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>PTS Consulting Services</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Global Headquarter & Operation Center <br>
                                1700 Parkstreet, Suite 212 <br>
                                Naperville, IL, 60563 <br>
                                Phone : 7029425807 <br>
                                Website : www.ptscservices.com
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-5">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background: #05339b;color: #fff;">
                            <th>VENDOR</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Company Name <br>
                                Contact or Department <br>
                                Street Address <br>
                                City, ST, ZIP <br>
                                Phone : (000) 000-0000 <br>
                                Fax : (000) 000-0000 <br>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-xs-2">
                </div>

                <div class="col-xs-5">
                    <table class="table table-bordered">
                        <thead>
                        <tr style="background: #05339b;color: #fff;">
                            <th>SHIP TO</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                PTS Consulting Services <br>
                                1700 Parkstreet, Suite 212 <br>
                                Naperville, IL, 60563 <br>
                                Phone : 7029425807 <br>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr style="background: #05339b;color: #fff;">
                        <th>ITEM #</th>
                        <th>DESCRIPTION</th>
                        <th>QTY</th>
                        <th>UNIT PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="center">3895939</td>
                        <td>
                            <span>
                                <?php
                                echo $purchase_order['description'];
                                ?>
                            </span>
                        </td>
                        <td align="center">
                            <?php
                              echo $purchase_order['quantity'];
                            ?>
                        </td>
                        <td align="center">
                            <?php
                              echo $purchase_order['unit_price'];
                            ?>
                        </td>
                        <td align="center">
                            <?php
                              echo $purchase_order['total'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;     
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;     
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                        <td align="center">
                            &nbsp;
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xs-6 pull-left">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td align="left" style="background-color: #e1dede;">
                            Comments or Special Instructions
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea name="" id="" cols="70" rows="6"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xs-4 pull-right">
            <table class="table">
                <tbody>
                <tr>
                    <td align="left">
                        SUBTOTAL
                    </td>
                    <td align="right">
                        <span>
                            <?php echo $purchase_order['total']; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        TAX
                    </td>
                    <td align="right">
                        <span>
                            -
                        </span>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        SHIPPING
                    </td>
                    <td align="right">
                        <span>
                            -
                        </span>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        OTHER
                    </td>
                    <td align="right">
                        <span>
                            -
                        </span>
                    </td>
                </tr>
                <tr>
                    <td align="left">
                        <strong>TOTAL</strong>
                    </td>
                    <td align="right">
                        <span>
                            <?php echo $purchase_order['total']; ?>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <center>If you have any questions about this purchase order, Please contact Name, Phone, Email</center>

    <span style="text-align: center; font-size: 15px">
        <a href="javascript:void(0)" onclick="window.print();" class="print-css btn btn-default">Print</a>
    </span>
</div>
</body>
</html>
