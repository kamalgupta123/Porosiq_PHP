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
            <h1>
                Project
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Projects</a></li>
                <li class="active">Edit Project</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-th"></span>
                                Edit Project
                            </h3>
                        </div>

                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                        <form id="edit_projects_form" action="<?php echo site_url('update_superadmin_projects'); ?>" method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email" class="lbl-css">Consultant/Employee</label>
                                                    </td>
                                                    <td width="25%">
                                                        <?php
                                                        if ($get_project_dtls[0]['vendor_id'] != 0) {
                                                            ?>
                                                            <label>Consultant</label>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <label>Employee</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="25%">
                                                        <label for="email" class="lbl-css">Admin Name</label>
                                                    </td>
                                                    <td>
                                                        <label><?php echo $get_admin_dtls[0]['first_name'] . " " . $get_admin_dtls[0]['last_name']; ?></label>
                                                    </td>
                                                    <!--                                                    <?php
                                                    //if ($get_project_dtls[0]['vendor_id'] != 0) {
                                                    ?>
                                                                                                        <td width="25%">
                                                                                                                <label for="email" class="lbl-css">Vendor Name</label>
                                                                                                        </td>
                                                    <?php
                                                    // } else {
                                                    ?>
                                                                                                        <td width="25%">&nbsp;</td>
                                                    <?php
                                                    //}
                                                    ?>
                                                                                                        <td width="25%">
                                                    <?php
//                                                        if ($get_project_dtls[0]['vendor_id'] != 0) {
//                                                            $get_vendor_details = $this->employee_model->getVendorDtls($get_project_dtls[0]['vendor_id']);
//                                                            $vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                                                    ?>
                                                                                                                <label><?php //echo $vendor_name; ?></label>
                                                    <?php
//                                                        } else {
//                                                            $get_admin_details = $this->employee_model->getAdminDetails($get_project_dtls[0]['admin_id']);
//                                                            $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                    ?><label><?php //echo $admin_name;  ?></label>
                                                    <?php
                                                    //}
                                                    ?> </td>-->
                                                </tr>
                                                <tr>
                                                    <td width="25%">
                                                        <?php
                                                        if ($get_project_dtls[0]['vendor_id'] != 0) {
                                                            ?>
                                                            <label for="email" class="lbl-css">Select Vendor <span style="color: red;">*</span></label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="25%">
                                                        <?php
                                                        if ($get_project_dtls[0]['vendor_id'] != 0) {
                                                            $vendor_arr = explode(",", $get_project_dtls[0]['vendor_id']);
                                                            ?>
                                                            <!--                                                            <label for="email" class="lbl-css">Vendor Name</label>-->
                                                            <select name="vendor_id[]" class="form-control validate[required]" multiple="multiple">
                                                                <option value="">Select Vendor</option>
                                                                <?php
                                                                if (!empty($get_vendor_dtls)) {
                                                                    foreach ($get_vendor_dtls as $vval) {
                                                                        ?>
                                                                        <option value="<?php echo $vval['vendor_id']; ?>" <?php if (in_array($vval['vendor_id'], $vendor_arr)) { ?> selected="selected" <?php } ?>><?php echo $vval['vendor_company_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Select Project Type <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="project_type" class="form-control validate[required]">
                                                            <option value="">Select Project Type</option>
                                                            <?php
                                                            if (!empty($get_project_type)) {
                                                                foreach ($get_project_type as $ptval) {
                                                                    ?>
                                                                    <option value="<?php echo $ptval['project_type_name']; ?>" <?php if ($ptval['project_type_name'] == $get_project_dtls[0]['project_type']) { ?> selected="selected" <?php } ?>><?php echo $ptval['project_type_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Project Name <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="project_name" name="project_name" placeholder="Project Name" value="<?php echo $get_project_dtls[0]['project_name']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Project Details <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea style="resize: none;" class="form-control validate[required]" type="text" id="project_details" name="project_details" placeholder="Project Details"><?php echo stripslashes($get_project_dtls[0]['project_details']); ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Client Name <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="client_name" name="client_name" placeholder="Client Name" value="<?php echo $get_project_dtls[0]['client_name']; ?>">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Project Start Date <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required] date" type="text" id="start_date" name="start_date" placeholder="Start Date" value="<?php echo ($get_project_dtls[0]['start_date'] != '0000-00-00') ?  date("m/d/Y",strtotime($get_project_dtls[0]['start_date'])) : ""; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Project End Date <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required] date" type="text" id="end_date" name="end_date" placeholder="End Date" value="<?php echo ($get_project_dtls[0]['end_date'] != '0000-00-00') ?  date("m-d-Y",strtotime($get_project_dtls[0]['end_date'])) : ""; ?>">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Approx. Project Total Time </label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="approx_total_time" name="approx_total_time" placeholder="Approx. Project Total Time " value="<?php echo $get_project_dtls[0]['approx_total_time']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Monthly Payment </label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="monthly_payment" name="monthly_payment" placeholder="Monthly Payment" value="<?php echo ($get_project_dtls[0]['monthly_payment'] != '0') ? $get_project_dtls[0]['monthly_payment'] : ""; ?>">
                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Edit Projects">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                        <input type="hidden" name="project_id" value="<?php echo $get_project_dtls[0]['id']; ?>">
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
        $("#edit_projects_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#start_date').datepicker(
                {
                    format: 'yyyy-mm-dd',
//                    startDate: new Date(),
                    todayHighlight: true
                }
        );
        $('#end_date').datepicker(
                {
                    format: 'yyyy-mm-dd'
                }
        );
    });

</script>