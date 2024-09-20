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

    .sidemenu {
        margin: 0;
        padding: 0;
        width: 188px;
        background-color: #f1f1f1;
        height: 656px;
        overflow: auto;
    }

    .sidemenu a {
        display: block;
        color: black;
        padding: 16px;
        text-decoration: none;
    }
    
    .sidemenu a.active {
        background-color: #04AA6D;
        color: white;
    }

    .sidemenu a:hover:not(.active) {
        background-color: #555;
        color: white;
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
                <li class="active">Employee Shift List</li>
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
                                Employee List
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

                            <div class="panel-body">

                                <div class="row">

                                    <h1 style="margin-left: 13px;"><?php echo ucfirst($shift_name)." Shift"; ?></h1>

                                    <div class="dropdown" style="margin-left: 13px;">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Assign
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" data-toggle="modal" data-target="#employee_assign">Assign to Employee</a></li>
                                            <li class="divider"></li>
                                            <li><a href="#" data-toggle="modal" data-target="#group_assign">Assign to Group</a></li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="row">
                                    
                                    <div style="margin-top:20px;" class="col-xs-2 col-sm-2 col-md-2">
                                        <div class="sidemenu">
                                                <a href="#employee" id="employee">Employees</a>
                                                <a href="#group" id="group">Group</a>
                                        </div>
                                    </div>

                                    <input type="hidden" name="shift_id" id="shift_id" value="<?php echo $shift_id; ?>">
                                    
                                    <div style="margin-top:20px;" class="col-xs-10 col-sm-10 col-md-10">

                                        <!-- <form action="<?php //echo base_url('submit-all-employee-shift'); ?>" method="post"> -->
                                            <table id="employee_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th>Employees</th>
                                                        <!-- <th>Employee Email</th> -->
                                                        <th>Employees Designation</th>
                                                        <!-- <th>Assign Shift</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                
                                                    foreach ($get_all_employee_shift_list as $employee) {
                                                
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $employee->first_name." ".$employee->last_name; ?><br><?php echo $employee->employee_email; ?></td>
                                                            <td><?php echo $employee->employee_designation; ?><button class="btn btn-danger remove_employee_from_shift" style="float:right;" data-employee-id="<?php echo $employee->employee_id; ?>">Remove</button></td>
                                                            <!-- <td><input type="checkbox" name="employee_id[]" class="employee_id" value="<?php //echo $employee->employee_id; ?>"></td> -->
                                                        </tr>
                                                    <?php
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                            <!-- <input type="hidden" name="shift_id" value="<?php //echo $shift_id; ?>">
                                            <input type="submit" value="Submit" class="btn btn-primary">
                                        </form> -->
                                            <table id="group_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th>Group</th>
                                                        <!-- <th>Employee Email</th> -->
                                                        <!-- <th>Employee Designation</th> -->
                                                        <!-- <th>Assign Shift</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                
                                                    foreach ($get_group_list_of_shift as $group) {
                                                
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $group->group_name; ?><br><?php echo $group->group_description; ?><button class="btn btn-danger remove_group_from_shift" style="float:right;" data-group-id="<?php echo $group->group_id; ?>">Remove</button></td>
                                                            <!-- <td><?php //echo $employee->employee_designation; ?></td> -->
                                                            <!-- <td><input type="checkbox" name="employee_id[]" class="employee_id" value="<?php //echo $employee->employee_id; ?>"></td> -->
                                                        </tr>
                                                    <?php
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
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

    <div class="modal fade" id="employee_assign" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo "Assign ".ucfirst($shift_name)." Shift to Employee"?></h4>
            </div>
            <div class="modal-body">

                <table id="assign_employee_shift_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                    <thead>
                        <tr>
                            <th>Employee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    
                        foreach ($all_employees as $e) {
                    
                        ?>
                            <tr>
                                <td><?php echo $e->first_name." ".$e->last_name; ?><br><?php echo $e->employee_email; ?><button class="btn btn-primary assign_employee" data-employee-id="<?php echo $e->employee_id; ?>" style="margin-top: -19px;float: right;">Assign</button></td>
                                <!-- <td><?php //echo $employee->employee_designation; ?></td> -->
                                <!-- <td><input type="checkbox" name="employee_id[]" class="employee_id" value="<?php //echo $employee->employee_id; ?>"></td> -->
                            </tr>
                        <?php
                            } 
                        ?>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        </div>
    </div>

    <div class="modal fade" id="group_assign" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo "Assign ".ucfirst($shift_name)." Shift to Group"?></h4>
            </div>
            <div class="modal-body">

                <table id="assign_group_shift_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                    <thead>
                        <tr>
                            <th>Group</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    
                        foreach ($all_groups as $g) {
                    
                        ?>
                            <tr>
                                <td><?php echo $g->group_name; ?><br><?php echo $g->group_description; ?><button class="btn btn-primary assign_group" data-group-id="<?php echo $g->group_id; ?>" style="margin-top: -19px;float: right;">Assign</button></td>
                                <!-- <td><?php //echo $employee->employee_designation; ?></td> -->
                                <!-- <td><input type="checkbox" name="employee_id[]" class="employee_id" value="<?php //echo $employee->employee_id; ?>"></td> -->
                            </tr>
                        <?php
                            } 
                        ?>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        </div>
    </div>
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
        $('#employee_table').DataTable();
        $('#assign_employee_shift_table').DataTable();
        $('#assign_group_shift_table').DataTable();
        $('#group_table').hide();
        $(document).on('click','#group', function(){
            $('#employee_table').hide();
            $('#group_table').show();
            $('#group_table').DataTable();
            $('#employee_table').DataTable().destroy();
            window.scrollTo(0, 0);
        });
        $(document).on('click','#employee', function(){
            $('#employee_table').show();
            $('#group_table').hide();
            $('#employee_table').DataTable();
            $('#group_table').DataTable().destroy();
            window.scrollTo(0, 0);
        });
        $(document).on('click', '.assign_employee', function() {
            var employee_id = $(this).attr("data-employee-id");
            var shift_id = $('#shift_id').val();

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin-assign_shift_to_employee'); ?>", 
                    data: {employee_id: employee_id, shift_id : shift_id},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        // debugger;
                        location.reload();
                    }
            });

            $(this).parent().parent().hide();
        });

        $(document).on('click', '.assign_group', function() {
            var group_id = $(this).attr("data-group-id");
            var shift_id = $('#shift_id').val();

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin-assign_shift_to_group'); ?>", 
                    data: {group_id: group_id, shift_id : shift_id},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        // debugger;
                        location.reload();
                    }
            });

            $(this).parent().parent().hide();
        });

        $(document).on('click', '.remove_employee_from_shift', function() {
            var employee_id = $(this).attr("data-employee-id");
            var shift_id = null;

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin-remove_employee_from_shift'); ?>", 
                    data: {employee_id: employee_id, shift_id : shift_id},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        // debugger;
                        location.reload();
                    }
            });

            // $(this).parent().parent().hide();
        });

        $(document).on('click', '.remove_group_from_shift', function() {
            var group_id = $(this).attr("data-group-id");
            var shift_id = null;

            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin-remove_group_from_shift'); ?>", 
                    data: {group_id: group_id, shift_id : shift_id},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        // debugger;
                        location.reload();
                    }
            });

            // $(this).parent().parent().hide();
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
