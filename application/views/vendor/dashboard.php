<?php
$this->load->view('vendor/includes/header');
?>

<style>
    .alert-danger-d {
        color: #fff;
        background-color: #ff2d2d;
        border-color: #ff2d2d;
    }

    .alert-d {
        padding: 14px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-weight: bold;
    }

    .label1 {
        border-radius: 0.25em;
        color: #fff;
        display: inline;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        padding: 0.2em 0.6em 0.3em;
        position: absolute;
        right: -13px;
        text-align: center;
        top: -10px;
        vertical-align: baseline;
        white-space: nowrap;
    }
    .badge-error {
        background-color: #b94a48;
    }
    .badge-error:hover {
        background-color: #953b39;
    }
</style>

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" style="height:54px" class="logo">
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
        <?php
        $form_status = array();
        $sa_form_status = array();
        $form_status_str = 1;
        $sa_form_status_str = 1;

        $get_files = $this->profile_model->getVendorFiles($get_details[0]['vendor_id']);
        //print_r($get_files);

        if (!empty($get_files)) {
            foreach ($get_files as $fkey => $fval) {

                $form_status[] = $fval['form_status'];
                $sa_form_status[] = $fval['sa_form_status'];
            }
        }

        if (!empty($form_status)) {
            if (in_array("0", $form_status)) {
                $form_status_str = 0;
            } else {
                $form_status_str = 1;
            }
        } else {
            $form_status_str = 0;
        }

        if (!empty($sa_form_status)) {
            if (in_array("0", $sa_form_status)) {
                $sa_form_status_str = 0;
            } else {
                $sa_form_status_str = 1;
            }
        } else {
            $sa_form_status_str = 0;
        }

        if ($get_details[0]['status'] == '0' || $get_details[0]['block_status'] == '0') {
            ?>
            <section class="content-header">
                <div class="alert-d alert-danger-d"> Your Account Not Activated Yet.</div>
            </section>
            <?php
        }

        if (!empty($get_files)) {

            if ($form_status_str == 0 && $sa_form_status_str == 0) {
                ?>
                <section class="content-header">
                    <div class="alert-d alert-danger-d">Your document is not approved yet ,Please wait until your document approved.</div>
                </section>
                <?php
            } elseif ($form_status_str == 1 && $sa_form_status_str == 0) {
                ?>
                <section class="content-header">
                    <div class="alert-d alert-danger-d">Your document is not approved yet ,Please wait until your document approved.</div>
                </section>
                <?php
            } elseif ($form_status_str == 0 && $sa_form_status_str == 1) {
                ?>
                <section class="content-header">
                    <div class="alert-d alert-danger-d">Your document is not approved yet ,Please wait until your document approved.</div>
                </section>
                <?php
            }
        }
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                User Profile
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Overview</a></li>
            </ol>
        </section>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Important Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p>Please click on <strong>DOCUMENTATION</strong> link to upload required documents.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Main content -->
        <section class="content">


            <div class="row">

                <div class="col-md-3">

                    <!-- Profile Image -->
                    <?php
                    $this->load->view('vendor/profile_section');
                    ?>
                    <!-- /.box -->

                </div>
                <!-- /.col -->


                <div class="col-md-9">

                    <div class="col-md-6">
                        <div class="box box-widget widget-user-2">
                            <?php
                            if (!empty($get_employees)) {
                                $tot_ua_count = 0;
                                foreach ($get_employees as $e_val) {
                                    $get_unapproved_timesheet_count = $this->profile_model->getUnapprovedTimesheetCount($e_val['employee_id']);
                                    if (!empty($get_unapproved_timesheet_count)) {
                                        $u_count = count($get_unapproved_timesheet_count);
                                    } else {
                                        $u_count = 0;
                                    }
                                    $tot_ua_count += $u_count;
                                }
                            } else {
                                $tot_ua_count = 0;
                            }
                            ?>
                            <div class="widget-user-header bg-blue">
                                <h3 style="margin:0px; padding:0px;"><i class="fa fa-calendar "></i>
                                    <span class="label1 label-info"><?php echo $tot_ua_count; ?></span> Daily Worksheet
                                </h3>
                            </div>

                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <?php
                                    if (!empty($get_employees)) {
                                        $tot_ua_count = "";
                                        foreach ($get_employees as $e_val) {
                                            $get_unapproved_timesheet_count = $this->profile_model->getUnapprovedTimesheetCount($e_val['employee_id']);
                                            if (!empty($get_unapproved_timesheet_count)) {
                                                $u_count = count($get_unapproved_timesheet_count);
                                            } else {
                                                $u_count = 0;
                                            }
                                            ?>
                                            <li><a href="<?php echo base_url('view_consultant_timesheet/' . base64_encode($e_val['employee_id'])); ?>"><strong><?php echo ucwords(strtolower($e_val['first_name'] . " " . $e_val['last_name'])) ?></strong> <span class="badge badge-error"><?php echo $u_count; ?></span></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                                <br/>
                                <a href="<?php echo site_url('vendor_consultant_timesheet'); ?>">
                                    <button type="button" class="btn btn-block btn-info btn-sm">View All</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-md-6">
                        <div class="box box-widget widget-user-2">
                            <div class="widget-user-header bg-blue">
                                <div class="widget-user-image">
                                    <h3 style="margin:0px; padding:0px;"><i class="fa fa-compass"></i> Open Requirements</h3>
                                </div>
                            </div>

                            <div class="box-footer ">
                                <ul class="nav nav-stacked">
                                    <?php
                                    if (!empty($get_project_details)) {
                                        $s = 1;
                                        foreach ($get_project_details as $p_val) {
                                            ?>
                                            <li>
                                                <a href="<?php echo base_url('view_consultant/' . base64_encode($p_val['id'])); ?>"
                                                   target="_blank"><?php echo $s . ". "; ?>
                                                    <strong><?php echo ucwords(strtolower($p_val['project_name'])) . " [" . ucwords(strtolower($p_val['project_type'])) . "]" ?></strong></a>
                                            </li>
                                            <?php
                                            $s++;
                                        }
                                    }
                                    ?>
                                </ul>
                                <br/>
                                <a href="<?php echo site_url('open_requirements'); ?>">
                                    <button type="button" class="btn btn-block btn-info btn-sm">View All</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <?php /*
                      <div class="col-md-4">
                      <div class="box box-widget widget-user-2">
                      <div class="widget-user-header bg-blue">
                      <div class="widget-user-image">
                      <h3 style="margin:0px; padding:0px;"><i class="fa fa-newspaper-o"></i><span
                      class="label1 label-info">1</span> New Notification</h3>
                      </div>
                      </div>

                      <div class="box-footer">
                      <p><strong>Vodafone, Idea Merger To Create New Market Leader, Displacing Airtel</strong>
                      </p>
                      <button type="button" class="btn btn-block btn-info btn-sm">View All</button>
                      </div>
                      </div>
                      </div>

                     */ ?>
                    <!-- /.col -->

                    <div style="clear:both;"></div>


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Invoice Summary</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-bordered table-striped" id="invoice_tbl" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">Invoice No.</th>
                                        <th style="text-align: center;">Employee Code</th>
                                        <th style="text-align: center;">Vendor Name</th>
                                        <th style="text-align: center;">Admin Name</th>
                                        <th style="text-align: center;">Payment Mode</th>
                                        <th style="text-align: center;">Standard Time</th>
                                        <th style="text-align: center;">Bill Rate</th>
                                        <th style="text-align: center;">Total Standard Pay</th>
                                        <th style="text-align: center;">Over Time</th>
                                        <th style="text-align: center;">Overtime Rate</th>
                                        <th style="text-align: center;">Total Overtime Pay</th>
                                        <th style="text-align: center;">Invoice Date</th>
                                        <th style="text-align: center;">Invoice Due date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($get_invoice_details)) {
                                        foreach ($get_invoice_details as $i_val) {

                                            $invoice_code = strtoupper($i_val['invoice_code']);
                                            $get_employee_details = $this->profile_model->getEmployeeData($i_val['employee_id']);
                                            if (!empty($get_employee_details)) {
                                                $employee_code = strtoupper($get_employee_details[0]['employee_code']);
                                            }
                                            $get_vendor_details = $this->profile_model->getVendorData($i_val['vendor_id']);
                                            if (!empty($get_vendor_details)) {
                                                $vendor_name = ucwords(strtolower($get_vendor_details[0]['name_prefix'] . " " . $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']));
                                                $get_admin_details = $this->profile_model->getAdminData($get_vendor_details[0]['admin_id']);
                                                if (!empty($get_admin_details)) {
                                                    $admin_name = ucwords(strtolower($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']));
                                                }
                                            }
                                            if ($i_val['payment_type'] == '1') {
                                                $payment_mode = "Net 45";
                                            } elseif ($i_val['payment_type'] == '2') {
                                                $payment_mode = "Net 45";
                                            } elseif ($i_val['payment_type'] == '3') {
                                                $payment_mode = "Net 45";
                                            }
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php echo $invoice_code; ?>
                                                </td>
                                                <td>
                                                    <?php echo $employee_code; ?>
                                                </td>
                                                <td>
                                                    <?php echo $vendor_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $admin_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo $payment_mode; ?>
                                                </td>
                                                <td><?php echo $i_val['tot_time'] . " hours"; ?></td>
                                                <td><?php echo "$" . $i_val['bill_rate']; ?></td>
                                                <td><?php echo "$" . $i_val['tot_time_pay']; ?></td>
                                                <td><?php echo $i_val['over_time'] . " hours"; ?></td>
                                                <td><?php echo "$" . $i_val['ot_rate']; ?></td>
                                                <td><?php echo "$" . $i_val['over_time_pay']; ?></td>
                                                <td><?php echo date("F jS, Y", strtotime($i_val['updated_date'])); ?></td>
                                                <td><?php echo date("F jS, Y", strtotime("+15 days", strtotime($i_val['updated_date']))); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="7">No record(s) found</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!--                        <div class="col-md-3 pull-right margintop">-->
                        <!--                            <button type="button" class="btn btn-block btn-info btn-sm">Load More</button>-->
                        <!--                        </div>-->

                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

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
