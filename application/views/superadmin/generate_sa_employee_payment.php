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
                Employee
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Employee</a></li>
                <li class="active">Generate Invoice</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <?php if ($this->session->flashdata('error_msg')) { ?>
                        <div
                            class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                        <div
                            class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                        <?php } ?>
                    <div class="box">
                        <div class="box-body">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <span class="glyphicon glyphicon-th"></span>
                                        Generate Invoice
                                        for <?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'] . " (" . $get_employee_details[0]['employee_code'] . ")"; ?>
                                    </h3>
                                </div>
                                <form id="payment_form"
                                      action="<?php echo site_url('sa_generate_payment'); ?>"
                                      method="post" enctype="multipart/form-data">
                                    <div class="panel-body">
                                        <div class="row">

                                            <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">


                                                <div class="form-group">
                                                    <div class="col-sm-6 col-md-4">
                                                        <label for="email" class="lbl-css">Weekly / Monthly Invoice :</label>
                                                    </div>
                                                    <div class="col-sm-6 col-md-8">
                                                        <div class="input-group">
                                                            <select name="payment_type" id="payment_type"
                                                                    class="form-control validate[required]"
                                                                    onchange="showType(this.value);">
                                                                <option value="">Select</option>
                                                                <option value="1">Weekly Invoice</option>
                                                                <option value="2">Monthly Invoice</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="t_daily" style="display:none;">

                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="email" class="lbl-css">Project Start Date :</label>
                                                        </div>
                                                        <div class="col-sm-6 col-md-8">
                                                            <div class="input-group">
                                                                <input class="form-control validate[required] date" type="text"
                                                                       id="daily_start_date" name="daily_start_date"
                                                                       placeholder="Start Date" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="email" class="lbl-css">Project End Date :</label>
                                                        </div>
                                                        <div class="col-sm-6 col-md-8">
                                                            <div class="input-group date" id="end_dt">
                                                                <input class="form-control validate[required] date" type="text"
                                                                       id="daily_end_date" name="daily_end_date"
                                                                       placeholder="End Date" value=""
                                                                       onblur="getdailytimesheet()">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div id="t_weekly" style="display:none;">

                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="email" class="lbl-css">Project Start Date :</label>
                                                        </div>
                                                        <div class="col-sm-6 col-md-8">
                                                            <div class="input-group">
                                                                <input class="form-control validate[required] date" type="text"
                                                                       id="start_date" name="start_date"
                                                                       placeholder="Start Date" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="email" class="lbl-css">Project End Date :</label>
                                                        </div>
                                                        <div class="col-sm-6 col-md-8">
                                                            <div class="input-group date" id="end_dt">
                                                                <input class="form-control validate[required] date" type="text"
                                                                       id="end_date" name="end_date" placeholder="End Date"
                                                                       value="" onblur="getweeklytimesheet()">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div id="t_monthly" style="display:none;">

                                                    <div class="form-group">
                                                        <div class="col-sm-6 col-md-4">
                                                            <label for="email" class="lbl-css">Month:</label>
                                                        </div>
                                                        <div class="col-sm-6 col-md-8">
                                                            <div class="input-group">
                                                                <?php
                                                                $month_arr = array(
                                                                    "01" => "January",
                                                                    "02" => "February",
                                                                    "03" => "March",
                                                                    "04" => "April",
                                                                    "05" => "May",
                                                                    "06" => "June",
                                                                    "07" => "July",
                                                                    "08" => "August",
                                                                    "09" => "September",
                                                                    "10" => "October",
                                                                    "11" => "November",
                                                                    "12" => "December",
                                                                );
                                                                ?>
                                                                <select name="month" id="month"
                                                                        class="form-control validate[required]"
                                                                        onChange="getmonthlytimesheet(this.value)">
                                                                    <option value="">Select</option>
                                                                    <?php
                                                                    foreach ($month_arr as $mkey => $mval) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $mkey; ?>"><?php echo $mval; ?></option>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 col-md-12 col-lg-12" id="timesheet_td"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <input type="hidden" name="year" id="year" value="<?php echo date("Y"); ?>">
                                                <input type="hidden" name="employee_id" id="employee_id" value="<?php echo $employee_id; ?>">
                                                <input type="hidden" name="sa_id" id="sa_id" value="<?php echo $get_details[0]['sa_id']; ?>">
                                                <input class="btn btn-success" type="submit" name="submit" value="Generate Invoice">
                                                <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                            </div>
                                        </div>
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

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
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
        $("#payment_form").validationEngine({promptPosition: 'inline'});
    });

    $(document).ready(function () {

        $("#start_date").datepicker({
            format: 'mm-dd-yyyy',
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf() + (1000 * 60 * 60 * 24 * 7));
            var minDate = new Date(selected.date.valueOf() + (1000 * 60 * 60 * 24 * 7));
            $('#end_date').datepicker('setEndDate', maxDate);
            $('#end_date').datepicker('setStartDate', minDate);
        });

        $("#end_date").datepicker({
            format: 'mm-dd-yyyy',
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#start_date').datepicker('setEndDate', maxDate);
        });

    });

    $(document).ready(function () {

        $("#daily_start_date").datepicker({
            format: 'mm-dd-yyyy',
        });

        $("#daily_end_date").datepicker({
            format: 'mm-dd-yyyy',
        });
    });

    function showType(val) {
        var type = val;
        if (type == 1) {
            $("#t_weekly").show();
            $("#t_monthly").hide();
            $("#t_daily").hide();
        } else if (type == 2) {
            $("#t_weekly").hide();
            $("#t_daily").hide();
            $("#t_monthly").show();
        } else if (type == 3) {
            $("#t_weekly").hide();
            $("#t_monthly").hide();
            $("#t_daily").show();
        } else
        {
            $("#t_weekly").hide();
            $("#t_monthly").hide();
            $("#t_daily").hide();
        }
    }

    function getmonthlytimesheet(month_val) {
        var month = month_val;
        var year = $("#year").val();
        var employee_id = $("#employee_id").val();

        $.post("<?php echo site_url('sa_ajax_monthly_timesheet'); ?>", {
            month: month,
            year: year,
            employee_id: employee_id
        }, function (data) {
            //alert(data);
            $('#timesheet_td').html(data);

        });
    }

    function getweeklytimesheet() {
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        var employee_id = $("#employee_id").val();

        $.post("<?php echo site_url('sa_ajax_weekly_timesheet'); ?>", {
            start_date: start_date,
            end_date: end_date,
            employee_id: employee_id
        }, function (data) {
            //alert(data);
            $('#timesheet_td').html(data);

        });
    }

</script>