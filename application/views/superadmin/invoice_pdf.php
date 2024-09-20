<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Invoice</title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" type="text/css" />
        <style>

            .invoice-title h4, .invoice-title h5 {
                display: inline-block;
            }

            .table > tbody > tr > .no-line {
                border-top: none;
            }
            td, th{ font-size:16px;}
            .table > thead > tr > .no-line {
                border-bottom: none;
            }

            .table > tbody > tr > .thick-line {
                border-top: 2px solid;
            }
            @media print {
                .print-css {
                    display :  none;
                }
                .img-css{
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
                        <?php
                        if (!empty($get_vendor_details)) {
                            ?>
                            <img src="<?php echo base_url(); ?>uploads/<?php echo $get_vendor_details[0]['photo']; ?>" alt="" style="width: 30%;" class="img-css"/>
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo $img_src; ?>" alt="" style="width: 30%;" class="img-css"/>
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
                            <br />
                            <?php
                            if (isset($get_vendor_details[0]['address']) && $get_vendor_details[0]['vendor_company_name'] != '') {
                                echo stripslashes($get_vendor_details[0]['address']);
                            }
                            ?><br /> 
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

                            <br />
                            <span>
                                <?php
                                if (!empty($get_vendor_details)) {
                                    ?>
                                    <strong>Fax No. :</strong>&nbsp;&nbsp;
                                    <?php
                                    echo ($get_vendor_details[0]['fax_no'] != '0') ? $get_vendor_details[0]['fax_no'] : '';
                                }
                                ?>
                            </span><br />
                        </h4>
                        <h5 class="pull-right" style="line-height: 20px;">
                            <span><strong>Invoice: </strong>
                                <?php
                                if (!empty($get_invoice_details)) {
                                    if ($get_invoice_details[0]['vendor_id'] != '0') {
                                        $invoice_code = $this->employee_model->getInvoiceCodeByID($get_invoice_details[0]['timesheet_period_id'], $get_invoice_details[0]['vendor_id']);
                                        if (!empty($invoice_code)) {
                                            echo $invoice_code[0]['invoice_code'];
                                        } else {
                                            echo "";
                                        }
                                    } else {
                                        echo $get_invoice_details[0]['invoice_code'];
                                    }
                                }
                                ?>
                            </span><br />
                            <span><strong>Date:</strong> <?php echo date("jS F, Y", strtotime($get_invoice_details[0]['updated_date'])); ?></span><br />
                            <span><strong>Due Date: </strong><?php echo date("jS F, Y", strtotime("+30 days", strtotime($get_invoice_details[0]['updated_date']))); ?></span>
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
                                            <?php if (LATAM) { ?> 
                                            <h4>ProcureTechStaff <br />155 N Michigan Ave Suite# 513,<br /> Chicago, IL<br /> 60601</h4>   
                                            <?php } ?>
                                            <?php if (US || INDIA) { ?>
                                                <h4>
                                                <?php
                                                    echo CLIENT_NAME . "<br>";
                                                    echo CLIENT_ADDRESS;
                                                ?>
                                            </h4>
                                            <?php }?> 

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
                                        <th>Terms</th>
                                        <th>Project</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <?php
                                            if (!empty($get_employee_details)) {
                                                echo strtoupper($get_employee_details[0]['employee_code']);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span>
                                                <?php
                                                if (!empty($get_work_order_details)) {
                                                    echo stripslashes($get_work_order_details[0]['invoicing_terms']);
                                                }
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span>
                                                <?php
                                                if (isset($assign_prject)) {
                                                    echo rtrim($assign_prject, ",");
                                                }
                                                ?>
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
                                        </span><br />
<!--                                        <span>-->
<!--                                            <strong>Work Duration:&nbsp;&nbsp;</strong>-->
                                        <!--                                            --><?php
//                                            echo $get_invoice_details[0]['work_duration'] . " days";
//                                            
                                        ?>
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
                                        </span><br />

                                    </td>
                                    <td align="center">-</td>
                                    <td align="center">-</td>
                                </tr>
                                <tr>
                                    <td align="center">

                                        <?php
                                        $tot_time = 0;
                                        $tot_time = $get_invoice_details[0]['tot_time'] + $get_invoice_details[0]['over_time'];
                                        echo $tot_time;
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
                                    <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right"><strong>Total</strong></td>
                                    <td style="border-bottom:1px solid #DDDDDD;border-top:none;border-right:none;border-left:none;" align="right">
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
