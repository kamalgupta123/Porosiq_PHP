<?php
$this->load->view('superadmin/includes/header');
?>
<style>
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
    <?php
    $current_date = date("m-d-Y");
    ?>
    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('superadmin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('superadmin/includes/user_panel');
            $this->load->view('superadmin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Notifications
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Notifications</a></li>
                <!--<li class="active">Consultant Lists</li>-->
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div
                    class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div
                    class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                <?php } ?>

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="box-body">

                            <div class="panel-group" id="accordion">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseMain" style="color: #09274b;">
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                Consultants Files
                                            </a> 
                                        </h3>
                                    </div>
                                    <div  id="collapseMain" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion1">

                                            <?php
                                            if (!empty($get_consultant_files_details)) {
                                                $t_msg = "";
                                                $t = 1;
                                                foreach ($get_consultant_files_details as $tval) {

                                                    $get_employee_details = $this->employee_model->getEmployeeData($tval['consultant_id']);
                                                    $get_form_details = $this->employee_model->getFormData($tval['form_no']);

//                                                    $t_datetime1 = new DateTime(date("m-d-Y h:i:s"));
//                                                    $t_datetime2 = new DateTime($tval['entry_date']);
//                                                    $t_interval = $t_datetime1->diff($t_datetime2);

                                                    $t_msg = "[" . $get_employee_details[0]['employee_code'] . "] - " . ucwords($get_employee_details[0]['name_prefix']) . " " . ucwords($get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']) . " added " . ucwords($get_form_details[0]['document_name']);
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion1" href="#t_<?php echo $t; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $t_msg; ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("jS F Y", strtotime($tval['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo date("h:i:s", strtotime($tval['entry_date'])) ?></small></span>
                                                            </h4>
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
							
							 <div class="panel-group" id="accordion">
                                <div class="panel panel-info">
									<div class="panel-heading">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion1" href="#collapseMain1" style="color: #09274b;">
                                                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                                Vendor Files
                                            </a> 
                                        </h3>
                                    </div>
									
									<div  id="collapseMain1" class="panel-collapse collapse">
                                        <div class="panel-group" id="accordion2">

                                            <?php
                                            if (!empty($get_vendor_files_details)) {
                                                $v_msg = "";
                                                $v = 1;
                                                foreach ($get_vendor_files_details as $vval) {

                                                    $get_vendor_details = $this->employee_model->getVendorData($vval['vendor_id']);
                                                    $get_vendorform_details = $this->employee_model->getVendorFormData($vval['form_no']);

//                                                    $t_datetime1 = new DateTime(date("m-d-Y h:i:s"));
//                                                    $t_datetime2 = new DateTime($tval['entry_date']);
//                                                    $t_interval = $t_datetime1->diff($t_datetime2);

                                                    $v_msg = ucwords($get_vendor_details[0]['name_prefix']) . " " . ucwords($get_vendor_details[0]['first_name']." ".$get_vendor_details[0]['last_name']) . " added " . ucwords($get_vendorform_details[0]['document_name']);
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion1" href="#v_<?php echo $v; ?>"><span class="glyphicon glyphicon-plus"></span> <?php echo $v_msg; ?></a>
                                                                <span style="float: right;"><small><i class="fa fa-calendar"></i> <?php echo date("jS F Y", strtotime($vval['entry_date'])); ?></small></span>
                                                                <span style="float: right;margin: 0 10px 0px 0px;"><small><i class="fa fa-clock-o"></i> <?php echo date("h:i:s", strtotime($vval['entry_date'])) ?></small></span>
                                                            </h4>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    $v++;
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
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('superadmin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('superadmin/includes/footer');
?>

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
    });
</script>