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
                Consultant <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Consultant</a></li>
                <li class="active">Edit Consultant</li>
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
                                Edit Consultant User
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
                            </h3>
                        </div>


                        <form id="edit_employee_form"
                              action="<?php echo site_url('update_employee'); ?>"
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
                                                        if ($get_employee_data[0]['file'] != '') {
                                                            ?>
                                                            <img src="<?php echo base_url(); ?>uploads/<?php echo $get_employee_data[0]['file']; ?>" class="user-image"
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
                                                        <label for="email">Vendor Name</label>
                                                    </td>
                                                    <td>
                                                        <select name="vendor_id" id="vendor_id" class="form-control validate[required]" disabled>
                                                            <option value="">Select Vendor</option>
                                                            <?php
                                                            if (count($get_vendor) > 0) {
                                                                foreach ($get_vendor as $vval) {
                                                                    ?>
                                                                    <option value="<?php echo $vval['vendor_id']; ?>" <?php if ($vval['vendor_id'] == $get_employee_data[0]['vendor_id']) { ?> selected <?php } ?>><?php echo $vval['name_prefix'] . " " . $vval['first_name'] . " " . $vval['last_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td width="25%">
                                                        <label for="email">Consultant Code</label>
                                                    </td>
                                                    <td width="25%">
                                                        <label>
                                                            <?php
                                                            if (isset($get_employee_data[0]['employee_code'])) {
                                                                echo $get_employee_data[0]['employee_code'];
                                                            }
                                                            ?>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php
                                                    if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                        if ($get_employee_data[0]['employee_email'] != '') {
                                                            ?>
                                                            <td><label for="email">Email ID<span style="color: red;">*</span></label></td>
                                                            <td>
                                                                <input class="form-control validate[required,custom[email]]" type="text"
                                                                       id="employee_email" name="employee_email" placeholder="Email ID"
                                                                       value="<?php echo $get_employee_data[0]['employee_email']; ?>">
                                                            </td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr." <?php if ($get_employee_data[0]['name_prefix'] == 'Mr.') { ?> checked <?php } ?>> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix" value="Mrs." <?php if ($get_employee_data[0]['name_prefix'] == 'Mrs.') { ?> checked <?php } ?>> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix" value="Ms." <?php if ($get_employee_data[0]['name_prefix'] == 'Ms.') { ?> checked <?php } ?>> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix" value="Dr." <?php if ($get_employee_data[0]['name_prefix'] == 'Dr.') { ?> checked <?php } ?>> Dr.
                                                    </td>
                                                </tr>
												<tr>
                                                    <td>
                                                        <label for="email">Password</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="password" id="new_password"
                                                               name="new_password" placeholder="New Password">
                                                    </td>
                                                    <td>
                                                        <label for="email">Confirm Password</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control"
                                                               type="password" id="conf_password" name="conf_password"
                                                               placeholder="Confirm New Password" onChange="checkPasswordMatch();">

                                                            <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Consultant First Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="first_name" name="first_name" placeholder="First Name"
                                                               value="<?php echo $get_employee_data[0]['first_name']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Consultant Last Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="last_name" name="last_name" placeholder="Last Name"
                                                               value="<?php echo $get_employee_data[0]['last_name']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Consultant Designation<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="employee_designation" name="employee_designation" placeholder="Consultant Designation" value="<?php echo $get_employee_data[0]['employee_designation']; ?>">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Consultant Classification<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>

                                                        <select name="employee_classification" id="employee_classification" class="form-control validate[required]">
                                                            <?php 

                                                                $key = $get_employee_data[0]['temp_classification'];
                                                                echo show_classifications($key, true); 
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">Consultant Category<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                         <select name="employee_category" id="employee_category" class="form-control validate[required]">
                                                            <?php 

                                                                $key = $get_employee_data[0]['temp_category'];
                                                                echo show_categories($key, true); 
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Upload Resume<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="" type="file" name="resume_file" id="resume_file">
                                                        <?php
                                                        if (!empty($get_employee_data[0]['resume_file']) && $get_employee_data[0]['resume_file'] != '') {
                                                            ?>
                                                            <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_employee_data[0]['resume_file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-download" aria-hidden="true"></i> Download Resume</a></span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Phone No. <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyNumberSp],minSize[10],maxSize[10]]" type="text"
                                                               id="phone_no" name="phone_no" placeholder="Phone No."
                                                               value="<?php echo ($get_employee_data[0]['phone_no'] != '0') ? $get_employee_data[0]['phone_no'] : ''; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Fax No.</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[custom[onlyNumberSp]]" type="text"
                                                               id="fax_no" name="fax_no" placeholder="Fax"
                                                               value="<?php echo ($get_employee_data[0]['fax_no'] != '0') ? $get_employee_data[0]['fax_no'] : ''; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Address <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="address" id="address" class="form-control validate[required]" rows="5" cols="10" placeholder="Address" style="resize: none;"><?php echo strip_tags(stripslashes($get_employee_data[0]['address'])); ?></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Bill Rate<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="employee_bill_rate" name="employee_bill_rate" placeholder="Consultant Bill Rate" value="<?php echo $get_employee_data[0]['employee_bill_rate']; ?>">
                                                    </td>
                                                    <td>
                                                        <label for="email">Pay Rate<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="employee_pay_rate" name="employee_pay_rate" placeholder="Consultant Pay Rate" value="<?php echo $get_employee_data[0]['employee_pay_rate']; ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Date of Joining<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <!--input class="form-control validate[required] date" type="text" name="date_of_joining"
                                                               id="date_of_joining" value="<?php //echo ($get_employee_data[0]['date_of_joining'] != '0000-00-00') ? date("m-d-Y", strtotime($get_employee_data[0]['date_of_joining'])) : ""; ?>"-->
                                                        <input type="date" autocomplete="off" name="date_of_joining" value="<?php echo $get_employee_data[0]['date_of_joining']; ?>">
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
                                        <input type="hidden" name="employee_id" value="<?php echo base64_encode($get_employee_data[0]['employee_id']); ?>">
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
        $("#edit_employee_form").validationEngine({promptPosition: 'inline'});
    });

    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    todayHighlight: true
                }
        );
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
<script type="text/javascript">
    $('#resume_file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#resume_file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#resume_file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>

<script>
 
function checkPasswordMatch() {
    var password = $("#new_password").val();
    var confirmPassword = $("#conf_password").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
}

$(document).ready(function () {
   $("#new_password, #conf_password").keyup(checkPasswordMatch);
});

</script>