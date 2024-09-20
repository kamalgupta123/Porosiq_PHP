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
                Employee <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Employee</a></li>
                <li class="active">Add Employee</li>
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
                                Add Employee
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

                        <form id="add_employee_form"
                              action="<?php echo site_url('insert_superadmin_employee_user'); ?>"
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
                                                        <label for="email">Select Admin<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td width="25%">
                                                        <select name="admin_id" id="admin_id"
                                                                class="form-control validate[required]">
                                                            <option value="">Select Admin</option>
                                                            <?php
                                                            if (count($get_admin) > 0) {
                                                                foreach ($get_admin as $vval) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $vval['admin_id']; ?>"><?php echo $vval['name_prefix'] . " " . $vval['first_name'] . " " . $vval['last_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="client_id">Select Client<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td width="25%">
                                                        <select name="client_id" id="client_id"
                                                                class="form-control validate[required]">
                                                            <option value="">Select Client</option>
                                                            <?php
                                                            if (count($get_client) > 0) {
                                                                foreach ($get_client as $cval) {
                                                                    ?>
                                                                    <option
                                                                        value="<?php echo $cval['id']; ?>"><?php echo $cval['client_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr." checked> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix" value="Mrs."> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix" value="Ms."> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix" value="Dr."> Dr.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Employee First Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="first_name" name="first_name" placeholder="First Name"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Employee Last Name<span
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
                                                        <label for="email" class="lbl-css">Employee Designation<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="employee_designation" name="employee_designation" placeholder="Employee Designation" value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Employee Classification<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td translate="no">
                                                        <select name="employee_classification" id="employee_classification" class="form-control validate[required]" translate="no">
                                                            <?php echo show_classifications(); ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">Employee Category<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="employee_category" id="employee_category" class="form-control validate[required]">
                                                            <?php echo show_categories(); ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Upload Resume<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="validate[required] resume-file" type="file" name="resume_file" id="resume_file">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Phone No. <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <?php if (US || INDIA) { ?>
                                                        <input class="form-control validate[required,custom[phone],minSize[10],maxSize[10]]" type="text" id="phone_no" name="phone_no" placeholder="Phone No." value="">
                                                    <?php } if (LATAM) { ?>
                                                        <input class="form-control validate[required,custom[phone],minSize[8]]" type="text" id="phone_no" name="phone_no" placeholder="Phone No." value="">
                                                    <?php } ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Fax No.</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[custom[onlyNumberSp]]" type="text"
                                                               id="fax_no" name="fax_no" placeholder="Fax"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Address <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="address" id="address" class="form-control validate[required]" rows="5" cols="10" placeholder="Address" style="resize: none;"></textarea>
                                                    </td>
                                                </tr>
                                                <?php if (US || LATAM) { ?>
                                                <tr>
                                                    <td>
                                                        <label for="email">Bill Rate<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="employee_bill_rate" name="employee_bill_rate" placeholder="Bill Rate" value="">
                                                    </td>
                                                    <td>
                                                        <label for="emp_bill_rate_type">Bill Rate Type<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="emp_bill_rate_type" id="emp_bill_rate_type" class="form-control validate[required]">
                                                            <option value="">---Select Type---</option>
                                                            <option value="hourly">Hourly</option>
                                                            <option value="yearly">Yearly</option>
                                                            <?php if (LATAM) { ?>
                                                            <option value="monthly">Monthly</option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td>
                                                        <label for="email">Pay Rate<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="employee_pay_rate" name="employee_pay_rate" placeholder="Pay Rate" value="">
                                                    </td>

                                                    <td>
                                                        <label for="emp_pay_rate_type">Pay Rate Type<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="emp_pay_rate_type" id="emp_pay_rate_type" class="form-control validate[required]">
                                                            <option value="">---Select Type---</option>
                                                            <option value="hourly">Hourly</option>
                                                            <option value="yearly">Yearly</option>
                                                            <?php if (LATAM) { ?>
                                                            <option value="monthly">Monthly</option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="employee_ot_rate">Over Time Rate</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" id="employee_ot_rate" name="employee_ot_rate" placeholder="Over Time Rate" value="">
                                                    </td>
                                                    <td>
                                                        <label for="date_of_joining" class="lbl-css">Date of Joining<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <?php if (US || INDIA) { ?>
                                                        <input class="form-control validate[required] date" type="text" name="date_of_joining" id="date_of_joining">
                                                    <?php } if (LATAM) { ?>
                                                        <input type="date" class="form-control validate[required]" name="date_of_joining" autocomplete="off">
                                                    <?php }  ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="pay_staff_file">Upload Pay Staff </label>
                                                    </td>
                                                    <td>
                                                        <input class="" type="file" name="pay_staff_file" id="pay_staff_file">
                                                    </td>
                                                    <td>
                                                        <label for="w2_file">Upload W2 </label>
                                                    </td>
                                                    <td>
                                                        <input class="" type="file" id="w2_file" name="w2_file">
                                                    </td>
                                                </tr>
                                                <?php if (LATAM) { ?>
                                                    <tr>
                                                    <td>
                                                        <label for="is_temp_emp" class="lbl-css">Add as Temporary Employee</label>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="is_temp_emp" id="is_temp_emp" value="1">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="hidden" name="sa_id" value="<?php echo $sa_id; ?>">
                                        <input type="hidden" name="employee_type" value="E">
                                        <input class="btn btn-success" type="submit" name="submit" value="Add Employee User">
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
        $("#add_employee_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    startDate: new Date(),
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

    $('.resume-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.resume-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#resume-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#pay_staff_file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#pay_staff_file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#pay_staff_file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#w2_file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#w2_file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#w2_file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>