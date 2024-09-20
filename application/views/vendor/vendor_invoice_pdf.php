<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Payment Invoice</title>
    <style>

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            width: 100%;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid #5D6975;
            border-bottom: 1px solid #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(<?php echo $dimension; ?>);
        }

        #project {
            float: right;
            width: 30%;
            clear: both;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {

            text-align: left;
            margin: 0 0 20px 0;
            float: left;
            width: 30%;
            clear: both;
        }

        #project div,
        #company div {
            white-space: nowrap;
        }

        table tr:nth-child(2n-1) td {
            background: #fff;
        }

        table th,
        table td {
            text-align: left;
        }

        table th {
            padding: 5px 20px;
            color: #000000;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }
        .image {
            text-align: center;
        }
        table .service,
        table .desc {
            text-align: center;
        }

        table td {
            padding: 2px;
            text-align: left;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #000;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    <div id="logo">
        <img src="<?php echo $img_src; ?>" style="width: 49%;">
    </div>
    <h1>PAYMENT INVOICE</h1>
    <br/>

    <div style="text-align: center; font-size: 15px;">
        <label>Payment Invoice for
            <?php
            if ($get_invoice_details[0]['payment_type'] == '1' || $get_invoice_details[0]['payment_type'] == '3') {
                echo date("m-d-Y",strtotime($get_invoice_details[0]['start_date'])) . " - " . date("m-d-Y",strtotime($get_invoice_details[0]['end_date']));
            }
            ?>
            <?php
            if ($get_invoice_details[0]['payment_type'] == '2') {
                if ($get_invoice_details[0]['month'] == '01') {
                    echo "January";
                } else if ($get_invoice_details[0]['month'] == '02') {
                    echo "February";
                } else if ($get_invoice_details[0]['month'] == '03') {
                    echo "March";
                } else if ($get_invoice_details[0]['month'] == '04') {
                    echo "April";
                } else if ($get_invoice_details[0]['month'] == '05') {
                    echo "May";
                } else if ($get_invoice_details[0]['month'] == '06') {
                    echo "June";
                } else if ($get_invoice_details[0]['month'] == '07') {
                    echo "July";
                } else if ($get_invoice_details[0]['month'] == '08') {
                    echo "August";
                } else if ($get_invoice_details[0]['month'] == '09') {
                    echo "September";
                } else if ($get_invoice_details[0]['month'] == '10') {
                    echo "October";
                } else if ($get_invoice_details[0]['month'] == '11') {
                    echo "November";
                } else if ($get_invoice_details[0]['month'] == '12') {
                    echo "December";
                }
                echo ", " . $get_invoice_details[0]['year'];
            }
            ?>
        </label>
    </div>
    <table width="100%" style="border:1px solid black;background: #fff; font-size: 11px">
        <tbody>
        <tr>
            <td>COMPANY NAME</td>
            <td><label style="font-weight: bold;"><?php echo $get_vendor_details[0]['vendor_company_name'] ?></label></td>
            <td>INVOICE ID</td>
            <td><label style="font-weight: bold;"><?php echo $get_invoice_details[0]['invoice_id']; ?></label></td>
        </tr>
        <tr>
            <td>ADDRESS</td>
            <td><label style="font-weight: bold;"><?php echo $get_vendor_details[0]['address'] ?></td>
            <td>DATE</td>
            <td><label style="font-weight: bold;"><?php echo date("jS F, Y", strtotime($get_invoice_details[0]['updated_date'])); ?></label></td>
        </tr>
        <tr>
            <td>PHONE NO.</td>
            <td>
                <label style="font-weight: bold;"><?php echo ($get_vendor_details[0]['phone_no'] != '0') ? $get_vendor_details[0]['phone_no'] : ''; ?></label>
            </td>
            <td>DUE DATE</td>
            <td>
                <label style="font-weight: bold;"><?php echo date("jS F, Y", strtotime("+15 days", strtotime($get_invoice_details[0]['updated_date']))); ?></label>
            </td>
        </tr>
        <tr>
            <td>FAX NO.</td>
            <td>
                <label style="font-weight: bold;"><?php echo ($get_vendor_details[0]['fax_no'] != '0') ? $get_vendor_details[0]['fax_no'] : ''; ?></label>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>EMAIL ID</td>
            <td><label style="font-weight: bold;"><a href="mailto:<?php echo $get_vendor_details[0]['vendor_email'] ?>"><?php echo $get_vendor_details[0]['vendor_email'] ?>
                </label></a></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>

    <br/>
    <br/>

    <table width="100%" style="border:1px solid black;background: #fff; font-size: 11px">
        <tbody>
        <tr>
            <td>EMPLOYEE NAME</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><label style="font-weight: bold;"><?php echo $get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']; ?></label></td>
        </tr>
        <tr>
            <td>EMPLOYEE CODE</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><label style="font-weight: bold;"><?php echo $get_employee_details[0]['employee_code']; ?></label></td>
        </tr>
        <tr>
            <td>EMPLOYEE DESIGNATION</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><label style="font-weight: bold;"><?php echo $get_employee_details[0]['employee_designation']; ?></label></td>
        </tr>
        </tbody>
    </table>

    <br/>
    <br/>
    <?php
    if($get_invoice_details[0]['payment_type'] == '1' || $get_invoice_details[0]['payment_type'] == '3') {
        $get_working_days = $this->employee_model->getWorkingDays($get_invoice_details[0]['payment_type'], $get_invoice_details[0]['start_date'], $get_invoice_details[0]['end_date'], $get_invoice_details[0]['employee_id']);
    }
    elseif($get_invoice_details[0]['payment_type'] == '2'){
        $get_working_days = $this->employee_model->getWorkingDaysMonthly($get_invoice_details[0]['payment_type'], $get_invoice_details[0]['month'], $get_invoice_details[0]['year'], $get_invoice_details[0]['employee_id']);
    }
    ?>
    <table width="100%" style="border:1px solid black;background: #fff; font-size: 11px">
        <thead>
        <tr>
            <th class="desc" style="font-weight: bold;">Working Days</th>
            <th class="desc" style="font-weight: bold;">Standard Time (Hours)</th>
            <th class="desc" style="font-weight: bold;">Over Time (Hours)</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if(!empty($get_working_days)) {
            foreach($get_working_days as $wdays) {
                ?>
                <tr>
                    <td class="desc"><?php echo date("m-d-Y",strtotime($wdays['project_date'])); ?></td>
                    <td class="desc"><?php echo $wdays['tot_time']; ?></td>
                    <td class="desc"><?php echo $wdays['over_time']; ?></td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
    </table>

    <br/>
    <br/>

    <table width="100%" style="border:1px solid black;background: #fff; font-size: 11px">
        <thead>
        <tr>
            <th class="desc" style="font-weight: bold;">Payment Mode</th>
            <th class="desc" style="font-weight: bold;">Work Duration</th>
            <th class="desc" style="font-weight: bold;">Work Period</th>
            <th class="desc">&nbsp;</th>
            <th class="desc">&nbsp;</th>
            <th class="desc">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="desc">
                <?php
                if ($get_invoice_details[0]['payment_type'] == '1') {
                    echo "Weekly Payment";
                } elseif ($get_invoice_details[0]['payment_type'] == '2') {
                    echo "Monthly Payment";
                } elseif ($get_invoice_details[0]['payment_type'] == '3') {
                    echo "Daily Payment";
                }
                ?>
            </td>
            <td class="desc">
                <?php
                echo $get_invoice_details[0]['work_duration'] . " days";
                ?>
            </td>
            <td class="desc" style="font-size: 10px;">
                <?php
                //                echo "<pre>";
                //                print_r($get_working_days);
                foreach ($get_working_days as $wkey => $wdays) {
                    $first_day = date("m-d-Y", strtotime($get_working_days[0]['project_date']));
                    $last_day = date("m-d-Y", strtotime($wdays['project_date']));
                }
                echo $first_day . " - " . $last_day;
                ?>
            </td>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Standard Time</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo $get_invoice_details[0]['tot_time'] . " hours";
                ?>
            </td>
            <td class="desc">&nbsp;</td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Standard Rate</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo "$" . $get_invoice_details[0]['bill_rate'];
                ?>
            </td>
            <td class="desc">&nbsp;</td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Standard Pay</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo "$" . number_format($get_invoice_details[0]['tot_time_pay'], 2);
                ?>
            </td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Over Time</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo $get_invoice_details[0]['over_time'] . " hours";
                ?>
            </td>
            <td class="desc">&nbsp;</td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Overtime Rate</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo "$" . $get_invoice_details[0]['ot_rate'];
                ?>
            </td>
            <td class="desc">&nbsp;</td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Overtime Pay</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="text-align: right;">
                <?php
                echo "$" . number_format($get_invoice_details[0]['over_time_pay'], 2);
                ?>
            </td>
        </tr>
        <tr>

            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Sub Total</td>
            <td class="desc">&nbsp;</td>
            <td class="total" style="text-align: right;">
                <?php
                $tot_amount = $get_invoice_details[0]['tot_time_pay'] + $get_invoice_details[0]['over_time_pay'];
                echo "$" . number_format($tot_amount, 2);
                ?>
            </td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Tax 0%</td>
            <td class="desc">&nbsp;</td>
            <td class="total" style="text-align: right;">
                <?php
                $tax = "0";
                $tax_amount = ($tot_amount * $tax) / 100;
                echo "$" . number_format($tax_amount, 2);
                ?>
            </td>
        </tr>
        <tr>
            <td class="desc">&nbsp;</td>
            <td class="desc">&nbsp;</td>
            <td class="desc" style="font-weight: bold;" colspan="2">Grand Total</td>
            <td class="desc">&nbsp;</td>
            <td class="grand total" style="text-align: right;">
                <?php
                $grand_total = $tot_amount + $tax_amount;
                echo "$" . number_format($grand_total, 2);
                ?>
            </td>
        </tr>
        </tbody>
    </table>
</header>
<br/>
<br/>
<br/>
<main>
    <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 15 days.</div>
    </div>
</main>
<br/>
<br/>
<br/>
<footer>
    <div class="image">
        <p>Invoice was created on a computer and is valid without the signature and seal.</p>
    </div>
</footer>
</body>
</html>