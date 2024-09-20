<?php
$this->load->view('vendor/includes/header');
?>
<style>
    .lbl-css{
        margin-bottom: 0px !important;
    }
    .input-group{
        margin-bottom: 10px;
        width: 75%;
    }
    .panel-default > .panel-heading {
        color: #333;
        background-color: #fff;
        border-color: #ddd;
    }
    .panel-title{
        font-size: 14px !important;
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
                <li><a href="#"><i class="fa fa-dashboard"></i> Notifications</a></li>
                <!--<li class="active"><a href="">Add Consultant</a></li>-->
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-body">

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseMain">
                                                <span class="glyphicon glyphicon-time"></span>
                                                Consultants Timesheet
                                            </a> 
                                        </h3>
                                    </div>
                                    <div  id="collapseMain" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion1">

                                            <?php
                                            if (!empty($get_timesheet_details)) {
                                                $t_msg = "";
                                                $t = 1;
                                                foreach ($get_timesheet_details as $tval) {

                                                    $get_employee_details = $this->employee_model->getEmployeeData($tval['employee_id']);
                                                    $get_project_details = $this->employee_model->getProjectData($tval['project_id']);

                                                    $t_datetime1 = new DateTime(date("Y-m-d h:i:s"));
                                                    $t_datetime2 = new DateTime($tval['entry_date']);
                                                    $t_interval = $t_datetime1->diff($t_datetime2);

                                                    $t_msg = "[" . $get_employee_details[0]['employee_code'] . "] - " . ucwords($get_employee_details[0]['name_prefix']) . " " . ucwords($get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']) . " has added new timesheet for project [" . $get_project_details[0]['project_code'] . "] - " . ucwords($get_project_details[0]['project_name']);
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion1" href="#t_<?php echo $t; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $t_msg; ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("F jS Y", strtotime($tval['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo $t_interval->format('%h') . " hours " . $t_interval->format('%i') . " minutes"; ?></small></span>
                                                            </h4>
                                                        </div>
                                                        <div id="t_<?php echo $t; ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                                                    <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                                                        <tr>
                                                                            <th style="text-align: center; width: 50%;">Comment</th>
                                                                            <th style="text-align: center;">Day</th>
                                                                            <th style="text-align: center;">Date</th>
                                                                            <th style="text-align: center;">Start Time</th>
                                                                            <th style="text-align: center;">End Time</th>
                                                                            <th style="text-align: center;">Total Time (Hours)</th>
                                                                            <th style="text-align: center;">Over Time (Hours)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $n_start_time = date("g:i a", strtotime($tval['start_time']));
                                                                        $n_end_time = date("g:i a", strtotime($tval['end_time']));
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo stripcslashes($tval['comment']); ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo date("l", strtotime($tval['project_date'])); ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo date("m-d-Y", strtotime($tval['project_date'])); ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_start_time); ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_end_time); ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo $tval['tot_time']; ?></td>
                                                                            <td style="text-align: center; font-weight: bold;"><?php echo $tval['over_time']; ?></td>
                                                                        </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $t++;
                                                }
                                            } else {
                                                echo "No Notification(s) Found.";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion1">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#collapseMain1">
                                                <span class="glyphicon glyphicon-user"></span>
                                                Assigned Project Lists
                                            </a> 
                                        </h3>
                                    </div>
                                    <div  id="collapseMain1" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion2">

                                            <?php
                                            if (!empty($get_vendor_project_details)) {
                                                $p_msg = "";
                                                $p = 1;
                                                foreach ($get_vendor_project_details as $pval) {

                                                    $get_admin_details = $this->employee_model->getAdminDetails($pval['admin_id']);

                                                    $p_datetime1 = new DateTime(date("Y-m-d h:i:s"));
                                                    $p_datetime2 = new DateTime($pval['entry_date']);
                                                    $p_interval = $p_datetime1->diff($p_datetime2);

                                                    $p_msg = "Project " . ucwords($pval['project_code']) . " is assigned by " . ucwords($get_admin_details[0]['name_prefix']) . " " . ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']);
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion2" href="#p_<?php echo $p; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $p_msg; ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("F jS Y", strtotime($pval['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo $p_interval->format('%h') . " hours " . $p_interval->format('%i') . " minutes"; ?></small></span>
                                                            </h4>
                                                        </div>
                                                        <div id="p_<?php echo $p; ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                                                    <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                                                        <tr>
                                                                            <th>Project Code</th>
                                                                            <th>Project Type</th>
                                                                            <th>Project Name</th>
                                                                            <th>Client Name</th>
                                                                            <th>Start Date</th>
                                                                            <th>End Date</th>
                                                                            <th>Approx. Total Time(hrs)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><label><?php echo $pval['project_code']; ?></label></td>
                                                                            <td><?php echo $pval['project_type']; ?></td>
                                                                            <td><label><?php echo $pval['project_name']; ?></label></td>
                                                                            <td><?php echo $pval['client_name']; ?></td>
                                                                            <td><label><?php echo date("m-d-Y", strtotime($pval['start_date'])); ?></label></td>
                                                                            <td><label><?php echo date("m-d-Y", strtotime($pval['end_date'])); ?></label></td>
                                                                            <td><?php echo $pval['approx_total_time']; ?></td>
                                                                        </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $p++;
                                                }
                                            } else {
                                                echo "No Notification(s) Found.";
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion2">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion2" href="#collapseMain2">
                                                <span class="glyphicon glyphicon-file"></span>
                                                Approved Consultant for Projects
                                            </a> 
                                        </h3>
                                    </div>
                                    <div  id="collapseMain2" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion3">

                                            <?php
                                            if (!empty($get_approve_details)) {
                                                $i_msg = "";
                                                $i = 1;
                                                foreach ($get_approve_details as $ival) {
                                                    $get_employee_details = $this->employee_model->getEmployeeData($ival['employee_id']);
                                                    $get_project_details = $this->employee_model->getProjectData($ival['project_id']);

                                                    $i_datetime1 = new DateTime(date("Y-m-d h:i:s"));
                                                    $i_datetime2 = new DateTime($ival['entry_date']);
                                                    $i_interval = $i_datetime1->diff($i_datetime2);

                                                    $i_msg = "[" . strtoupper($get_employee_details[0]['employee_code']) . "] " . ucwords($get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']) . " is hired for requirement [" . strtoupper($get_project_details[0]['project_code']) . "]";
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion3" href="#i_<?php echo $i; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $i_msg; ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("F jS Y", strtotime($ival['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo $i_interval->format('%h') . " hours " . $i_interval->format('%i') . " minutes"; ?></small></span>
                                                            </h4>
                                                        </div>
                                                        <div id="i_<?php echo $i; ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                                                    <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                                                        <tr>
                                                                            <th>Project Code</th>
                                                                            <th>Project Name</th>
                                                                            <th>Project Details</th>
                                                                            <th>Consultant Name</th>
                                                                            <th>Consultant Code</th>
                                                                            <th>Consultant Designation</th>
                                                                            <th>Project Start Date</th>
                                                                            <th>Project End Date</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><?php echo $get_project_details[0]['project_code']; ?></td>
                                                                            <td><?php echo $get_project_details[0]['project_name']; ?></td>
                                                                            <td><?php echo $get_project_details[0]['project_details']; ?></td>
                                                                            <td><?php echo $get_employee_details[0]['first_name']."".$get_employee_details[0]['last_name']; ?></td>
                                                                            <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                                            <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                                            <td><?php echo date("m-d-Y", strtotime($get_project_details[0]['start_date'])); ?></td>
                                                                            <td><?php echo date("m-d-Y", strtotime($get_project_details[0]['end_date'])); ?></td>
                                                                        </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $i++;
                                                }
                                            } else {
                                                echo "No Notification(s) Found.";
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-group" id="accordion3">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion3" href="#collapseMain3">
                                                <span class="glyphicon glyphicon-file"></span>
                                                Invoice Comments
                                            </a> 
                                        </h3>
                                    </div>
                                    <div  id="collapseMain3" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion4">

                                            <?php
                                            if (!empty($get_invoice_notifications_details)) {
                                                $n_msg = "";
                                                $n = 1;
                                                foreach ($get_invoice_notifications_details as $nval) {
                                                    $get_invoice_details = $this->employee_model->checkInvoiceStatusVendor($nval['invoice_id']);
                                                    if ($nval['sender_type'] == 'admin') {
                                                        $from_details = $this->employee_model->getAdminDetails($nval['sender_id']);
                                                        $from_name = $from_details[0]['name_prefix'] . " " . ucwords($from_details[0]['first_name'] . " " . $from_details[0]['last_name']);
                                                        $na_msg = ucwords($from_name) . " is commented for invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
                                                    } else {

                                                        $from_details = $this->employee_model->getVendorDetails($nval['sender_id']);
                                                        $from_name = ucwords($from_details[0]['vendor_company_name']);
                                                        $nv_msg = ucwords($from_name) . " is commented for invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
                                                    }
                                                    if ($nval['recipient_type'] == 'admin') {
                                                        $to_details = $this->employee_model->getAdminDetails($nval['recipient_id']);
                                                        $to_name = $to_details[0]['name_prefix'] . " " . ucwords($to_details[0]['first_name'] . " " . $to_details[0]['last_name']);
                                                    } else {
                                                        $to_details = $this->employee_model->getVendorDetails($nval['recipient_id']);
                                                        $to_name = ucwords($to_details[0]['vendor_company_name']);
                                                    }
                                                    $n_datetime1 = new DateTime(date("Y-m-d h:i:s"));
                                                    $n_datetime2 = new DateTime($ival['entry_date']);
                                                    $n_interval = $n_datetime1->diff($i_datetime2);

                                                    $n_msg = ucwords($get_admin_details[0]['name_prefix']) . " " . ucwords($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']) . " is commented for invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion3" href="#n_<?php echo $n; ?>"><span class="glyphicon glyphicon-plus"></span> <?php
                                                                    if ($nval['sender_type'] == 'admin') {
                                                                        echo $na_msg;
                                                                    } else {
                                                                        echo $nv_msg;
                                                                    }
                                                                    ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("F jS Y", strtotime($nval['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo $n_interval->format('%h') . " hours " . $n_interval->format('%i') . " minutes"; ?></small></span>
                                                            </h4>
                                                        </div>
                                                        <div id="n_<?php echo $n; ?>" class="panel-collapse collapse">
                                                            <div class="panel-body">
                                                                <table class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                                                    <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                                                        <tr>
                                                                            <th>Invoice Code</th>
                                                                            <th>Recipient Name</th>
                                                                            <th>Sender Name</th>
                                                                            <th>Subject</th>
                                                                            <th>Comments</th>
                                                                            <th>Date</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td><a href="<?php echo base_url() . "vendor_invoice_pdf/" . base64_encode($nval['invoice_id']); ?>" target="_blank" style="text-decoration: underline;"><?php echo $get_invoice_details[0]['invoice_code'] ?></a></td>
                                                                            <td><?php echo $to_name; ?></td>
                                                                            <td><?php echo $from_name; ?></td>
                                                                            <td><?php echo stripslashes($nval['subject']); ?></td>
                                                                            <td><?php echo stripslashes($nval['message']); ?></td>
                                                                            <td><?php echo date("m-d-Y", strtotime($nval['entry_date'])); ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($nval['recipient_type'] == "vendor") {
                                                                                    ?>
                                                                                    <a class="tbl_icon"
                                                                                       href="#<?php echo $nval['id']; ?>"
                                                                                       data-toggle="modal" title="Comments"><i class="fa fa-reply" aria-hidden="true" style="color: blue;"></i>
                                                                                    </a>

                                                                                    <div class="modal fade" id="<?php echo $nval['id']; ?>" role="dialog">
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
                                                                                                                                            echo $from_name;
                                                                                                                                            ?>
                                                                                                                                        </label>
                                                                                                                                        <input type="hidden" name="recipient_id" value="<?php echo $nval['sender_id']; ?>">
                                                                                                                                        <input type="hidden" name="recipient_type" value="<?php echo "admin"; ?>">
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group" style="display: block !important;">
                                                                                                                                <div class="col-sm-6 col-lg-4">
                                                                                                                                    <label for="email">Subject </label>
                                                                                                                                </div>
                                                                                                                                <div class="col-sm-6 col-lg-8">
                                                                                                                                    <div class="input-group">
                                                                                                                                        <label>
                                                                                                                                            <?php
                                                                                                                                            $subject = "Comments for Invoice " . strtoupper($get_invoice_details[0]['invoice_code']);
                                                                                                                                            echo $subject;
                                                                                                                                            ?>
                                                                                                                                        </label>
                                                                                                                                        <input type="hidden" name="subject" value="<?php echo $subject; ?>">
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
                                                                                                                            <input type="hidden" name="sender_id" value="<?php echo $nval['recipient_id']; ?>">
                                                                                                                            <input type="hidden" name="sender_type" value="<?php echo "vendor"; ?>">
                                                                                                                            <input type="hidden" name="invoice_id" value="<?php echo $nval['invoice_id']; ?>">
                                                                                                                            <input type="hidden" name="reply_id" value="<?php echo $nval['id']; ?>">
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
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>

                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $n++;
                                                }
                                            } else {
                                                echo "No Notification(s) Found.";
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
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
