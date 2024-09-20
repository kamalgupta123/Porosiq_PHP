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

    .hide_column {
        display : none;
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
                            <div class="alert alert-success succ-msg" style="display: none;">success</div>

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
                                                            <option value="<?php echo $empshift['employee_id']; ?>" <?php echo $this->session->userdata('employee_datewise_shift_summary_employee_id') == $empshift['employee_id'] ? 'selected': ''; ?>><?php echo $empshift['first_name']." ".$empshift['last_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    </td>

                                                    <td>
                                                    <label for="date" class="lbl-css">From<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <input type="date" id="date" name="date" min="1900-06-01" max="2090-06-30" value="<?php echo $this->session->userdata("employee_datewise_shift_summary_from") ? date('Y-m-d',strtotime($this->session->userdata("employee_datewise_shift_summary_from"))) : '';?>">
                                                    </td>

                                                    <td>
                                                    <label for="date" class="lbl-css">To<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                    <input type="date" id="date2" name="date2" min="1900-06-01" max="2090-06-30" value="<?php echo $this->session->userdata("employee_datewise_shift_summary_to") ? date('Y-m-d',strtotime($this->session->userdata("employee_datewise_shift_summary_to"))) : '';?>">
                                                    </td>

                                                    <td><button class="btn btn-primary" id="search">Search</button></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <table class="table table-bordered table-striped" id="detail_table">
                                        <thead>
                                            <tr>
                                                <th>Clock Time Id</th>
                                                <th>Employee Name</th>
                                                <th>Date</th>
                                                <th>Clock-in</th>
                                                <th>Clock-out</th>
                                                <th>Total Hours</th>
                                                <th>Total Personal Break</th>
                                                <th>Total Meeting Break</th>
                                                <th>Total Training Break</th>
                                                <th>Total Lunch Break</th>
                                                <th>Total Break</th>
                                                <th>Approve Shift Status</th>
                                                <th>Approve Shift</th>
                                            </tr>
                                        </thead>
                                        <tbody id="summary_table">
                        
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
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>
    $(document).ready(function () {
        var table;
        // binds form submission and fields to the validation engine
        $("#edit_employee_form").validationEngine({promptPosition: 'inline'});

        var employee_id = <?php if (!empty($this->session->userdata('employee_datewise_shift_summary_employee_id'))) {echo $this->session->userdata('employee_datewise_shift_summary_employee_id'); } else {echo 0;}?>;

        var from = '<?php echo $this->session->userdata("employee_datewise_shift_summary_from"); ?>';

        var to = '<?php echo $this->session->userdata("employee_datewise_shift_summary_to"); ?>';

        // if (employee_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('superadmin_get_employee_shift_summary_data_all'); ?>", 
                data: {from: from,to: to, employee_id : employee_id},
                dataType: "json",  
                cache:false,
                success: function(data){
                    if ($.fn.DataTable.isDataTable('#detail_table')) {
                        table = $('#detail_table').DataTable();
                    }
                    else {
                        table = $('#detail_table').DataTable({
                            destroy: true,
                            dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                            //scrollY: "300px",
                            scrollX: true,
                            scrollCollapse: true,
                            columnDefs: [ {
                                    "targets": [ 0 ],
                                    className: "hide_column"
                                },{
                                targets: -1,
                                data: null,
                                defaultContent: "<a class='tbl_icon approve' href='javascript:void(0)' data-toggle='tooltip' title='Approve'><i class='fa fa-check' aria-hidden='true' style='color: green;'></i></a><a class='tbl_icon disapprove' href='javascript:void(0)' data-toggle='tooltip' title='Disapprove'><i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>"
                            } ],
                    //        paging: false,
                            
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    exportOptions: {
                                        columns: [ 1, 2, 3, 4, 5, 6, 7 ,8, 9, 10]
                                    }
                                },
                                {
                                    extend: 'pdfHtml5',
                                    orientation: 'landscape',
                                    exportOptions: {
                                        columns: [ 1, 2, 3, 4, 5, 6, 7 ,8, 9, 10 ]
                                    }
                                },
                                {
                                    extend: 'csvHtml5',
                                    exportOptions: {
                                        columns: [ 1, 2, 3, 4, 5, 6, 7 ,8, 9, 10 ]
                                    }
                                }
                            ]

                        });
                    }

                    table.clear().draw();
                    // $('#summary_table').html('');
                    $.each(data, function(key, val) {
                        var Personal = '0 hours 0 minutes 0 seconds';
                        var Meeting = '0 hours 0 minutes 0 seconds';
                        var Training = '0 hours 0 minutes 0 seconds';
                        var Lunch = '0 hours 0 minutes 0 seconds';
                        var Total = '0 hours 0 minutes 0 seconds';
                        var is_approved_by_admin = 'N/A';
                        var clock_out = '';
                        var total_break_hours_seconds = 0;
                        var total_hour_seconds = 0;
                        var diff_total_time = '0 hours 0 minutes 0 seconds';

                        if (val.total_break_hours_str) {
                            var total_break_hours_str = val.total_break_hours_str;
                            var a = total_break_hours_str.split(':');
                            total_break_hours_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
                        }
                        if (val.total_hour_str) {
                            var total_hour_str = val.total_hour_str;
                            var a = total_hour_str.split(':');
                            total_hour_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
                            console.log(total_hour_seconds);

                            var diff = total_hour_seconds - total_break_hours_seconds;

                            var d = Number(diff);
                            var h = Math.floor(d / 3600);
                            var m = Math.floor(d % 3600 / 60);
                            var s = Math.floor(d % 3600 % 60);

                            var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
                            var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
                            var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
                            diff_total_time = hDisplay + mDisplay + sDisplay;
                        }

                        
                        if (val.Personal) {
                            Personal = val.Personal;
                        }
                        if (val.Meeting) {
                            Meeting = val.Meeting;
                        }
                        if (val.Training) {
                            Training = val.Training;
                        }
                        if (val.Lunch) {
                            Lunch = val.Lunch;
                        }
                        if (val.Total) {
                            Total = val.Total;
                        }
                        if (val.is_approved_by_superadmin == '1') {
                            is_approved_by_admin = 'Approved';
                        }
                        if (val.is_approved_by_superadmin == '0') {
                            is_approved_by_admin = 'Disapproved';
                        }
                        if (val.clock_out) {
                            clock_out = val.clock_out.substring(0,8);
                        }
                        // console.log(is_approved_by_admin);
                        table.row.add( [
                            val.clock_time_id,
                            val.first_name+' '+val.last_name,
                            val.date,
                            val.clock_in.substring(0,8),
                            clock_out,
                            diff_total_time,
                            Personal,
                            Meeting,
                            Training,
                            Lunch,
                            Total,
                            is_approved_by_admin
                        ] ).draw( false );

                        // $('#summary_table').append("<tr><td>"+val.first_name+" "+val.last_name+"</td><td>"+val.date+"</td><td>"+val.clock_in.substring(0,8)+"</td><td>"+val.clock_out.substring(0,8)+"</td><td>"+val.total_hours+"</td><td>"+Personal+"</td><td>"+Meeting+"</td><td>"+Training+"</td><td>"+Total+"</td></tr>");
                    });
                    table.columns.adjust().order( [ 1, 'asc' ] ).draw();
                    $('#detail_table').show();
                }
            });
        // }

        $(document).on('click','#search', function() {

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
                    url: "<?php echo site_url('superadmin_get_employee_shift_summary_data_all'); ?>", 
                    data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        // console.log(data);
                        
                        if ($.fn.DataTable.isDataTable('#detail_table')) {
                            table = $('#detail_table').DataTable();
                        }
                        else {
                            table = $('#detail_table').DataTable({
                                destroy: true,
                                dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                                "<'row'<'col-sm-12'tr>>" +
                                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                                //scrollY: "300px",
                                scrollX: true,
                                scrollCollapse: true,
                                columnDefs: [ {
                                        "targets": [ 0 ],
                                        className: "hide_column"
                                    },{
                                    targets: -1,
                                    data: null,
                                    defaultContent: "<a class='tbl_icon approve' href='javascript:void(0)' data-toggle='tooltip' title='Approve'><i class='fa fa-check' aria-hidden='true' style='color: green;'></i></a><a class='tbl_icon disapprove' href='javascript:void(0)' data-toggle='tooltip' title='Disapprove'><i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>"
                                } ],
                        //        paging: false,
                                
                                buttons: [
                                    {
                                        extend: 'excelHtml5',
                                        exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8]
                                        }
                                    },
                                    {
                                        extend: 'pdfHtml5',
                                        orientation: 'landscape',
                                        exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                        }
                                    },
                                    {
                                        extend: 'csvHtml5',
                                        exportOptions: {
                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                        }
                                    }
                                ]

                            });
                        }

                        table.clear().draw();
                        // $('#summary_table').html('');
                        $.each(data, function(key, val) {
                            var Personal = '0 hours 0 minutes 0 seconds';
                            var Meeting = '0 hours 0 minutes 0 seconds';
                            var Training = '0 hours 0 minutes 0 seconds';
                            var Lunch = '0 hours 0 minutes 0 seconds';
                            var Total = '0 hours 0 minutes 0 seconds';
                            var is_approved_by_admin = 'N/A';
                            var clock_out = '';
                            var total_break_hours_seconds = 0;
                            var total_hour_seconds = 0;
                            var diff_total_time = '0 hours 0 minutes 0 seconds';

                            if (val.total_break_hours_str) {
                                var total_break_hours_str = val.total_break_hours_str;
                                var a = total_break_hours_str.split(':');
                                total_break_hours_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
                            }
                            if (val.total_hour_str) {
                                var total_hour_str = val.total_hour_str;
                                var a = total_hour_str.split(':');
                                total_hour_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

                                var diff = total_hour_seconds - total_break_hours_seconds;

                                var d = Number(diff);
                                var h = Math.floor(d / 3600);
                                var m = Math.floor(d % 3600 / 60);
                                var s = Math.floor(d % 3600 % 60);

                                var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
                                var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
                                var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
                                diff_total_time = hDisplay + mDisplay + sDisplay;
                            }
                            if (val.Personal) {
                                Personal = val.Personal;
                            }
                            if (val.Meeting) {
                                Meeting = val.Meeting;
                            }
                            if (val.Training) {
                                Training = val.Training;
                            }
                            if (val.Lunch) {
                                Lunch = val.Lunch;
                            }
                            if (val.Total) {
                                Total = val.Total;
                            }
                            if (val.is_approved_by_superadmin == '1') {
                                is_approved_by_admin = 'Approved';
                            }
                            if (val.is_approved_by_superadmin == '0') {
                                is_approved_by_admin = 'Disapproved';
                            }
                            if (val.clock_out) {
                                clock_out = val.clock_out.substring(0,8);
                            }

                            table.row.add( [
                                val.clock_time_id,
                                val.first_name+' '+val.last_name,
                                val.date,
                                val.clock_in.substring(0,8),
                                clock_out,
                                diff_total_time,
                                Personal,
                                Meeting,
                                Training,
                                Lunch,
                                Total,
                                is_approved_by_admin
                            ] ).draw( false );

                            // $('#summary_table').append("<tr><td>"+val.first_name+" "+val.last_name+"</td><td>"+val.date+"</td><td>"+val.clock_in.substring(0,8)+"</td><td>"+val.clock_out.substring(0,8)+"</td><td>"+val.total_hours+"</td><td>"+Personal+"</td><td>"+Meeting+"</td><td>"+Training+"</td><td>"+Total+"</td></tr>");
                        });
                        table.columns.adjust().order( [ 1, 'asc' ] ).draw();
                        $('#detail_table').show();
                    }
                });
            }

        });

        // $(document).on('change', '#date2', function() {
        //     $.ajax({
        //         type: "POST",
        //         url: "<?php //echo site_url('get_employee_shift_summary_data_all'); ?>", 
        //         data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
        //         dataType: "json",  
        //         cache:false,
        //         success: function(data){
        //             // console.log(data);
                    
        //             if ($.fn.DataTable.isDataTable('#detail_table')) {
        //                 table = $('#detail_table').DataTable();
        //             }
        //             else {
        //                 table = $('#detail_table').DataTable({
        //                     destroy: true,
        //                     dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
        //                     "<'row'<'col-sm-12'tr>>" +
        //                     "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        //                     //scrollY: "300px",
        //                     scrollX: true,
        //                     scrollCollapse: true,
        //                     columnDefs: [ {
        //                             "targets": [ 0 ],
        //                             className: "hide_column"
        //                         },{
        //                         targets: -1,
        //                         data: null,
        //                         defaultContent: "<a class='tbl_icon approve' href='javascript:void(0)' data-toggle='tooltip' title='Approve'><i class='fa fa-check' aria-hidden='true' style='color: green;'></i></a><a class='tbl_icon disapprove' href='javascript:void(0)' data-toggle='tooltip' title='Disapprove'><i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>"
        //                     } ],
        //             //        paging: false,
                            
        //                     buttons: [
        //                         {
        //                             extend: 'excelHtml5',
        //                             exportOptions: {
        //                                 columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8]
        //                             }
        //                         },
        //                         {
        //                             extend: 'pdfHtml5',
        //                             orientation: 'landscape',
        //                             exportOptions: {
        //                                 columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
        //                             }
        //                         },
        //                         {
        //                             extend: 'csvHtml5',
        //                             exportOptions: {
        //                                 columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
        //                             }
        //                         }
        //                     ]

        //                 });
        //             }

        //             table.clear().draw();
        //             // $('#summary_table').html('');
        //             $.each(data, function(key, val) {
        //                 var Personal = '0 hours 0 minutes 0 seconds';
        //                 var Meeting = '0 hours 0 minutes 0 seconds';
        //                 var Training = '0 hours 0 minutes 0 seconds';
        //                 var Lunch = '0 hours 0 minutes 0 seconds';
        //                 var Total = '0 hours 0 minutes 0 seconds';
        //                 var is_approved_by_admin = 'N/A';
        //                 var clock_out = '';
        //                 var total_break_hours_seconds = 0;
        //                 var total_hour_seconds = 0;
        //                 var diff_total_time = '0 hours 0 minutes 0 seconds';

        //                 if (val.total_break_hours_str) {
        //                     var total_break_hours_str = val.total_break_hours_str;
        //                     var a = total_break_hours_str.split(':');
        //                     total_break_hours_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
        //                 }
        //                 if (val.total_hour_str) {
        //                     var total_hour_str = val.total_hour_str;
        //                     var a = total_hour_str.split(':');
        //                     total_hour_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

        //                     var diff = total_hour_seconds - total_break_hours_seconds;

        //                     var d = Number(diff);
        //                     var h = Math.floor(d / 3600);
        //                     var m = Math.floor(d % 3600 / 60);
        //                     var s = Math.floor(d % 3600 % 60);

        //                     var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
        //                     var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
        //                     var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
        //                     diff_total_time = hDisplay + mDisplay + sDisplay; 
        //                 }
        //                 if (val.Personal) {
        //                     Personal = val.Personal;
        //                 }
        //                 if (val.Meeting) {
        //                     Meeting = val.Meeting;
        //                 }
        //                 if (val.Training) {
        //                     Training = val.Training;
        //                 }
        //                 if (val.Lunch) {
        //                     Lunch = val.Lunch;
        //                 }
        //                 if (val.Total) {
        //                     Total = val.Total;
        //                 }
        //                 if (val.is_approved_by_admin == '1') {
        //                     is_approved_by_admin = 'Approved';
        //                 }
        //                 if (val.is_approved_by_admin == '0') {
        //                     is_approved_by_admin = 'Disapproved';
        //                 }
        //                 if (val.clock_out) {
        //                     clock_out = val.clock_out.substring(0,8);
        //                 }

        //                 table.row.add( [
        //                     val.clock_time_id,
        //                     val.first_name+' '+val.last_name,
        //                     val.date,
        //                     val.clock_in.substring(0,8),
        //                     clock_out,
        //                     diff_total_time,
        //                     Personal,
        //                     Meeting,
        //                     Training,
        //                     Lunch,
        //                     Total,
        //                     is_approved_by_admin
        //                 ] ).draw( false );

        //                 // $('#summary_table').append("<tr><td>"+val.first_name+" "+val.last_name+"</td><td>"+val.date+"</td><td>"+val.clock_in.substring(0,8)+"</td><td>"+val.clock_out.substring(0,8)+"</td><td>"+val.total_hours+"</td><td>"+Personal+"</td><td>"+Meeting+"</td><td>"+Training+"</td><td>"+Total+"</td></tr>");
        //             });
        //             table.columns.adjust().order( [ 1, 'asc' ] ).draw();
        //             $('#detail_table').show();
        //         }
        //     });
        // });


        $(document).on('click', '.approve', function(){
            var tr = $(this).closest('tr');
            var id = tr.children('td:eq(0)').text();
            console.log(id);
            var admin_id = <?php echo  $get_details[0]['sa_id']; ?>;
            console.log(admin_id);

            bootbox.confirm({
                message: "Do You Want To Approve",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    console.log(result);
                    if (result == true) {
                        $.post("<?php echo site_url('superadmin_change_employee_datewise_shift_summary_status'); ?>", {clock_time_id: id, admin_id: admin_id, from: $('#date').val(),to: $('#date2').val()}, function (data) {
                            if (data == 1) {


                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('superadmin_get_employee_shift_summary_data_all'); ?>", 
                                    data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
                                    dataType: "json",  
                                    cache:false,
                                    success: function(data){
                                        
                                        if ($.fn.DataTable.isDataTable('#detail_table')) {
                                            table = $('#detail_table').DataTable();
                                        }
                                        else {
                                            table = $('#detail_table').DataTable({
                                                destroy: true,
                                                dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                                                "<'row'<'col-sm-12'tr>>" +
                                                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                                                //scrollY: "300px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                columnDefs: [ {
                                                        "targets": [ 0 ],
                                                        className: "hide_column"
                                                    },{
                                                    targets: -1,
                                                    data: null,
                                                    defaultContent: "<a class='tbl_icon approve' href='javascript:void(0)' data-toggle='tooltip' title='Approve'><i class='fa fa-check' aria-hidden='true' style='color: green;'></i></a><a class='tbl_icon disapprove' href='javascript:void(0)' data-toggle='tooltip' title='Disapprove'><i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>"
                                                } ],
                                        //        paging: false,
                                                
                                                buttons: [
                                                    {
                                                        extend: 'excelHtml5',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8]
                                                        }
                                                    },
                                                    {
                                                        extend: 'pdfHtml5',
                                                        orientation: 'landscape',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                                        }
                                                    },
                                                    {
                                                        extend: 'csvHtml5',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                                        }
                                                    }
                                                ]

                                            });
                                        }

                                        table.clear().draw();
                                        // $('#summary_table').html('');
                                        $.each(data, function(key, val) {
                                            var Personal = '0 hours 0 minutes 0 seconds';
                                            var Meeting = '0 hours 0 minutes 0 seconds';
                                            var Training = '0 hours 0 minutes 0 seconds';
                                            var Lunch = '0 hours 0 minutes 0 seconds';
                                            var Total = '0 hours 0 minutes 0 seconds';
                                            var is_approved_by_admin = 'N/A';
                                            var clock_out = '';
                                            var total_break_hours_seconds = 0;
                                            var total_hour_seconds = 0;
                                            var diff_total_time = '0 hours 0 minutes 0 seconds';
                                            
                                            if (val.total_break_hours_str) {
                                                var total_break_hours_str = val.total_break_hours_str;
                                                var a = total_break_hours_str.split(':');
                                                total_break_hours_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
                                            }
                                            if (val.total_hour_str) {
                                                var total_hour_str = val.total_hour_str;
                                                var a = total_hour_str.split(':');
                                                total_hour_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

                                                var diff = total_hour_seconds - total_break_hours_seconds;

                                                var d = Number(diff);
                                                var h = Math.floor(d / 3600);
                                                var m = Math.floor(d % 3600 / 60);
                                                var s = Math.floor(d % 3600 % 60);

                                                var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
                                                var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
                                                var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
                                                diff_total_time = hDisplay + mDisplay + sDisplay;
                                            }
                                            if (val.Personal) {
                                                Personal = val.Personal;
                                            }
                                            if (val.Meeting) {
                                                Meeting = val.Meeting;
                                            }
                                            if (val.Training) {
                                                Training = val.Training;
                                            }
                                            if (val.Lunch) {
                                                Lunch = val.Lunch;
                                            }
                                            if (val.Total) {
                                                Total = val.Total;
                                            }
                                            if (val.is_approved_by_superadmin == '1') {
                                                is_approved_by_admin = 'Approved';
                                            }
                                            if (val.is_approved_by_superadmin == '0') {
                                                is_approved_by_admin = 'Disapproved';
                                            }
                                            if (val.clock_out) {
                                                clock_out = val.clock_out.substring(0,8);
                                            }

                                            table.row.add( [
                                                val.clock_time_id,
                                                val.first_name+' '+val.last_name,
                                                val.date,
                                                val.clock_in.substring(0,8),
                                                clock_out,
                                                diff_total_time,
                                                Personal,
                                                Meeting,
                                                Training,
                                                Lunch,
                                                Total,
                                                is_approved_by_admin
                                            ] ).draw( false );

                                            // $('#summary_table').append("<tr><td>"+val.first_name+" "+val.last_name+"</td><td>"+val.date+"</td><td>"+val.clock_in.substring(0,8)+"</td><td>"+val.clock_out.substring(0,8)+"</td><td>"+val.total_hours+"</td><td>"+Personal+"</td><td>"+Meeting+"</td><td>"+Training+"</td><td>"+Total+"</td></tr>");
                                        });
                                        table.columns.adjust().draw();
                                        $('#detail_table').show();
                                        var msg = 'Employee Approved Successfully';
                                        $(".succ-msg").html(msg);
                                        $(".succ-msg").show();
                                        setTimeout(function () {
                                            $(".succ-msg").hide();
                                        }, 3000);
                                    }
                                });
                            } else
                            {
                                $(".succ-msg").hide();
                            }
                        });
                    }
                }
            });
        });


        $(document).on('click', '.disapprove', function(){
            var tr = $(this).closest('tr');
            var id = tr.children('td:eq(0)').text();
            console.log(id);
            var admin_id = <?php echo  $get_details[0]['sa_id']; ?>;
            console.log(admin_id);

            bootbox.confirm({
                message: "Do You Want To Disapprove",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    console.log(result);
                    if (result == true) {
                        $.post("<?php echo site_url('superadmin_change_employee_datewise_shift_summary_status_disapprove'); ?>", {clock_time_id: id, admin_id: admin_id, from: $('#date').val(),to: $('#date2').val()}, function (data) {
                            if (data == 1) {

                                $.ajax({
                                    type: "POST",
                                    url: "<?php echo site_url('superadmin_get_employee_shift_summary_data_all'); ?>", 
                                    data: {from: $('#date').val(),to: $('#date2').val(), employee_id : $("#employee").val()},
                                    dataType: "json",  
                                    cache:false,
                                    success: function(data){
                                        
                                        if ($.fn.DataTable.isDataTable('#detail_table')) {
                                            table = $('#detail_table').DataTable();
                                        }
                                        else {
                                            table = $('#detail_table').DataTable({
                                                destroy: true,
                                                dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                                                "<'row'<'col-sm-12'tr>>" +
                                                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                                                //scrollY: "300px",
                                                scrollX: true,
                                                scrollCollapse: true,
                                                columnDefs: [ {
                                                        "targets": [ 0 ],
                                                        className: "hide_column"
                                                    },{
                                                    targets: -1,
                                                    data: null,
                                                    defaultContent: "<a class='tbl_icon approve' href='javascript:void(0)' data-toggle='tooltip' title='Approve'><i class='fa fa-check' aria-hidden='true' style='color: green;'></i></a><a class='tbl_icon disapprove' href='javascript:void(0)' data-toggle='tooltip' title='Disapprove'><i class='fa fa-times' aria-hidden='true' style='color: red;'></i></a>"
                                                } ],
                                        //        paging: false,
                                                
                                                buttons: [
                                                    {
                                                        extend: 'excelHtml5',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8]
                                                        }
                                                    },
                                                    {
                                                        extend: 'pdfHtml5',
                                                        orientation: 'landscape',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                                        }
                                                    },
                                                    {
                                                        extend: 'csvHtml5',
                                                        exportOptions: {
                                                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ,8 ]
                                                        }
                                                    }
                                                ]

                                            });
                                        }

                                        table.clear().draw();
                                        // $('#summary_table').html('');
                                        $.each(data, function(key, val) {
                                            var Personal = '0 hours 0 minutes 0 seconds';
                                            var Meeting = '0 hours 0 minutes 0 seconds';
                                            var Training = '0 hours 0 minutes 0 seconds';
                                            var Lunch = '0 hours 0 minutes 0 seconds';
                                            var Total = '0 hours 0 minutes 0 seconds';
                                            var is_approved_by_admin = 'N/A';
                                            var clock_out = '';
                                            var total_break_hours_seconds = 0;
                                            var total_hour_seconds = 0;
                                            var diff_total_time = '0 hours 0 minutes 0 seconds';

                                            if (val.total_break_hours_str) {
                                                var total_break_hours_str = val.total_break_hours_str;
                                                var a = total_break_hours_str.split(':');
                                                total_break_hours_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);
                                            }
                                            if (val.total_hour_str) {
                                                var total_hour_str = val.total_hour_str;
                                                var a = total_hour_str.split(':');
                                                total_hour_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]);

                                                var diff = total_hour_seconds - total_break_hours_seconds;

                                                var d = Number(diff);
                                                var h = Math.floor(d / 3600);
                                                var m = Math.floor(d % 3600 / 60);
                                                var s = Math.floor(d % 3600 % 60);

                                                var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
                                                var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
                                                var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";
                                                diff_total_time = hDisplay + mDisplay + sDisplay;
                                            }
                                            if (val.Personal) {
                                                Personal = val.Personal;
                                            }
                                            if (val.Meeting) {
                                                Meeting = val.Meeting;
                                            }
                                            if (val.Training) {
                                                Training = val.Training;
                                            }
                                            if (val.Lunch) {
                                                Lunch = val.Lunch;
                                            }
                                            if (val.Total) {
                                                Total = val.Total;
                                            }
                                            if (val.is_approved_by_superadmin == '1') {
                                                is_approved_by_admin = 'Approved';
                                            }
                                            if (val.is_approved_by_superadmin == '0') {
                                                is_approved_by_admin = 'Disapproved';
                                            }
                                            if (val.clock_out) {
                                                clock_out = val.clock_out.substring(0,8);
                                            }

                                            table.row.add( [
                                                val.clock_time_id,
                                                val.first_name+' '+val.last_name,
                                                val.date,
                                                val.clock_in.substring(0,8),
                                                clock_out,
                                                diff_total_time,
                                                Personal,
                                                Meeting,
                                                Training,
                                                Lunch,
                                                Total,
                                                is_approved_by_admin
                                            ] ).draw( false );

                                            // $('#summary_table').append("<tr><td>"+val.first_name+" "+val.last_name+"</td><td>"+val.date+"</td><td>"+val.clock_in.substring(0,8)+"</td><td>"+val.clock_out.substring(0,8)+"</td><td>"+val.total_hours+"</td><td>"+Personal+"</td><td>"+Meeting+"</td><td>"+Training+"</td><td>"+Total+"</td></tr>");
                                        });
                                        table.columns.adjust().draw();
                                        $('#detail_table').show();
                                        var msg = 'Employee Disapproved Successfully';
                                        $(".succ-msg").html(msg);
                                        $(".succ-msg").show();
                                        setTimeout(function () {
                                            $(".succ-msg").hide();
                                        }, 3000);
                                    }
                                });

                            } else
                            {
                                $(".succ-msg").hide();
                            }
                        });
                    }
                }
            });
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
