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
                Employee
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Employee</a></li>
                <li class="active">Generate Login Details</li>
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

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Generate Login Details</h3>
                        </div>
                        <div class="box-body">

                            <div class="col-lg-6 col-sm-6 col-md-6">
                                <?php
                                if (!empty($get_employee_details)) {
//                                    print_r($get_employee_details);
                                }
                                ?>
                                <table class="table" style="font-size: 11px;">
                                    <tr>
                                        <td colspan="2">
                                            <div style="text-align: center;">
                                                <?php
                                                if ($get_employee_details[0]['file'] != '') {
                                                    ?>
                                                    <img src="<?php echo base_url(); ?>uploads/<?php echo $get_employee_details[0]['file']; ?>" class="user-image"
                                                         alt="User Image" width="200" height="200">
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img alt="User Image" class="user-image" src="<?php echo base_url(); ?>assets/images/blank-profile.png" width="200" height="200">
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Employee Code</label></td>
                                        <td>
                                            <?php
                                            echo $get_employee_details[0]['employee_code'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Employee Full Name</label></td>
                                        <td>
                                            <?php
                                            echo $get_employee_details[0]['name_prefix'] . " " . ucwords($get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Employee Designation</label></td>
                                        <td>
                                            <?php
                                            echo $get_employee_details[0]['employee_designation'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Employee Category</label></td>
                                        <td>
                                            <?php
                                            if ($get_employee_details[0]['employee_category'] == '1') {
                                                echo "W2";
                                            } elseif ($get_employee_details[0]['employee_category'] == '2') {
                                                echo "Subcontractor";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Address</label></td>
                                        <td>
                                            <?php
                                            echo stripslashes($get_employee_details[0]['address']);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Phone No.</label></td>
                                        <td>
                                            <?php
                                            echo $get_employee_details[0]['phone_no'];
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Fax No.</label></td>
                                        <td>
                                            <?php
                                            if ($get_employee_details[0]['fax_no'] != '0') {
                                                echo $get_employee_details[0]['fax_no'];
                                            } else {
                                                echo "";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Date of Joining</label></td>
                                        <td>
                                            <?php
                                            echo date("m-d-Y", strtotime($get_employee_details[0]['date_of_joining']));
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Resume</label></td>
                                        <td>
                                            <?php
                                            if (!empty($get_employee_details[0]['resume_file']) && $get_employee_details[0]['resume_file'] != '') {
                                                ?>
                                                <span><a href="<?php echo base_url(); ?>uploads/<?php echo $get_employee_details[0]['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i></a></span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Bill Rate</label></td>
                                        <td>
                                            <?php echo $get_employee_details[0]['employee_bill_rate']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><label>Pay Rate</label></td>
                                        <td>
                                            <?php echo $get_employee_details[0]['employee_bill_rate']; ?>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <div class="col-lg-6 col-sm-6 col-md-6" style="border-top: 1px #f4f4f4 solid;">
                                <form id="generate_form"
                                      action="<?php echo site_url('insert_superadmin_employee_login_details'); ?>"
                                      method="post" enctype="multipart/form-data">
                                    <div class="panel-body" style="margin-top: 200px;">

                                        <table class="table" style="font-size: 11px;">
                                            <tr>
                                                <td><label>Employee Email ID <span style="color: red;">*</span></label></td>
                                                <?php if (US || INDIA) { ?>
                                                <td>
                                                    <input class="form-control validate[required,custom[email]]" type="text" id="consultant_email" name="consultant_email">
                                                </td>
                                                <?php } ?>
                                                <?php if (LATAM) { ?>
                                                    <td><?php // echo "<pre>" . print_r($get_employee_details, 1) . "</pre>"; ?>
                                                    <input class="form-control validate[required,custom[email]]" type="text" id="consultant_email" name="consultant_email"
                                                    value="<?php echo isset($get_employee_details[0]['employee_email']) ? $get_employee_details[0]['employee_email'] : ''; ?>">
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <tr>
                                                <td><label>New Password <span style="color: red;">*</span></label></td>
                                                <td>
                                                    <input class="form-control validate[required]" type="text" id="consultant_password" name="consultant_password" value="Test@123" rel="gp" data-size="8" data-character-set="a-z,A-Z,0-9,#" style="width: 98%;">
                                                    <span class="input-group-btn" style="float: right;margin: -35px 0px 0px 0px;"><button type="button" class="btn btn-default btn-sm getNewPass" style="outline: none !important;height: 35px;"><span class="fa fa-refresh"></span></button></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                                    <input type="hidden" name="admin_id" value="<?php echo $get_employee_details[0]['admin_id']; ?>">
                                                    <input class="btn btn-success" type="submit" name="submit" value="Generate">
                                                    <input type="button" value="Back" class="btn btn-default" onclick="window.history.back();">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </form>
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
        $("#generate_form").validationEngine({promptPosition: 'inline'});
    });

    // Generate a password string
    function randString(id) {
        var dataSet = $(id).attr('data-character-set').split(',');
        var possible = '';
        if ($.inArray('a-z', dataSet) >= 0) {
            possible += 'abcdefghijklmnopqrstuvwxyz';
        }
        if ($.inArray('A-Z', dataSet) >= 0) {
            possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        if ($.inArray('0-9', dataSet) >= 0) {
            possible += '0123456789';
        }
        if ($.inArray('#', dataSet) >= 0) {
            possible += '![]{}()%&*$#^<>~@|';
        }
        var text = '';
        for (var i = 0; i < $(id).attr('data-size'); i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return text;
    }

    // Create a new password on page load
    $('input[rel="gp"]').each(function () {
        $(this).val(randString($(this)));
    });

    // Create a new password
    $(".getNewPass").click(function () {
        var field = $('input[rel="gp"]');
        field.val(randString(field));
    });

</script>