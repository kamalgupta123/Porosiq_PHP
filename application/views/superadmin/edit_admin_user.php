<?php
$this->load->view('superadmin/includes/header');
//echo "<pre>";
//print_r($get_admin_data);
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
            <!-- Sidebar user panel -->
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
                Admin User <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Admin User</a></li>
                <li class="active">Edit Admin User</li>
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
                                Edit Admin User
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

                        <form id="edit_admin_form"
                              action="<?php echo site_url('update-admin'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">
                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">Image</label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="" type="file" name="file" id="image-file">
                                                        <span style="color: red;">(Max File Size : 2MB)</span>
                                                    </td>
                                                    <td width="25%">
                                                        <?php
                                                        if ($get_admin_data[0]['file'] != '') {
                                                            $file_path = "uploads/admin/profile_pic/" . strtolower($get_admin_data[0]['first_name']) . "_" . strtolower($get_admin_data[0]['last_name'])."/";
                                                            ?>
                                                            <img src="<?php echo site_url() . $file_path . $get_admin_data[0]['file']; ?>" class="user-image"
                                                                 alt="User Image" width="100" height="100">
                                                                 <?php
                                                             } else {
                                                                 ?>
                                                            <img alt="User Image" class="user-image" src="<?php echo base_url(); ?>assets/images/blank-profile.png" width="100" height="100">
                                                            <?php
                                                        }
                                                        ?>

                                                    </td>
                                                    <td width="25%">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr." <?php if ($get_admin_data[0]['name_prefix'] == 'Mr.') { ?> checked <?php } ?>> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix" value="Mrs." <?php if ($get_admin_data[0]['name_prefix'] == 'Mrs.') { ?> checked <?php } ?>> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix" value="Ms." <?php if ($get_admin_data[0]['name_prefix'] == 'Ms.') { ?> checked <?php } ?>> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix" value="Dr." <?php if ($get_admin_data[0]['name_prefix'] == 'Dr.') { ?> checked <?php } ?>> Dr.
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">First Name<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="fname" name="fname" placeholder="First Name" value="<?php echo $get_admin_data[0]['first_name']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email">Last Name<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="lname" name="lname" placeholder="Last Name" value="<?php echo $get_admin_data[0]['last_name']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Designation<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="admin_designation" name="admin_designation" placeholder="Designation" value="<?php echo $get_admin_data[0]['admin_designation']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email">Company Name<span style="color: red;">*</span></label> 
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="admin_company_name" name="admin_company_name" placeholder="Company" value="<?php echo $get_admin_data[0]['admin_company_name']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Employee ID</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="admin_employee_id" name="admin_employee_id" placeholder="Employee ID" value="<?php echo $get_admin_data[0]['admin_employee_id']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email">Email ID<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="email" name="email" placeholder="Email ID" value="<?php echo $get_admin_data[0]['admin_email']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Phone No. <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[phone],minSize[10],maxSize[10]]" type="text" id="phone" name="phone" placeholder="Phone No." value="<?php echo ($get_admin_data[0]['phone_no'] != '0') ? $get_admin_data[0]['phone_no'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email">Fax No.</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[custom[onlyNumberSp]]" type="text" id="fax" name="fax" placeholder="Fax" value="<?php echo ($get_admin_data[0]['fax_no'] != '0') ? $get_admin_data[0]['fax_no'] : ''; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Address<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="address" id="address" class="form-control validate[required]" rows="5" cols="10" placeholder="Address" style="resize: none;"><?php echo stripslashes($get_admin_data[0]['address']); ?></textarea>
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
                                        <input type="hidden" name="admin_id" value="<?php echo base64_encode($get_admin_data[0]['admin_id']); ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Update">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
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
        $("#edit_admin_form").validationEngine({promptPosition: 'inline'});
    });

</script>
<script type="text/javascript">
    $('#image-file').on('change', function () {
        var file_extension = ['jpeg', 'jpg', 'png'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file').val("");
            alert("Only '.jpeg','.jpg', '.png' formats are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>