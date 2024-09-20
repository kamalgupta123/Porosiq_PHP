<?php
$this->load->view('admin/includes/header');
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

    .cal-css {
        display: none;
    }
    .pen-css {
        display: none;
    }
    .pu-css {
        display: none;
    }
    .nmsdc-css {
        display: none;
    }
    .wbenc-css {
        display: none;
    }
    .sba-css {
        display: none;
    }
    .vetbiz-css {
        display: none;
    }
    .nglcc-css {
        display: none;
    }
    label{
        font-weight: 600;
    }
</style>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin_dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('admin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('admin/includes/user_panel');
            $this->load->view('admin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vendor
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Vendor User</a></li>
                <li class="active">Add Vendor User(Short Details)</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                Add Vendor User
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
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

                        <form id="add_admin_form"
                              action="<?php echo site_url('insert_admin_vendor_sd'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1"
                                               cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">Company Logo <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="image-file validate[required]" type="file"
                                                               name="photo">
                                                        <span style="color: red;">(Max File Size : 2MB)</span>
                                                    </td>
                                                    <td width="25%">&nbsp;</td>
                                                    <td width="25%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr."
                                                               checked> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix"
                                                               value="Mrs."> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix"
                                                               value="Ms."> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix"
                                                               value="Dr."> Dr.
                                                    </td>
                                                    <?php if (LATAM) { ?>
                                                    <td>
                                                        <label for="vendor_tier">Vendor Tier<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select id="vendor_tier" name="vendor_tier">
                                                            <?php

                                                                echo show_vendor_tier(3, true);
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <?php } else { ?>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">POC First Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="first_name" name="first_name" placeholder="First Name"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">POC Last Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="last_name" name="last_name" placeholder="Last Name"
                                                               value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Designation <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="vendor_designation"
                                                               name="vendor_designation" placeholder="Designation" value="">
                                                    </td>
                                                    <td>
                                                        <label for="email">Company <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text"
                                                               id="vendor_company_name" name="vendor_company_name"
                                                               placeholder="Company" value="">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <label for="email">Email ID<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[email]]"
                                                               type="text" id="vendor_email" name="vendor_email"
                                                               placeholder="Email ID" value="">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Password<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="password"
                                                               id="password" name="password" placeholder="New Password">
                                                    </td>
                                                    <td>
                                                        <label for="email">Confirm Password<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,equals[password]]"
                                                               type="password" id="conf_password" name="conf_password"
                                                               placeholder="Confirm New Password">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Contract From Date <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control date validate[required]" type="text"
                                                               name="contract_from_date" id="contract_from_date">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
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
                                        <input class="btn btn-success" type="submit" name="submit"
                                               value="Add Vendor User">
                                        <input type="hidden" name="admin_id" value="<?php echo $get_details[0]['admin_id']; ?>">
                                        <input type="hidden" name="sa_id" value="<?php echo $get_super_admin[0]['sa_id']; ?>">
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
    $this->load->view('admin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('admin/includes/footer');
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
        $("#add_admin_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#contract_from_date').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    startDate: new Date(),
                    todayHighlight: true
                }
        );
    });
</script>
<script type="text/javascript">
    $('.image-file').on('change', function () {
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        }
//       alert(file_size);
    });
</script>
