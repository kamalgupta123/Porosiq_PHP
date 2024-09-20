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
                Consultant
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Consultant</a></li>
                <li class="active">Add Consultant Documents</li>
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
                                <span class="glyphicon glyphicon-file"></span>
                                Add Consultant Documents
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

                        <form id="add_documentation_form"
                              action="<?php echo site_url('update_consultant_internal_files'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1"
                                               cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email" class="lbl-css">Consultant/Employees</label>
                                                    </td>
                                                    <td width="25%">
                                                        <?php
                                                        if (!empty($get_employee)) {
                                                            foreach ($get_employee as $eval) {
                                                                if ($eval['employee_id'] == $get_internal_file_details[0]['employee_id']) {
                                                                    echo $eval['first_name'] . " " . $eval['last_name'];
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td width="25%">&nbsp;</td>
                                                    <td width="25%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email" class="lbl-css">Document Name <span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="form-control validate[required]" type="text"
                                                               id="docs_name" name="docs_name"
                                                               placeholder="Document Name" value="<?php echo $get_internal_file_details[0]['docs_name']; ?>">
                                                    </td>
                                                    <td width="25%">
                                                        <label for="photo" class="lbl-css">Upload Document </label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="image-file" type="file" name="file">
                                                        <?php
                                                        if ($get_internal_file_details[0]['file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $get_internal_file_details[0]['file']; ?>"
                                                               class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View Document</a>
                                                               <?php
                                                           }
                                                           ?>
                                                        <br/>
                                                        <span style="color: red;">(PDF Files Only)</span>
                                                        <br/>
                                                        <span style="color: red;">(Max File Size : 2MB)</span>
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
                                        <input class="btn btn-success" type="submit" name="submit" value="Update Document">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                        <input type="hidden" name="doc_id" id="doc_id" value="<?php echo base64_encode($get_internal_file_details[0]['id']); ?>">
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
        $("#add_documentation_form").validationEngine({promptPosition: 'inline'});
    });

</script>
<script type="text/javascript">
    $('.image-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.image-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>