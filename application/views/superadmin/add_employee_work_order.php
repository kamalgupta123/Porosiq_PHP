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
    .lbl-css {
        margin-bottom: 0px !important;
    }

    .input-group {
        margin-bottom: 10px;
        width: 75%;
    }
    .text-css{
        border:1px solid #F4F4F4;
        height:46px;
    }
    /*.text-css{
    border-top: 0px;
    border-right: 0px;
    border-left: 0px;
    border-bottom: 1px solid #000;
}*/
    label{
        font-weight: 600;
    }
</style>
<div class="wrapper">

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
            <!--                <h1>-->
            <!--                    User Profile-->
            <!--                </h1>-->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Work Order</a></li>
            </ol>
        </section>
        <br/>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                <?php
                                if (!empty($get_employee_details)) {
                                    $employee_code = $get_employee_details[0]['employee_code'];
                                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                                    $employee_name_prefix = $get_employee_details[0]['name_prefix'];
                                }
                                ?>
                                Work Order for <?php echo $employee_name_prefix . " " . ucwords($employee_name) . " [ " . strtoupper($employee_code) . " ] "; ?>
                            </h3>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 separator social-login-box" align="center"><br>

                            <img src="<?php echo base_url(); ?>assets/images/pts.jpg" alt="" style="width: 25%;">

                        </div>

                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                        <form id="work_order_form"
                              action="<?php echo site_url('insert_superadmin_employee_work_order'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">


                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <div class="form-group">
                                            <div class="col-sm-12 col-md-12 col-md-12">
                                                <table id="admin_tbl" class="table table-bordered"
                                                       style="font-size: 14px; text-align: left;">
                                                    <tbody>
                                                        <tr class="text1">
                                                            <td width="312">
                                                                <p>Consultant</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <input class="form-control validate[required,custom[onlyLetterSp]] text-css" type="text" id="consultant" name="consultant">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Vendor</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Start Date</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <input class="form-control validate[required] text-css date" type="text" id="start_date" name="start_date">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Duration of Project</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <textarea class="form-control validate[required] text-css" name="project_duration" id="project_duration"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Bill Rate</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <input class="form-control validate[required,custom[onlyNumberSp]] text-css" type="text" id="bill_rate" name="bill_rate">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>OT Rate</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <input class="form-control validate[required,custom[onlyNumberSp]] text-css" type="text" id="ot_rate" name="ot_rate">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Client Name</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <input class="form-control validate[required,custom[onlyLetterSp]] text-css" type="text" id="client_name" name="client_name">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Invoicing Terms</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <textarea class="form-control validate[required] text-css" name="invoicing_terms" id="invoicing_terms"></textarea>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Payment Terms</p>
                                                            </td>
                                                            <td width="312" style="padding:0;">
                                                                <textarea class="form-control validate[required] text-css" name="payment_terms" id="payment_terms"></textarea>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p>Note: UHG 5% Tenure discount after the first 6 months and then
                                                    another 5% for the following 6 months<strong>.</strong></p>

                                                <p style="text-align: center;">Accepted by:</p>

                                                <p>&nbsp;</p>
                                                <table id="admin_tbl" class="table table-bordered"
                                                       style="font-size: 12px; text-align: center;">
                                                    <tbody>
                                                        <tr>
                                                            <td width="312" colspan="2">&nbsp;</td>
                                                            <td width="312" colspan="2">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                if (!empty($get_admin_details) && $get_admin_details[0]['first_name'] != '') {
                                                                    echo $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="312">
                                                                <p>Name</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                if (!empty($get_admin_details) && $get_admin_details[0]['admin_designation'] != '') {
                                                                    echo $get_admin_details[0]['admin_designation'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="312">
                                                                <p>Designation</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td width="312">
                                                                <?php
                                                                if (!empty($get_admin_details) && $get_admin_details[0]['admin_company_name'] != '') {
                                                                    echo $get_admin_details[0]['admin_company_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="312">
                                                                <p>Company Name</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="312">
                                                                <p>Signature</p>
                                                            </td>
                                                            <td width="312">
                                                                <input class="form-control validate[required] text-css" style="font-family: 'Dancing Script', cursive; font-size: 1.7em;" type="text" id="admin_signature" name="admin_signature" value="<?php
                                                                if (!empty($get_admin_details) && $get_admin_details[0]['first_name'] != '') {
                                                                    echo strtolower($get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name']);
                                                                }
                                                                ?>">
                                                            </td>
                                                            <td width="312">
                                                                <p>Signature</p>
                                                            </td>
                                                            <td width="312">&nbsp;</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Add Work Order">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                        <input type="hidden" name="admin_id" value="<?php echo $get_admin_details[0]['admin_id']; ?>">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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

<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
        type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
        type="text/javascript" charset="utf-8">
</script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#work_order_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#start_date').datepicker(
                {
                    format: 'mm-dd-yyyy'
                }
        );
    });

</script>
<link href="https://fonts.googleapis.com/css?family=Dancing+Script" rel="stylesheet"> 