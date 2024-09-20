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
                SSO
                <small>Settings</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage
                        SSO
                    </a></li>
                <li class="active">
                    Single Sign-On
                </li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error_msg'); ?>
            </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('succ_msg'); ?>
            </div>
            <?php } ?>
            <div class="alert alert-success succ-msg" style="display: none;"></div>
            <div class="alert alert-danger succ-err" style="display: none;"></div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">


                    </div>




                    <form id="upload_document" action="<?php echo site_url('sa_approve_disapprove_ucsic_docs'); ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Enable SSO Services </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <table class="table table-bordered table-striped" width="100%" border="1"
                                            cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Enable SSO
                                                        </label>
                                                    </td>
                                                    <td><input class="form-check-input" type="checkbox" value=""
                                                            id="defaultCheck1"></td>
                                                    <td width="25%">
                                                        <label for="email">Manage Your Login</label>
                                                    </td>
                                                    <td>
                                                        <select name="pay_rate_type"
                                                            style="padding: 3px; border-radius: 5px;"
                                                            class="form-select">
                                                            <option value="Hourly">Allow users to login with SSO
                                                            </option>
                                                            <option value="Yearly">Enforce SSO login only</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">Identity Provider Entity ID</label>
                                                    </td>
                                                    <td colspan="3" >
                                                        <input readonly
                                                            style="border: none;background-color: transparent"
                                                            id="staticEmail" value="www.okta.com" type="text"
                                                            name="first_name">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">SSO Unique ID</label>
                                                    </td>
                                                    <td width="25%">
                                                        <input readonly
                                                            style="border: none;background-color: transparent"
                                                            id="staticEmail" value="Email" type="text"
                                                            name="first_name">
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </form>
                    <form id="upload_document" action="<?php echo site_url('sa_approve_disapprove_ucsic_docs'); ?>"
                        method="post" enctype="multipart/form-data">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">SSO Configuration</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                            </div>
                            <!-- /.box-body -->
                        </div>
                    </form>



                </div>
            </div>
            <!-- /.row (main row) -->
            <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-success">Save</a>
            <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>

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
<link rel="stylesheet"
    href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
    type="text/css" />
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
    type="text/javascript" charset="utf-8">
    </script>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
    type="text/javascript" charset="utf-8">
    </script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#upload_document").validationEngine({ promptPosition: 'inline' });
    });


</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
        $('select').select2('destroy');
    });
</script>