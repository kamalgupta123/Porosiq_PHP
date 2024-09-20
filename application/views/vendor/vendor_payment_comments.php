<?php
$this->load->view('vendor/includes/header');
?>

<style>
    .dataTables_filter {
        display: none !important;
    }

    .separator {
        border-right: 1px solid #dfdfe0;
    }

    .icon-btn-save {
        padding-top: 0;
        padding-bottom: 0;
    }

    .input-group {
        margin-bottom: 10px;
        width: 90%;
    }

    .btn-save-label {
        position: relative;
        left: -12px;
        display: inline-block;
        padding: 6px 12px;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 3px 0 0 3px;
    }

    .formError .formErrorContent {
        min-width: 150px !important;
    }

    .fa-lock {
        color: #f90000;
    }

    .fa-times {
        color: #f90000;
    }

    .fa-check {
        color: #009900;
    }

    .tbl_icon {
        font-size: 18px;
        padding: 0 2px;
    }
    .chat
    {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .chat li
    {
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px dotted #B3A9A9;
    }

    .chat li.left .chat-body
    {
        margin-left: 60px;
    }

    .chat li.right .chat-body
    {
        margin-right: 60px;
    }


    .chat li .chat-body p
    {
        margin: 0;
        color: #777777;
    }
</style>

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <?php
            $this->load->view('vendor/includes/upper_menu');
            ?>
        </nav>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!--                <h1>-->
            <!--                    User Profile-->
            <!--                </h1>-->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Invoice Comments Management</a></li>
            </ol>
        </section>

        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Payment Comments Management</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Consultant Name</th>
                                            <th>Consultant Code</th>
                                            <th>Consultant Designation</th>
                                            <th>Payment Mode</th>
                                            <th>Date</th>
                                            <th>Monthly</th>
                                            <th>Working Days</th>
                                            <th>Time</th>
                                            <th>Rate</th>
                                            <th>Pay</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($get_payment_details > 0)) {

                                            foreach ($get_payment_details as $aval) {

                                                $get_employee_details = $this->employee_model->getEmployeeData($aval['employee_id']);
                                                $check_invoice = $this->employee_model->checkInvoice($aval['employee_id'], $aval['payment_type']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']; ?></td>
                                                    <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                    <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($aval['payment_type'] == '1') {
                                                            echo "Weekly Invoice";
                                                        } elseif ($aval['payment_type'] == '2') {
                                                            echo "Monthly Invoice";
                                                        } elseif ($aval['payment_type'] == '3') {
                                                            echo "Daily Payment";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo ($aval['start_date'] != '0000-00-00') ? $aval['start_date'] : '';
                                                        echo " - ";
                                                        echo ($aval['end_date'] != '0000-00-00') ? $aval['end_date'] : '';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($aval['month'] == '01') {
                                                            echo "January";
                                                        } else if ($aval['month'] == '02') {
                                                            echo "February";
                                                        } else if ($aval['month'] == '03') {
                                                            echo "March";
                                                        } else if ($aval['month'] == '04') {
                                                            echo "April";
                                                        } else if ($aval['month'] == '05') {
                                                            echo "May";
                                                        } else if ($aval['month'] == '06') {
                                                            echo "June";
                                                        } else if ($aval['month'] == '07') {
                                                            echo "July";
                                                        } else if ($aval['month'] == '08') {
                                                            echo "August";
                                                        } else if ($aval['month'] == '09') {
                                                            echo "September";
                                                        } else if ($aval['month'] == '10') {
                                                            echo "October";
                                                        } else if ($aval['month'] == '11') {
                                                            echo "November";
                                                        } else if ($aval['month'] == '12') {
                                                            echo "December";
                                                        }
                                                        echo ", " . $aval['year'];
                                                        ?>
                                                    </td>
                                                    <td><?php echo $aval['work_duration'] . " Days"; ?></td>
                                                    <td>
                                                        <div><strong>Standard Time :</strong><br/> <?php echo $aval['tot_time'] . " hours"; ?></div><br/>
                                                        <div><strong>Over Time :</strong><br/> <?php echo $aval['over_time'] . " hours"; ?></div>
                                                    </td>
                                                    <td>
                                                        <div><strong>Standard Rate :</strong><br/> <?php echo ($aval['bill_rate'] != '') ? "$" . number_format($aval['bill_rate'], 2) : "0.00"; ?></div><br/>
                                                        <div><strong>Over Time Rate :</strong><br/> <?php echo ($aval['ot_rate'] != '') ? "$" . number_format($aval['ot_rate'], 2) : "0.00"; ?></div>
                                                    </td>
                                                    <td>
                                                        <div><strong>Standard Pay :</strong><br/> <?php echo ($aval['tot_time_pay'] != '') ? "$" . number_format($aval['tot_time_pay'], 2) : "0.00"; ?></div><br/>
                                                        <div><strong>Over Time Pay :</strong><br/> <?php echo ($aval['over_time_pay'] != '') ? "$" . number_format($aval['over_time_pay'], 2) : "0.00"; ?></div>

                                                    </td>

                                                    <td>
                                                        <?php
                                                        if ($aval['status'] != '0') {
                                                            ?>
                                                            <a class="tbl_icon fancybox"
                                                               href="<?php echo base_url('vendor_invoice_pdf/' . base64_encode($aval['id'])); ?>"
                                                               data-toggle="tooltip" title="Download PDF"><i
                                                                    class="fa fa-file-pdf-o"
                                                                    aria-hidden="true" style="color:red;"></i></a>

                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }
                                        }
                                        ?>

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <div class="box">
                            <div class="box-body table-responsive">
                                <ol class="chat">
                                    <?php
                                    if (!empty($get_payment_comments)) {
                                        foreach ($get_payment_comments as $pval) {
                                            if ($pval['sender_type'] == 'admin') {
                                                $from_details = $this->employee_model->getAdminDetails($pval['sender_id']);
                                                $from_name = $from_details[0]['name_prefix'] . " " . ucwords($from_details[0]['first_name']." ".$from_details[0]['last_name']);
                                            } else {
                                                $from_details = $this->employee_model->getVendorDetails($pval['sender_id']);
                                                $from_name = ucwords($from_details[0]['vendor_company_name']);
                                            }
                                            if ($pval['recipient_type'] == 'admin') {
                                                $to_details = $this->employee_model->getAdminDetails($pval['recipient_id']);
                                                $to_name = $to_details[0]['name_prefix'] . " " . ucwords($to_details[0]['first_name']." ".$to_details[0]['last_name']);
                                            } else {
                                                $to_details = $this->employee_model->getVendorDetails($pval['recipient_id']);
                                                $to_name = ucwords($to_details[0]['vendor_company_name']);
                                            }

                                            $datetime1 = new DateTime(date("Y-m-d h:i:s"));
                                            $datetime2 = new DateTime($pval['entry_date']);
                                            $interval = $datetime1->diff($datetime2);
                                            ?>
                                            <li class="left clearfix">
                                                <div class="chat-body clearfix">
                                                    <div class="header">
                                                        <p>
                                                            <strong class="primary-font">From : </strong> 
                                                            <?php
                                                            echo $from_name;
                                                            ?>
                                                        </p>
                                                        <p>
                                                            <strong class="primary-font">To : </strong> 
                                                            <?php
                                                            echo $to_name;
                                                            ?>
                                                        </p>
                                                        <p>
                                                            <strong class="primary-font">Subject : </strong>  
                                                            <?php
                                                            echo stripslashes($pval['subject']);
                                                            ?>
                                                        </p>
                                                        <small class="pull-right text-muted">
                                                            <span class="glyphicon glyphicon-time"></span><?php echo $interval->format('%h') . " hours " . $interval->format('%i') . " minutes"; ?> ago
                                                        </small>
                                                    </div>
                                                    <p>
                                                        <?php
                                                        echo stripslashes($pval['message']);
                                                        ?>
                                                    </p>
                                                    <p>&nbsp;</p>
                                                    <p align="right">
                                                        <?php
                                                        if ($pval['recipient_type'] == "vendor") {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="#<?php echo $pval['id']; ?>"
                                                               data-toggle="modal" title="Comments" style="font-size: 12px;"><i class="fa fa-reply" aria-hidden="true" style="color: blue;" ></i>Reply
                                                            </a>
                                                        <div class="modal fade" id="<?php echo $pval['id']; ?>" role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close"
                                                                                data-dismiss="modal">&times;</button>
                                                                        <h4 class="modal-title">Comments</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="box box-primary">
                                                                            <div class="box-body box-profile">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <form id="add_comment_form"
                                                                                          action="<?php echo site_url('insert_vendor_payment_comment'); ?>"
                                                                                          method="post" enctype="multipart/form-data">
                                                                                        <div class="row">
                                                                                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top:20px;">
                                                                                                <div class="form-group" style="display: block !important;">
                                                                                                    <div class="col-sm-6 col-lg-4">
                                                                                                        <label for="email">To </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-lg-8">
                                                                                                        <div class="input-group">
                                                                                                            <label>
                                                                                                                <?php
                                                                                                                echo $get_admin_details[0]['name_prefix'] . " " . ucwords($get_admin_details[0]['first_name']." ".$get_admin_details[0]['last_name']);
                                                                                                                ?>
                                                                                                            </label>
                                                                                                            <input type="hidden" name="recipient_id" value="<?php echo $get_admin_details[0]['admin_id']; ?>">
                                                                                                            <input type="hidden" name="recipient_type" value="<?php echo "admin"; ?>">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group" style="display: block !important;">
                                                                                                    <div class="col-sm-6 col-lg-4">
                                                                                                        <label for="email">Comments <span style="color: red;">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-6 col-lg-8">
                                                                                                        <div class="input-group">
                                                                                                            <textarea name="message" id="message" class="form-control validate[required]" rows="5" cols="10" placeholder="Comments" style="resize: none;"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                                <input class="btn btn-success" type="submit" name="submit" value="Send">
                                                                                                 <input type="hidden" name="subject" value="<?php echo $pval['subject']; ?>">
                                                                                                <input type="hidden" name="sender_id" value="<?php echo $pval['recipient_id']; ?>">
                                                                                                <input type="hidden" name="sender_type" value="<?php echo "vendor"; ?>">
                                                                                                <input type="hidden" name="invoice_id" value="<?php echo $pval['invoice_id']; ?>">
                                                                                                <input type="hidden" name="reply_id" value="<?php echo $pval['id']; ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>

                                                                            </div>
                                                                            <!-- /.box-body -->
                                                                        </div>
                                                                        <!-- /.box -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    </p>
                                                </div>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ol>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                </div>

        </div>
    </div>
    <!-- /.row (main row) -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php
$this->load->view('vendor/includes/common_footer');
?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
?>
