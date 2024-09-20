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
                Employee <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Employee</a></li>
                <li class="active">Add Employee Master Shift Data</li>
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
                                Create Shift
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
                            </h3>
                        </div>

                        <div class="alert alert-danger" id="alert-msg" style="display:none;"> </div>
                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                        <form id="add_employee_shift_data_form"
                              action="<?php echo site_url('superadmin-add-emp-master-shift-data'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <label for="employee_shift_type">Employee Shift Type / Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="employee_shift_type" name="employee_shift_type" class="validate[required,custom[onlyLetterNumber]]">
                                                    </td>

                                                    <td>
                                                        <label for="days">Days</label>
                                                    </td>
                                                    <td>
                                                        <select class="select2" id="days" name="days[]" multiple="multiple">
                                                            <option value="MO">Monday</option>
                                                            <option value="TU">Tuesday</option>
                                                            <option value="WE">Wednesday</option>
                                                            <option value="TH">Thursday</option>
                                                            <option value="FR">Friday</option>
                                                            <option value="SA">Saturday</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="daily_shift_start_time">Daily Shift Start Time<span
                                                                style="color: red;">*</span></label> 
                                                    </td>
                                                    <td>
                                                            <input type="time" id="daily_shift_start_time" name="daily_shift_start_time" class="validate[required]">
                                                        <input type="hidden" id="employee_code" name="employee_code" value="<?php echo $get_employee_data[0]['employee_code']; ?>"> 
                                                    </td>
                                                    <td>
                                                        <label for="daily_shift_end_time">Daily Shift End Time<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="time" id="daily_shift_end_time" name="daily_shift_end_time" class="validate[required]">
                                                    </td>
                                                </tr>
                                                <tr>
                                                <tr>    
                                                    <td>
                                                        <label for="paid_break_hours" class="lbl-css">Paid Break Time<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="paid_break_hours" name="paid_break_hours" class="validate[required]" min="0">
                                                        <label for="paid_break_hours" class="lbl-css">(in min.)</label>
                                                    </td>
                                                    <td>
                                                        <label for="unpaid_break_hours" class="lbl-css">Unpaid break Time<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input type="number" id="unpaid_break_hours" name="unpaid_break_hours" class="validate[required]" min="0">
                                                        <label for="paid_break_hours" class="lbl-css">(in min.)</label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <label for="comment">Comment</label>
                                                    </td>
                                                    <td colspan="2">
                                                        <textarea name="comment" id="comment" cols="50" rows="3"></textarea>
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
                                        <input type="hidden" name="employee_id" value="<?php echo base64_encode($get_employee_data[0]['employee_id']); ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Add">
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
        $("#add_employee_shift_data_form").validationEngine({promptPosition: 'inline'});

        $("#add_employee_shift_data_form").submit(function(e){

            $('html, body').animate({scrollTop: '0px'}, 300);

            var daily_shift_start_time = $('#daily_shift_start_time').val();
            var daily_shift_end_time = $('#daily_shift_end_time').val();
            console.log(daily_shift_start_time);
            console.log("test");

            if (daily_shift_start_time && daily_shift_end_time) {

                var diff = ( new Date("1970-1-1 " + daily_shift_end_time) - new Date("1970-1-1 " + daily_shift_start_time) )/ 1000 / 60;

                if ($('#paid_break_hours').val() > diff) {
                    $('#alert-msg').show();
                    $('#alert-msg').html("Paid break cannot be more than difference between shift start time and end time");
                    setTimeout(function() {
                        $('#alert-msg').fadeOut('slow');
                    }, 10000);
                    e.preventDefault();
                }

                if ($('#unpaid_break_hours').val() > diff) {
                    $('#alert-msg').show();
                    $('#alert-msg').html("Unpaid break cannot be more than difference between shift start time and end time");
                    setTimeout(function() {
                        $('#alert-msg').fadeOut('slow');
                    }, 10000);
                    e.preventDefault();
                }


                if ($('#daily_shift_start_time').val() != '' && $('#daily_shift_end_time').val() != '' && $('#daily_shift_start_time').val() == $('#daily_shift_end_time').val()) {
                    $('#alert-msg').show();
                    $('#alert-msg').html("Daily shift start time can not be equal to daily shift end time");
                    setTimeout(function() {
                        $('#alert-msg').fadeOut('slow');
                    }, 10000);
                    e.preventDefault();
                }
            }
        });
    });
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'mm/dd/yyyy'
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
    $('.resume-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.resume-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.resume-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>
