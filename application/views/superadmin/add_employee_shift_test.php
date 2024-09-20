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
    input[type='time'] {
        width: 121px !important;
    }
    #overlay {	
        position: fixed;
        top: 0;
        z-index: 100;
        width: 100%;
        height:100%;
        display: none;
        background: rgba(0,0,0,0.6);
    }
    .borderless td, .borderless th {
        border: none;
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
                <li class="active">Add Employee Shift</li>
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
                                Shift
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

                            <div class="alert alert-danger" style="display:none;" id="error_msg"> 
                                Please select an employee to see the data 
                            </div>

                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                    <label for="date" class="lbl-css">Select Employee<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <select name="employee" id="employee">
                                                        <option value="">Select Employee</option>
                                                        <?php foreach ($get_all_employees_shift as $empshift) { ?>
                                                            <option value="<?php echo $empshift['employee_id']; ?>" <?php if (isset($_GET['employee_id']) && $_GET['employee_id']== $empshift['employee_id']) { echo "selected"; }?>><?php echo $empshift['first_name']." ".$empshift['last_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    </td>

                                                    <td>
                                                    <label for="date" class="lbl-css">Select Date<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <input type="date" id="date" name="date" <?php if (isset($_GET['employee_id'])) { echo "value='".date('Y-m-d')."'"; }?> min="1900-06-01" max="2090-06-30">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <form id="add_employee_shift_form"
                                action="<?php echo site_url('superadmin_add_admin_employee_shift'); ?>"
                                method="post" enctype="multipart/form-data">
                                        
                                <div class="panel-body">
                                    <div class="row">
                                        <div style="margin-top:20px;display:none;" id="clock_break_shift_details"  class="col-xs-12 col-sm-12 col-md-12">                                
                                            <label> CLOCK IN/OUT: </label>   
                                            <hr> 
                                            <table class="table borderless" width="100%" id="clock_table" cellspacing="2" cellpadding="2">
                                                    
                                            </table>
                                        </div>
                                        <div style="margin-top:20px;display:none;" id="break_shift_details"  class="col-xs-12 col-sm-12 col-md-12">                                
                                            <label> BREAKS: </label>   
                                            <hr> 
                                            <table class="table borderless" id="break_table" width="100%" cellspacing="2" cellpadding="2">
                                                    
                                            </table>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="add_break">Add break</button>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <input type="hidden" name="employee_id" value="<?php echo base64_encode($get_employee_data[0]['employee_id']); ?>">
                                                    <input class="btn btn-success" type="submit" name="submit" value="Submit">
                                                    <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                </div>
            </div>
        </div>
            <!-- /.row (main row) -->
            <div class="modal" id="myModal">
                <div class="modal-dialog modal-lg" style="width: 98%;">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Add Break</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form id="break_form_shift">
                            <table class="table table-bordered table-striped break_add_table">
                                <tr>
                                    <th>Break Name</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Paid</th>
                                    <th>Comment<span style="color: red;">*</span></th>
                                    <th>Delete</th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="break_type[]" id="break_type" class="validate[required]">
                                            <option value="personal">Personal</option>
                                            <option value="meeting">Meeting</option>
                                            <option value="training">Training</option>
                                            <option value="lunch">Lunch</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="date" name="start_date[]" id="start_date" readonly class="validate[required]">
                                        <input type="time" step="1" name="start_time[]" id="start_time" class="validate[required]">
                                    </td>
                                    <td>
                                        <input type="date" name="end_date[]" id="end_date" readonly class="validate[required]">
                                        <input type="time" step="1" name="end_time[]" id="end_time" class="validate[required]">
                                    </td>
                                    <td>
                                        <select name="paid[]" id="paid" class="validate[required]">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="comment[]" id="comment" class="validate[required] comment">
                                    </td>
                                    <td><button class="btn btn-danger" id="delete_row_break">Delete</button></td>
                                </tr>
                            </table>
                    </div>
                    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-primary pull-left" id="add_new">+ Add new</button>
                    <button type="submit" class="btn btn-success" id="shift_break_form_save">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" value="Reset">Close</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <div id="overlay">
        <center>
            <img src="<?php echo base_url(); ?>assets/images/loader-transparent.gif" alt="" style="position: relative;top: 354px;left: 83px;"/>
        </center>
    </div>
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
       // binds form submission and fields to the validation engine
        $("#edit_employee_form").validationEngine({promptPosition: 'inline'});
        $("#break_form_shift").validationEngine({promptPosition: 'inline'});
        $("#add_employee_shift_form").validationEngine({promptPosition: 'inline'});

        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('employee_id')) {
            $('#overlay').show();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('superadmin_get_employee_clock_data'); ?>", 
                data: {date: $('#date').val(), employee_id : $("#employee").val()},
                dataType: "json",  
                cache:false,
                success: function(data){
                    $('#clock_table').html(data['clock_str']);
                    $('#break_table').html(data['break_str']);
                    if (data['show_add_break']) {
                        $('#add_break').show();
                    }
                    else {
                        $('#add_break').hide();
                    }
                    $('#clock_break_shift_details').show();
                    $('#break_shift_details').show();
                    $('#overlay').hide();
                }
            });
        }

        $(document).on('change', '#date', function() {
            if ($("#employee").val()) {

            $('#overlay').show();
            $.ajax({
                type: "POST",
                    url: "<?php echo site_url('superadmin_get_employee_clock_data'); ?>", 
                data: {date: $('#date').val(), employee_id : $("#employee").val()},
                dataType: "json",  
                cache:false,
                success: function(data){
                    $('#clock_table').html(data['clock_str']);
                    $('#break_table').html(data['break_str']);
                    if (data['show_add_break']) {
                        $('#add_break').show();
                    }
                    else {
                        $('#add_break').hide();
                    }
                    $('#clock_break_shift_details').show();
                    $('#break_shift_details').show();
                    $('#overlay').hide();
                }
            });
            
            }
            else {
                $('#error_msg').show();
                $('#error_msg').delay(3000).fadeOut();
            }
        });

        $(document).on('change', '#employee', function() {

            if ($("#employee").val()) {

            $('#overlay').show();
            $.ajax({
                type: "POST",
                    url: "<?php echo site_url('superadmin_get_employee_clock_data'); ?>", 
                data: {date: $('#date').val(), employee_id : $("#employee").val()},
                dataType: "json",  
                cache:false,
                success: function(data){
                    $('#clock_table').html(data['clock_str']);
                    $('#break_table').html(data['break_str']);
                    if (data['show_add_break']) {
                        $('#add_break').show();
                    }
                    else {
                        $('#add_break').hide();
                    }
                    $('#clock_break_shift_details').show();
                    $('#break_shift_details').show();
                    $('#overlay').hide();
                }
            });

            }
            else {
                $('#error_msg').show();
                $('#error_msg').delay(3000).fadeOut();
            }
        });

        $(document).on('click', '#add_new', function() {
            $(".break_add_table").append("<tr><td><select name='break_type[]' class='form-control validate[required]' id='break_type'><option value='personal'>Personal</option><option value='meeting'>Meeting</option><option value='training'>Training</option><option value='lunch'>Lunch</option></select></td><td><input type='date' name='start_date[]' id='start_date' value='"+$('#date').val()+"' readonly class='validate[required]'>&nbsp;<input type='time' step='1' name='start_time[]' id='start_time' min='"+$('.clock_in_time').val()+"' max='"+$('.clock_out_time').val()+"' class='validate[required]'></td><td><input type='date' name='end_date[]' id='end_date' value='"+$('#date').val()+"' readonly class='validate[required]'>&nbsp;<input type='time' step='1' name='end_time[]' id='end_time' min='"+$('.clock_in_time').val()+"' max='"+$('.clock_out_time').val()+"' class='validate[required]'></td><td><select name='paid[]' class='form-control validate[required]' id='paid'><option value='yes'>Yes</option><option value='no'>No</option></select></td><td><input type='text' name='comment[]' id='comment' class='validate[required] comment'><div class='commentformError parentFormbreak_form_shift formError inline' id='break_form_comment_alert' style='opacity: 0.87; position: relative; top: 0px; left: 0px; right: initial; margin-top: 0px; display:none;'><div class='formErrorContent'>* This field is required</div></div></td><td><button class='btn btn-danger' id='delete_row_break'>Delete</button></td></tr>");
        });

        $(document).on('click','#delete_row_break', function(){
            $(this).parent().parent().remove();
        });

        $(document).on('submit', '#break_form_shift', function(e) {
                // e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin_insert_shift_break_form_data'); ?>",
                    async:false,
                    data: $('form#break_form_shift').serialize(),
                    success: function(response){
                        $('#myModal').modal('toggle');
                    },
                    error: function(){
                        alert("Error");
                    }
                });
        });

        $(document).on('shown.bs.modal', '#myModal', function() {
            $('#start_date').val($('#date').val());
            $('#end_date').val($('#date').val());
            $('#start_time').attr('min', $('#clock_in_time').val());
            $('#start_time').attr('max', $('#clock_out_time').val());
            $('#end_time').attr('min', $('#clock_in_time').val());
            $('#end_time').attr('max', $('#clock_out_time').val());
        });

        $(document).on('hidden.bs.modal', '#myModal', function() {
            document.getElementById("break_form_shift").reset();
        });

        $(document).on('change', '.clock_in_time', function() {
            $(this).closest('tr').find("td:nth-child(8) > input").addClass("validate[required]");
        });

        $(document).on('change', '.clock_out_time', function() {
            $(this).closest('tr').find("td:nth-child(8) > input").addClass("validate[required]");
        });

        // $(document).on('change', '.break_end_time', function() {
        //     $('.clock_in_date').attr('max', $(this).val());
        //     $('.clock_out_date').attr('max', $(this).val());
        //     $('.break_start_time').attr('max', $(this).val());
        // });

        $(document).on('change', '.break_start_time', function() {
            var ss = $(this).val().split(":");
            var dt = new Date();
            dt.setHours(ss[0]);
            dt.setMinutes(ss[1]);
            dt.setSeconds(ss[2]);
            var dt2 = new Date(dt.valueOf() + 1000);
            var ts = dt2.toTimeString().split(" ")[0];
            $(this).closest('tr').find("td:nth-child(6) > input").attr('min', ts);
        });

        $(document).on('change', '.clock_in_time', function() {

            var ss = $('#clock_in_time').val().split(":");
            var dt = new Date();
            dt.setHours(ss[0]);
            dt.setMinutes(ss[1]);
            dt.setSeconds(ss[2]);
            var dt2 = new Date(dt.valueOf() + 1000);
            var ts = dt2.toTimeString().split(" ")[0];
            $(this).closest('tr').find("td:nth-child(6) > input").attr('min', ts);
            // var t = new Date($(this).val());
            // t.setSeconds(t.getSeconds() + 1);
            // var z = t.toJSON().slice(0,11) + t.toLocaleTimeString().slice(0,8);
            // console.log(z);
            // $(this).closest('tr').find("td:nth-child(4) > input").attr('min', z);
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>

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