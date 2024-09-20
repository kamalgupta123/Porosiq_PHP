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

    label {
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
                Timesheet
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Timesheet</a></li>
                <li class="active">Add 1099 User Timesheet</li>
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
                                Add 1099 User Timesheet
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required
                                    Fields</p>
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
                        <form id="add_timesheet_form"
                              action="<?php echo site_url('insert_new_ten99user_timesheet'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">
                                    <table id="admin_tbl" width="100%" class="table table-bordered table-striped"
                                           style="font-size: 11px;">
                                        <tbody>
                                        <tr>
                                            <td width="8%" align="center"><label>Select 1099 User</label>
                                                <span style="color: red;">*</span></td>
                                            <td width="10%" align="center">
                                                <select name="employee_id" id="employee_id"
                                                        class="form-control validate[required]"
                                                        onchange="return getProjectDetails();">
                                                    <option value="">Select</option>
                                                    <?php
                                                    if (!empty($get_employee_lists)) {
                                                        foreach ($get_employee_lists as $eval) {
                                                            ?>
                                                            <option
                                                                value="<?php echo $eval['employee_id']; ?>"><?php echo $eval['employee_code'] . " - " . $eval['first_name'] . " " . $eval['last_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>

                                                </select>
                                            </td>
                                            <td width="8%" align="center"><label>Select Project</label> <span
                                                    style="color: red;">*</span></td>
                                            <td width="10%" align="center">
                                                <div id="project_div">
                                                    <select name="project_id" id="project_id"
                                                            class="form-control validate[required]"
                                                            onchange="return fetchDate();">
                                                        <option value="">Select</option>

                                                    </select>
                                                </div>
                                            </td>
                                            <td width="8%" align="center"><label>Period</label> <span
                                                    style="color: red;">*</span></td>
                                            <td width="8%" align="center">
                                                <input type="text" id="start_date" name="start_date"
                                                       class="validate[required]" placeholder="From Date">
                                            </td>
                                            <td width="1%"><label>To</label></td>
                                            <td width="8%" align="center">
                                                <input type="text" id="end_date" name="end_date"
                                                       class="validate[required]" placeholder="End Date"
                                                       onchange="return fetchDate();">
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div id="timesheet_list" class="table-responsive">
                                    </div>
                                    <table id="admin_tbl" width="100%" class="table table-bordered table-striped"
                                           style="font-size: 11px;">
                                        <tbody>
                                        <tr>
                                            <td width="8%"><label>Comment</label> <span style="color: red;">*</span>
                                            </td>
                                            <td width="92%" align="center">
                                                <textarea name="comment" class="form-control validate[required]"
                                                          rows="2"
                                                          style="resize: none;height: 35px !important;"></textarea>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">

                                        <input class="btn btn-success" type="submit" name="submit"
                                               value="Add Timesheet">
                                        <a href="javascript:void(0)" onclick="window.history.back();"
                                           class="btn btn-default">Back</a>
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
        $("#add_timesheet_form").validationEngine({promptPosition: 'inline'});
    });

    function getProjectDetails() {
        var employee_id = $("#employee_id").val();
        if(employee_id!= '') {
            $.post("<?php echo site_url('ajax_ten99user_project_list'); ?>", {employee_id: employee_id}, function (data) {
                //alert(data);
                $('#project_div').html(data);

            });
        }
        else{
            $('#project_div').html('<select name="project_id" id="project_id" class="form-control validate[required]" onchange="return fetchDate();"><option value="">Select</option></select>');
        }
    }


</script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js" type="text/javascript" charset="utf-8"></script>

<script>

    $(function () {
        $("#start_date").datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: '0',
            format: 'mm-dd-yyyy',
            onSelect: function (selected) {
                var date = $(this).datepicker('getDate');
                date.setDate(date.getDate() + 6); // Add 7 days
                $("#end_date").datepicker("option", "minDate", selected);
                $("#end_date").datepicker("option", "maxDate", date);
                $('#end_date').val('');
            }
        });
        $("#end_date").datepicker({
            changeMonth: true,
            changeYear: true,
            maxDate: '0',
            format: 'mm-dd-yyyy'
        });
    });


    function fetchDate() {

        var project_id = $("#project_id").val();
//        alert(project_id);
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        if (project_id != '' && start_date != '' && end_date != '') {
            $.post("<?php echo site_url('ajax_get_ten99user_timesheet_list'); ?>", {
                project_id: project_id,
                start_date: start_date,
                end_date: end_date
            }, function (data) {
                //alert(data);
                $("#timesheet_list").html(data);
            });
        } else if (project_id == '') {
            $("#timesheet_list").html('');
        } else if (start_date == '') {
            $("#timesheet_list").html('');
        } else if (end_date == '') {
            $("#timesheet_list").html('');
        }
    }

</script>
<script type="text/javascript">
    $('select').select2('destroy');
</script>