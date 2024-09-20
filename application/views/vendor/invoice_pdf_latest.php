<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
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
            <br>
        <span style="text-align: center; font-size: 15px">
        <a href="<?php echo base_url('vendor_consultant_invoice'); ?>" class="btn btn-primary">Back to List</a>
        </span>
            <div class="col-xs-12 col-sm-12 col-md-12 separator social-login-box" align="center"><br/>
                <?php
                // print_r($purchase_order);
                if (!empty($get_vendor_details)) {
                    ?>
                     <img src="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_details[0]['photo']; ?>" alt=""
                          style="width: 30%;" class="img-css"/>
                    <?php
                } else {
                    ?>
                    <img src="<?php echo base_url().CLIENT_LOGO; ?>" alt="" style="width: 30%;" class="img-css"/>
                    <?php
                }
                ?>
            </div>
            <div class="invoice-title">
                <h4>
                    <?php
                    if (isset($get_vendor_details[0]['vendor_company_name']) && $get_vendor_details[0]['vendor_company_name'] != '') {
                        echo ucwords($get_vendor_details[0]['vendor_company_name']);
                    }
                    ?>
                    <br/>
                    <?php
                    if (isset($get_vendor_details[0]['address']) && $get_vendor_details[0]['vendor_company_name'] != '') {
                        echo stripslashes($get_vendor_details[0]['address']);
                    }
                    ?><br/>
                            <span>
                                <?php
                                if (!empty($get_vendor_details)) {
                                    ?>
                                    <strong>Phone No.:</strong>&nbsp;&nbsp;
                                    <?php
                                    echo ($get_vendor_details[0]['phone_no'] != '0') ? $get_vendor_details[0]['phone_no'] : '';

                                }
                                ?>
                            </span>

                    <br/>
                            <span>
                                <?php
                                if (!empty($get_vendor_details)) {
                                    ?>
                                    <strong>Fax No. :</strong>&nbsp;&nbsp;
                                    <?php
                                    echo ($get_vendor_details[0]['fax_no'] != '0') ? $get_vendor_details[0]['fax_no'] : '';
                                }
                                ?>
                            </span><br/>
                </h4>
                <h5 class="pull-right" style="line-height: 20px;">
                            <span><strong>Invoice: </strong>
                            <?php
                              echo $purchase_order['invoice'];
                            ?>
                            </span>
                    <br/>
                    <span><strong>Date:</strong> <?php echo date("jS F, Y", strtotime($purchase_order['date'])); ?></span><br/>
                    <span><strong>Due
                            Date: </strong><?php echo date("jS F, Y", strtotime("+30 days", strtotime($purchase_order['date']))); ?></span>
                </h5>
            </div>
            <hr/>

            <div class="row">
                <div class="col-xs-6">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Bill to</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <h4>PTS Consulting Services<br/>
                                Global Headquarter & Operation Center <br>
                                1700 Parkstreet, Suite 212 <br>
                                Naperville, IL, 60563
                                </h4>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-6 pull-right">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>P.O. No.</th>
                            <th>Store</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <?php echo $purchase_order['PONumber']; ?>
                            </td>
                            <td>
                                <span>
                                    <?php echo $purchase_order['store']; ?>
                                </span>
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
                <?php
                $tot_amount = "0";
                $tax_amount = "0";
                if ($get_invoice_details[0]['payment_type'] == '1' || $get_invoice_details[0]['payment_type'] == '3') {
                    $get_working_days = $this->employee_model->getWorkingDays($get_invoice_details[0]['payment_type'], $get_invoice_details[0]['start_date'], $get_invoice_details[0]['end_date'], $get_invoice_details[0]['employee_id']);
                } elseif ($get_invoice_details[0]['payment_type'] == '2') {
                    $get_working_days = $this->employee_model->getWorkingDaysMonthly($get_invoice_details[0]['payment_type'], $get_invoice_details[0]['month'], $get_invoice_details[0]['year'], $get_invoice_details[0]['employee_id']);
                }
                ?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Description</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td align="center">-</td>
                        <td>
                                        <span>
                                            <strong>Payment Mode:&nbsp;&nbsp;</strong>
                                            <?php
                                            if ($get_invoice_details[0]['payment_type'] == '1') {
                                                echo "Net 45";
                                            } elseif ($get_invoice_details[0]['payment_type'] == '2') {
                                                echo "Net 45";
                                            } elseif ($get_invoice_details[0]['payment_type'] == '3') {
                                                echo "Net 45";
                                            }
                                            ?>
                                        </span><br/>
                            <!--                                        <span>-->
                            <!--                                            <strong>Work Duration:&nbsp;&nbsp;</strong>-->
                            <!--                                            --><?php
                            //                                            echo $get_invoice_details[0]['work_duration'] . " days";
                            //                                            ?>
                            <!--                                        </span><br />-->
                                        <span>
                                            <strong>Work Period:&nbsp;&nbsp;</strong>
                                            <?php
                                            //                echo "<pre>";
                                            //                print_r($get_working_days);
                                            //                                            foreach ($get_working_days as $wkey => $wdays) {
                                            //                                                $first_day = date("d-m-Y", strtotime($get_working_days[0]['project_date']));
                                            //                                                $last_day = date("d-m-Y", strtotime($wdays['project_date']));
                                            //                                            }
                                            echo $get_invoice_details[0]['start_date'] . " - " . $get_invoice_details[0]['end_date'];
                                            ?>
                                        </span><br/>

                        </td>
                        <td align="center">-</td>
                        <td align="center">-</td>
                    </tr>
                    <tr>
                        <td align="center">

                            <?php
                              echo $purchase_order['quantity'];
                            ?>

                        </td>
                        <td align="right"><label>Standard Rate</label></td>
                        <td align="right">
                            <?php
                            echo "$" . $get_invoice_details[0]['bill_rate'];
                            ?>
                        </td>
                        <td align="right">
                            <?php
                            echo "$" . number_format($get_invoice_details[0]['tot_time_pay'], 2);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">-</td>
                        <td align="right"><label>Over Time Rate</label></td>
                        <td align="right">
                            <?php
                            echo "$" . $get_invoice_details[0]['ot_rate'];
                            ?>
                        </td>
                        <td align="right">
                            <?php
                            echo "$" . number_format($get_invoice_details[0]['over_time_pay'], 2);
                            ?>
                        </td>
                    </tr>
                    <?php
                    /*
                      <tr>
                      <td colspan="2"></td>
                      <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right"><strong>Sub Total</strong></td>
                      <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right">
                      <?php

                      $tot_amount = $get_invoice_details[0]['tot_time_pay'] + $get_invoice_details[0]['over_time_pay'];
                      echo "$" . number_format($tot_amount, 2);
                      ?>
                      </td>
                      </tr>
                      <tr>
                      <td colspan="2"></td>
                      <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right"><strong>Tax 0%</strong></td>
                      <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right">
                      <?php

                      $tax = "0";
                      $tax_amount = ($tot_amount * $tax) / 100;
                      echo "$" . number_format($tax_amount, 2);
                      ?>
                      </td>
                      </tr>
                     */
                    ?>
                    <tr>
                        <td colspan="2"></td>
                        <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;"
                            align="right"><strong>Total</strong></td>
                        <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;"
                            align="right">
                            <?php
                            //                                        $grand_total = $tot_amount + $tax_amount;
                            //                                        echo "$" . number_format($grand_total, 2);
                            $tot_amount = $get_invoice_details[0]['tot_time_pay'] + $get_invoice_details[0]['over_time_pay'];
                            echo "$" . number_format($tot_amount, 2);
                            ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

            <span style="text-align: center; font-size: 15px">
                <a href="javascript:void(0)" onclick="window.print();" class="print-css btn btn-default">Print</a>
            </span>
</div>
</body>
</html>
