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
                                Shift Details
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

                            <div
                                class="alert alert-danger" id="error_msg_1" style="display: none;"> From date cannot be empty, please select from date </div>

                            <div
                            class="alert alert-danger" id="error_msg_2" style="display: none;"> To date cannot be empty, please select to date </div>

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
                                                            <option value="<?php echo $empshift['employee_id']; ?>"><?php echo $empshift['first_name']." ".$empshift['last_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    </td>

                                                    <td>
                                                    <label for="date" class="lbl-css">From<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <input type="date" id="date" name="date" min="1900-06-01" max="2090-06-30">
                                                    </td>

                                                    <td>
                                                    <label for="date" class="lbl-css">To<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <input type="date" id="date2" name="date2" min="1900-06-01" max="2090-06-30">
                                                    </td>

                                                    <td><button class="btn btn-primary" id="search">Search</button></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered table-striped" style="display:none;" id="detail_table">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>Total Hours</th>
                                                <th>Total Break</th>
                                                <th>Total unpaid break</th>
                                                <th>Total paid break</th>
                                                <th>View Details</th>
                                            </tr>
                                        </thead>
                                        <tbody id="detail_table_body">
                                            <!-- <tr>
                                                <td id="employee_name"></td>
                                                <td id="total_hours"></td>
                                                <td id="total_break"></td>
                                                <td id="total_unpaid_break"></td>
                                                <td id="total_paid_break"></td>
                                                <td id="view_details">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php //echo base_url("view-employee-shifthours-detail"); ?>"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                            </tr> -->
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
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

        $(document).on('click', '#search', function() {
            if (!$('#date').val()) {
                $('#error_msg_1').show();
                $('#error_msg_1').delay(3000).fadeOut();
            }
            else if (!$('#date2').val()) {
                $('#error_msg_2').show();
                $('#error_msg_2').delay(3000).fadeOut();
            }
            else {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin_get_all_employee_shift_details'); ?>", 
                    data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        var employee_id = $("#employee").val();
                        
                        if (employee_id) {

                            console.log(data);

                            var table = $('#detail_table').DataTable();

                            table.clear().draw();

                            var employee_name = '';
                            var total_break = 0;
                            var total_hours = 0;
                            var total_paid_break = 0;
                            var total_unpaid_break = 0;
                            var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo base_url('superadmin-view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

                            if (data['employee_name']) {
                                employee_name = data['employee_name'];
                                console.log(employee_name);
                            }
                            if (data['total_hours']) {
                                total_hours = data['total_hours'];
                                console.log(total_hours);
                            }
                            if (data['total_break']) {
                                total_break = data['total_break'];
                                console.log(total_break);
                            }
                            if (data['total_unpaid_break']) {
                                total_unpaid_break = data['total_unpaid_break'];
                                console.log(total_unpaid_break);
                            }
                            if (data['total_paid_break']) {
                                total_paid_break = data['total_paid_break'];
                                console.log(total_paid_break);
                            }
                            
                            table.row.add( [
                                    employee_name,
                                    total_hours,
                                    total_break,
                                    total_unpaid_break,
                                    total_paid_break,
                                    view_details
                                ] ).draw( false );

                            $('#detail_table').show();
                        }
                        else {
                            
                            var table = $('#detail_table').DataTable();

                            table.clear().draw();

                            $.each(data, function(key, val) {

                                var employee_name = '';
                                var total_break = 0;
                                var total_hours = 0;
                                var total_paid_break = 0;
                                var total_unpaid_break = 0;
                                var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo base_url('superadmin-view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

                                if (val.employee_name) {
                                    employee_name = val.employee_name;
                                }
                                if (val.total_break) {
                                    total_break = val.total_break;
                                }
                                if (val.total_hours) {
                                    total_hours = val.total_hours;
                                }
                                if (val.total_paid_break) {
                                    total_paid_break = val.total_paid_break;
                                }
                                if (val.total_unpaid_break) {
                                    total_unpaid_break = val.total_unpaid_break;
                                }

                                table.row.add( [
                                    employee_name,
                                    total_hours,
                                    total_break,
                                    total_unpaid_break,
                                    total_paid_break,
                                    view_details
                                ] ).draw( false );

                            });

                            $('#detail_table').show();
                        }
                    }
                });
            }
        });


        // $(document).on('change', '#date', function() {
        //     $('#date2').attr('min', $(this).val());
        //     $.ajax({
        //         type: "POST",
        //         url: "<?php //echo site_url('get_all_employee_shift_details'); ?>", 
        //         data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
        //         dataType: "json",  
        //         cache:false,
        //         success: function(data){
        //             var employee_id = $("#employee").val();
                    
        //             if (employee_id) {

        //                 console.log(data);

        //                 var table = $('#detail_table').DataTable();

        //                 table.clear().draw();

        //                 var employee_name = '';
        //                 var total_break = 0;
        //                 var total_hours = 0;
        //                 var total_paid_break = 0;
        //                 var total_unpaid_break = 0;
        //                 var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php //echo base_url('view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

        //                 if (data['employee_name']) {
        //                     employee_name = data['employee_name'];
        //                     console.log(employee_name);
        //                 }
        //                 if (data['total_hours']) {
        //                     total_hours = data['total_hours'];
        //                     console.log(total_hours);
        //                 }
        //                 if (data['total_break']) {
        //                     total_break = data['total_break'];
        //                     console.log(total_break);
        //                 }
        //                 if (data['total_unpaid_break']) {
        //                     total_unpaid_break = data['total_unpaid_break'];
        //                     console.log(total_unpaid_break);
        //                 }
        //                 if (data['total_paid_break']) {
        //                     total_paid_break = data['total_paid_break'];
        //                     console.log(total_paid_break);
        //                 }
                        
        //                 table.row.add( [
        //                         employee_name,
        //                         total_hours,
        //                         total_break,
        //                         total_unpaid_break,
        //                         total_paid_break,
        //                         view_details
        //                     ] ).draw( false );

        //                 $('#detail_table').show();
        //             }
        //             else {
                        
        //                 var table = $('#detail_table').DataTable();

        //                 table.clear().draw();

        //                 $.each(data, function(key, val) {

        //                     var employee_name = '';
        //                     var total_break = 0;
        //                     var total_hours = 0;
        //                     var total_paid_break = 0;
        //                     var total_unpaid_break = 0;
        //                     var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php //echo base_url('view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

        //                     if (val.employee_name) {
        //                         employee_name = val.employee_name;
        //                     }
        //                     if (val.total_break) {
        //                         total_break = val.total_break;
        //                     }
        //                     if (val.total_hours) {
        //                         total_hours = val.total_hours;
        //                     }
        //                     if (val.total_paid_break) {
        //                         total_paid_break = val.total_paid_break;
        //                     }
        //                     if (val.total_unpaid_break) {
        //                         total_unpaid_break = val.total_unpaid_break;
        //                     }

        //                     table.row.add( [
        //                         employee_name,
        //                         total_hours,
        //                         total_break,
        //                         total_unpaid_break,
        //                         total_paid_break,
        //                         view_details
        //                     ] ).draw( false );

        //                 });

        //                 $('#detail_table').show();
        //             }
        //         }
        //     });
        // });



        // $(document).on('change', '#date2', function() {
        //     $.ajax({
        //         type: "POST",
        //         url: "<?php //echo site_url('get_all_employee_shift_details'); ?>", 
        //         data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
        //         dataType: "json",  
        //         cache:false,
        //         success: function(data){
        //             var employee_id = $("#employee").val();
                    
        //             if (employee_id) {

        //                 console.log(data);

        //                 var table = $('#detail_table').DataTable();

        //                 table.clear().draw();

        //                 var employee_name = '';
        //                 var total_break = 0;
        //                 var total_hours = 0;
        //                 var total_paid_break = 0;
        //                 var total_unpaid_break = 0;
        //                 var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php //echo base_url('view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

        //                 if (data['employee_name']) {
        //                     employee_name = data['employee_name'];
        //                     console.log(employee_name);
        //                 }
        //                 if (data['total_hours']) {
        //                     total_hours = data['total_hours'];
        //                     console.log(total_hours);
        //                 }
        //                 if (data['total_break']) {
        //                     total_break = data['total_break'];
        //                     console.log(total_break);
        //                 }
        //                 if (data['total_unpaid_break']) {
        //                     total_unpaid_break = data['total_unpaid_break'];
        //                     console.log(total_unpaid_break);
        //                 }
        //                 if (data['total_paid_break']) {
        //                     total_paid_break = data['total_paid_break'];
        //                     console.log(total_paid_break);
        //                 }
                        
        //                 table.row.add( [
        //                         employee_name,
        //                         total_hours,
        //                         total_break,
        //                         total_unpaid_break,
        //                         total_paid_break,
        //                         view_details
        //                     ] ).draw( false );

        //                 $('#detail_table').show();
        //             }
        //             else {
                        
        //                 var table = $('#detail_table').DataTable();

        //                 table.clear().draw();

        //                 $.each(data, function(key, val) {

        //                     var employee_name = '';
        //                     var total_break = 0;
        //                     var total_hours = 0;
        //                     var total_paid_break = 0;
        //                     var total_unpaid_break = 0;
        //                     var view_details = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php //echo base_url('view-employee-shifthours-detail'); ?>'><i class='fa fa-eye' aria-hidden='true'></i></a>";

        //                     if (val.employee_name) {
        //                         employee_name = val.employee_name;
        //                     }
        //                     if (val.total_break) {
        //                         total_break = val.total_break;
        //                     }
        //                     if (val.total_hours) {
        //                         total_hours = val.total_hours;
        //                     }
        //                     if (val.total_paid_break) {
        //                         total_paid_break = val.total_paid_break;
        //                     }
        //                     if (val.total_unpaid_break) {
        //                         total_unpaid_break = val.total_unpaid_break;
        //                     }

        //                     table.row.add( [
        //                         employee_name,
        //                         total_hours,
        //                         total_break,
        //                         total_unpaid_break,
        //                         total_paid_break,
        //                         view_details
        //                     ] ).draw( false );

        //                 });

        //                 $('#detail_table').show();
        //             }
        //         }
        //     });
        // });
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
