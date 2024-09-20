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

    .fa-lock  {
        color: #f90000;
    }
    .fa-times  {
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
                Timesheet
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Timesheet</a></li>
                <li class="active">Employee Timesheet</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="text-align: left;line-height: 1px;font-size: 12px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: left;">

                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <label>Employee Code
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['employee_code']; ?>
                                    <hr/>
                                    <label>Employee Name
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?>
                                    <hr/>
                                    <label>Employee Designation
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['employee_designation']; ?>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <?php
                                    /*if (!empty($get_vendor_details)) {
                                        ?>
                                        <label>Vendor Name
                                            : </label> &nbsp;<?php echo $get_vendor_details->name_prefix . " " . $get_vendor_details->first_name . " " . $get_vendor_details->last_name; ?>
                                        <hr/>
                                        <label>Company
                                            Name: </label> &nbsp;<?php echo $get_vendor_details->vendor_company_name; ?>
                                        <hr/>
                                        <?php
                                    }*/
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Timesheets</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body tab-div">
                            <table class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                    <tr>
                                        <th style="text-align: center;">SL No.</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Type</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center; width: 50%;">Comment</th>
                                        <th style="text-align: center;">Day</th>
                                        <th style="text-align: center;">Date</th>
                                        <th style="text-align: center;">Start Time</th>
                                        <th style="text-align: center;">End Time</th>
                                        <th style="text-align: center;">Total Time (Hours)</th>
                                        <th style="text-align: center;">Over Time (Hours)</th>
                                        <th style="text-align: center; width: 5%;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
//                                echo "<pre>";
//                                print_r($get_timesheet_data);
                                    $i = 1;
                                    $times = array();
                                    $otimes = array();
                                    if (!empty($get_project_timesheet_details)) {
                                        foreach ($get_project_timesheet_details as $tval) {

                                            $get_project_details = $this->employee_model->getProjectData($tval['project_id']);

                                            $times[] = $tval['tot_time'];
                                            $otimes[] = $tval['over_time'];

                                            $n_start_time = date("g:i a", strtotime($tval['start_time']));
                                            $n_end_time = date("g:i a", strtotime($tval['end_time']));
                                            ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $i; ?></td>
                                                <td style="text-align: center;"><?php echo strtoupper($get_project_details[0]['project_code']); ?></td>
                                                <td style="text-align: center;"><?php echo ucwords($get_project_details[0]['project_type']); ?></td>
                                                <td style="text-align: center;"><?php echo ucwords($get_project_details[0]['project_name']); ?></td>
                                                <td><?php echo stripcslashes($tval['comment']); ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo date("l", strtotime($tval['project_date'])); ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo date("d-m-Y", strtotime($tval['project_date'])); ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_start_time); ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_end_time); ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo $tval['tot_time']; ?></td>
                                                <td style="text-align: center; font-weight: bold;"><?php echo $tval['over_time']; ?></td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    if ($tval['approved_by_admin'] == '0') {
                                                        ?>
                                                        <label style="color: red;">Not Approve</label>
                                                        <?php
                                                    } elseif ($tval['approved_by_admin'] == '1') {
                                                        ?>
                                                        <label style="color: green;">Approved</label>
                                                        <?php
                                                    } elseif ($tval['approved_by_admin'] == '2') {
                                                        ?>
                                                        <label style="color: #f39c12;">Pending Approval</label>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    }
                                    ?>
                                </tbody>

                            </table>
                            <table class="table table-bordered table-striped" style="font-size: 11px;">
                                <tbody>
                                    <tr style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                        <td style="text-align: center; font-weight: bold;width:84%" colspan="8">Total Working Time</td>
                                        <td style="text-align: center; font-weight: bold; width: 5%;">
                                            <?php
                                            $hours = 0;
                                            $minutes = 0;
                                            //print_r($times); die;
                                            if (!empty($times)) {
                                                foreach ($times as $time) {
                                                    //echo $time;
                                                    $t_arr = explode(' ', $time);
                                                    $minutes += $t_arr[0] * 60;
                                                    //$minutes += $minute;
                                                }
                                                $hours = floor($minutes / 60);
                                            }
//$minutes -= $hours * 60;
                                            ?>
                                            <label>
                                                <?php echo $hours; ?>
                                            </label>
                                        </td>
                                        <td style="text-align: center; font-weight: bold; width: 5%;">
                                            <?php
                                            $ohours = 0;
                                            $ominutes = 0;
                                            if (!empty($otimes)) {
                                                foreach ($otimes as $otime) {
                                                    $o_arr = explode(' ', $otime);
                                                    $ominutes += $o_arr[0] * 60;
                                                    //$ominutes += $ominute;
                                                }

                                                $ohours = floor($ominutes / 60);
                                            }
//$ominutes -= $ohours * 60;
                                            ?>
                                            <label>
                                                <?php echo $ohours; ?>
                                            </label>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row (main row) -->
            <input type="button" value="Back" class="btn btn-default" onclick="window.history.back();">
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
<script>
    $(function () {
        $('#admin_tbl').DataTable();
    });
</script>
