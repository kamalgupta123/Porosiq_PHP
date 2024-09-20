<?php
ini_set('memory_limit', '-1');
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

    /*.dataTables_filter {*/
        /*display: none;*/
    /*}*/

    tfoot {
        display: table-header-group;
    }

    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

    ul.tabs {
        margin: 0px;
        padding: 0px;
        list-style: none;
    }

    ul.tabs li {
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }

    ul.tabs li.current {
        background: #09274b;
        color: #fff;

    }

    .tab-content {
        display: none;
        background: #fff;
        padding: 15px 0px;
    }

    .tab-content.current {
        display: inherit;
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
                <li class="active">Consultant Timesheet</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">
                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add-con-timesheet'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Consultant Timesheet</a>
                            </div>
                        </div>
                    </div>
                    <?php if (INDIA) { ?>
                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                        <?php } } ?>
                    <div class="box">
                        <!-- /.box-header -->
                        <div class="box-body tab-div">
                            
                            <label for="select_employee">Select Employee : </label>
                            <select name="select_employee" id="select_employee">
                                <?php foreach ($employee_list as $e) { ?>
                                    <option value="<?php echo $e['employee_id']; ?>"><?php echo $e['first_name']." ".$e['last_name']; ?></option>
                                <?php } ?>
                            </select>
                            <br>
                            <label for="select_status">Select Status : </label>
                            <select name="status" id="status">
                                <option value="1">Approved Timesheet</option>
                                <option value="2">Pending Timesheet</option>
                                <option value="0">Not Approved Timesheet</option>
                            </select>
                            <br>
                            <label for="start_date">Start Date : </label>
                            <?php
                                $selected_month = date('m'); //current month

                                echo '<select id="start_month" name="start_month">'."\n";
                                for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                    $selected = ($selected_month == $i_month ? ' selected' : '');
                                    if ($i_month < 10) {
                                        $i_month = sprintf("%02d", $i_month);
                                    }
                                    echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                                }
                                echo '</select>'."\n";
                            ?>
                            <?php 
                                $year_start  = 1940;
                                $year_end = date('Y'); // current Year
                                $user_selected_year = 1992; // user date of birth year

                                echo '<select id="start_year" name="start_year">'."\n";
                                for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                    $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                    echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                                }
                                echo '</select>'."\n";
                            ?>
                            <br>
                            <label for="end_date">End Date : </label>
                            <?php
                                $selected_month = date('m'); //current month

                                echo '<select id="end_month" name="end_month">'."\n";
                                for ($i_month = 1; $i_month <= 12; $i_month++) { 
                                    $selected = ($selected_month == $i_month ? ' selected' : '');
                                    if ($i_month < 10) {
                                        $i_month = sprintf("%02d", $i_month);
                                    }
                                    echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
                                }
                                echo '</select>'."\n";
                            ?>
                            <?php 
                                $year_start  = 1940;
                                $year_end = date('Y'); // current Year
                                $user_selected_year = 1992; // user date of birth year

                                echo '<select id="end_year" name="end_year">'."\n";
                                for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
                                    $selected = ($user_selected_year == $i_year ? ' selected' : '');
                                    echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
                                }
                                echo '</select>'."\n";
                            ?>
                            <br>
                            <br>
                            <button class="btn btn-primary" id="search">Search</button>
                            <br>
                            <br>
                            <!-- <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><label>Approved Timesheets</label></li>
                                <li class="tab-link" data-tab="tab-2"><label>Pending Timesheets</label></li>
                                <li class="tab-link" data-tab="tab-3"><label>Not Approved Timesheets</label></li>
                            </ul> -->

                            <!--<div class="box-body table-responsive no-padding">-->
                            <div id="tab-1" class="tab-content table-responsive">
                                <table class="table table-bordered table-striped" style="font-size: 12px;" id="a_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Code</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Type</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">ST</th>
                                        <th style="text-align: center;">OT</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Approved By</th>
                                        <th style="text-align: center;">User Type</th>
                                        <th style="text-align: center;">Consultant Invoice</th>
                                        <th style="text-align: center;">Vendor Invoice</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    // $start_date = "";
                                    // $end_date = "";
                                    // $cal_st = "";
                                    // $cal_ot = "";
                                    // $counter = 0;
                                    // $target_con_id = !empty($_GET['customid']) ? $_GET['customid'] : 0; // Custom ID

                                    // // if (!empty($target_con_id)) {
                                    // //     $test = $this->employee_model->getEmployeeData($target_con_id);
                                    // //     echo "<pre>" . print_r($test, 1) . "</pre>";
                                    // // }

                                    // if (!empty($get_approved_timesheet_details)) {
                                    //     foreach ($get_approved_timesheet_details as $tvalue) {
                                    //         if (!empty($target_con_id) && $tvalue['employee_id'] != $target_con_id) {
                                    //             continue;
                                    //         }

                                    //         $counter++;
                                    //         if (empty($target_con_id) && $counter > 250) {
                                    //             break;
                                    //         }

                                    //         $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);
                                    //         $get_employee_data = $this->employee_model->getEmployeeData($tvalue['employee_id']);

                                    //         $get_pr_invoice = $this->employee_model->getPrInvoice($tvalue['id']);
                                    //         $get_vn_invoice = $this->employee_model->getVnInvoice($tvalue['id']);

                                    //         if ($tvalue['approved_by'] != '') {
                                    //             if ($tvalue['approved_by'] == 'superadmin') {
                                    //                 $get_approved_by_details = $this->employee_model->getSuperAdminData($tvalue['approved_by_id']);
                                    //                 if (!empty($get_approved_by_details)) {
                                    //                     $approved_by = ucwords($get_approved_by_details[0]['sa_name']);
                                    //                 }
                                    //             } elseif ($tvalue['approved_by'] == 'admin') {
                                    //                 $get_approved_by_details = $this->employee_model->getAdminData($tvalue['approved_by_id']);
                                    //                 if (!empty($get_approved_by_details)) {
                                    //                     $approved_by = ucwords($get_approved_by_details[0]['first_name'] . " " . $get_approved_by_details[0]['last_name']);
                                    //                 }
                                    //             }

                                    //         } else {
                                    //             $approved_by = "";
                                    //         }

                                    //         $cal_st = $this->employee_model->getTotalST($tvalue['id']);
                                    //         $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);

                                    //         $period_arr = explode("~", $tvalue['period']);
                                    //         $start_date = date("m-d-Y", strtotime($period_arr[0]));
                                    //         $ed = (isset($period_arr[1]) ) ? $period_arr[1] : "" ;
                                    //         $end_date = date("m-d-Y", strtotime($ed));
                                            ?>
                                            <!-- <tr>
                                                <td>
                                                    <a href="<?php //echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($tvalue['id']); ?>"><?php// echo $tvalue['timesheet_id']; ?></a>
                                                </td>
                                                <td><?php //echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php //echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['employee_code']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name']; ?></td>
                                                <td>
                                                    <?php
                                                    //if ($get_employee_data[0]['employee_type'] == 'C') {
                                                     //   echo "Consultant";
                                                    //} elseif ($get_employee_data[0]['employee_type'] == 'E') {
                                                    //    echo "Employee";
                                                    //}
                                                    ?>
                                                </td>
                                                <td><?php //echo $start_date; ?></td>
                                                <td><?php //echo $end_date; ?></td>
                                                <td><?php //echo number_format($cal_st[0]['tot_time'], 2); ?></td>
                                                <td><?php //echo number_format($cal_ot[0]['over_time'], 2); ?></td>
                                                <td>
                                                    <span style="color: green;">Approved</span>
                                                </td>
                                                <td>
                                                    <?php //echo $approved_by; ?>
                                                </td>
                                                <td><?php //echo ucwords($tvalue['approved_by']); ?></td>
                                                <td> -->
                                                    <?php
                                                    //if(!empty($get_pr_invoice)){
                                                        ?>
                                                        <!-- <a class="tbl_icon fancybox"
                                                           href="<?php //echo base_url('sa_invoice_pdf/' . base64_encode($get_pr_invoice[0]['id'])); ?>"
                                                           data-toggle="tooltip" title="Download PDF"><i
                                                                class="fa fa-eye"
                                                                aria-hidden="true" style="color: #09274b;"></i></a> -->
                                                        <?php
                                                    // } else {
                                                    //     echo "";
                                                    // }
                                                    ?>
                                                <!-- </td>
                                                <td> -->
                                                    <?php
                                                    //if(!empty($get_vn_invoice)){
                                                        ?>
                                                        <!-- <a class="tbl_icon fancybox"
                                                           href="<?php //echo base_url('superadmin_invoice_pdf/' . base64_encode($get_vn_invoice[0]['id'])); ?>"
                                                           data-toggle="tooltip" title="Download PDF"><i
                                                                class="fa fa-eye"
                                                                aria-hidden="true" style="color: #09274b;"></i></a> -->
                                                        <?php
                                                    // } else {
                                                    //     echo "";
                                                    // }
                                                    ?>
                                                <!-- </td>
                                            </tr> -->
                                            <?php
                                    //     }
                                    // }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tab-2" class="tab-content table-responsive">
                                <table class="table table-bordered table-striped" style="font-size: 12px;" id="p_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Code</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Type</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">ST</th>
                                        <th style="text-align: center;">OT</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // $p_start_date = "";
                                    // $p_end_date = "";
                                    // $p_cal_st = "";
                                    // $p_cal_ot = "";
                                    // if (!empty($get_pending_timesheet_details)) {
                                    //     foreach ($get_pending_timesheet_details as $penvalue) {

                                    //         $get_project_data = $this->employee_model->getProjectData($penvalue['project_id']);
                                    //         $get_employee_data = $this->employee_model->getEmployeeData($penvalue['employee_id']);

                                    //         $p_cal_st = $this->employee_model->getTotalST($penvalue['id']);
                                    //         $p_cal_ot = $this->employee_model->getTotalOT($penvalue['id']);

                                    //         $period_arr = explode("~", $penvalue['period']);
                                    //         $p_start_date = date("m-d-Y", strtotime($period_arr[0]));
                                    //         $p_ed = (isset($period_arr[1]) ) ?  $period_arr[1] : '';
                                    //         $p_end_date = date("m-d-Y", strtotime($p_ed));
                                            ?>
                                            <!-- <tr>
                                                <td>
                                                    <a href="<?php //echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($penvalue['id']); ?>"><?php//echo $penvalue['timesheet_id']; ?></a>
                                                </td>
                                                <td><?php //echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php //echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['employee_code']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name']; ?></td>
                                                <td>
                                                    <?php
                                                    // if ($get_employee_data[0]['employee_type'] == 'C') {
                                                    //     echo "Consultant";
                                                    // } elseif ($get_employee_data[0]['employee_type'] == 'E') {
                                                    //     echo "Employee";
                                                    // }
                                                    ?>
                                                </td>
                                                <td><?php //echo $p_start_date; ?></td>
                                                <td><?php //echo $p_end_date; ?></td>
                                                <td><?php //echo number_format($p_cal_st[0]['tot_time'], 2); ?></td>
                                                <td><?php //echo number_format($p_cal_ot[0]['over_time'], 2); ?></td>
                                                <td>
                                                    <span style="color: #f39c12;">Pending Approval</span>
                                                </td>
                                            </tr> -->
                                            <?php
                                    //     }
                                    // }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tab-3" class="tab-content table-responsive">
                                <table class="table table-bordered table-striped" style="font-size: 12px;" id="n_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Code</th>
                                        <th style="text-align: center;">Name</th>
                                        <th style="text-align: center;">Type</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">ST</th>
                                        <th style="text-align: center;">OT</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Disapprove By</th>
                                        <th style="text-align: center;">User Type</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    // $n_start_date = "";
                                    // $n_end_date = "";
                                    // $n_cal_st = "";
                                    // $n_cal_ot = "";
                                    // if (!empty($get_not_approved_timesheet_details)) {
                                    //     foreach ($get_not_approved_timesheet_details as $nvalue) {

                                    //         $get_project_data = $this->employee_model->getProjectData($nvalue['project_id']);
                                    //         $get_employee_data = $this->employee_model->getEmployeeData($nvalue['employee_id']);

                                    //         if ($nvalue['approved_by'] != '') {
                                    //             if ($nvalue['approved_by'] == 'superadmin') {
                                    //                 $get_approved_by_details = $this->employee_model->getSuperAdminData($nvalue['approved_by_id']);
                                    //                 if (!empty($get_approved_by_details)) {
                                    //                     $approved_by = ucwords($get_approved_by_details[0]['sa_name']);
                                    //                 }
                                    //             } elseif ($nvalue['approved_by'] == 'admin') {
                                    //                 $get_approved_by_details = $this->employee_model->getAdminData($nvalue['approved_by_id']);
                                    //                 if (!empty($get_approved_by_details)) {
                                    //                     $approved_by = ucwords($get_approved_by_details[0]['first_name'] . " " . $get_approved_by_details[0]['last_name']);
                                    //                 }
                                    //             }

                                    //         } else {
                                    //             $approved_by = "";
                                    //         }

                                    //         $n_cal_st = $this->employee_model->getTotalST($nvalue['id']);
                                    //         $n_cal_ot = $this->employee_model->getTotalOT($nvalue['id']);

                                    //         $period_arr = explode("~", $nvalue['period']);
                                    //         $n_start_date = date("m-d-Y", strtotime($period_arr[0]));
                                    //         $n_ed = (isset($period_arr[1]) ) ? $period_arr[1] : "" ;
                                    //         $n_end_date = date("m-d-Y", strtotime($n_ed));
                                            ?>
                                            <!-- <tr>
                                                <td>
                                                    <a href="<?php //echo base_url() . "sadmin-view-period-timesheet/" . base64_encode($nvalue['id']); ?>"><?php //echo $nvalue['timesheet_id']; ?></a>
                                                </td>
                                                <td><?php //echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php //echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['employee_code']; ?></td>
                                                <td><?php //echo $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name']; ?></td>
                                                <td>
                                                    <?php
                                                    // if ($get_employee_data[0]['employee_type'] == 'C') {
                                                    //     echo "Consultant";
                                                    // } elseif ($get_employee_data[0]['employee_type'] == 'E') {
                                                    //     echo "Employee";
                                                    // }
                                                    ?>
                                                </td>
                                                <td><?php //echo $n_start_date; ?></td>
                                                <td><?php// echo $n_end_date; ?></td>
                                                <td><?php //echo number_format($n_cal_st[0]['tot_time'], 2); ?></td>
                                                <td><?php //echo number_format($n_cal_ot[0]['over_time'], 2); ?></td>
                                                <td>
                                                    <span style="color: #f31c02;">Not Approved</span>
                                                </td>
                                                <td>
                                                    <?php//echo $approved_by; ?>
                                                </td>
                                                <td><?php //echo ucwords($nvalue['approved_by']); ?></td>
                                            </tr> -->
                                            <?php
                                    //     }
                                    // }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
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

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
<script>

    $(function () {

        // $('#a_timesheet_tbl').DataTable({
        //     "order": [[ 6, "desc" ]]
        // });

        // $('#p_timesheet_tbl').DataTable({
        //     "order": [[ 6, "desc" ]]
        // });

        // $('#n_timesheet_tbl').DataTable({
        //     "order": [[ 6, "desc" ]]
        // });

    });
</script>
<script>
    $(function () {
        $("#start_date").datepicker({
            format: 'mm/dd/yyyy'
        });
        $("#end_date").datepicker({
            format: 'mm/dd/yyyy'
        });
    });
</script>
<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })
    $(document).ready(function () {

        $('ul.tabs li').click(function () {
            // var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            // $('.tab-content').removeClass('current');

            $(this).addClass('current');
            // $("#" + tab_id).addClass('current');
        });


        $(document).on('click', '#search', function() {
            
            var status = $('#status').val();
            var employee_id = $('#select_employee').val();
            var start_month = $('#start_month').val();
            var start_year = $('#start_year').val();
            var end_month = $('#end_month').val();
            var end_year = $('#end_year').val();

            $('#overlay').show();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('sadmin_get_consultant_approved_timesheet_data_all'); ?>",
                data: {status_val: status, employee_id_val : employee_id, start_month : start_month, start_year : start_year, end_month : end_month, end_year : end_year}, 
                dataType: "json",  
                cache:false,
                success: function(data){
                    if (status == 1) {
                        if ($.fn.DataTable.isDataTable('#a_timesheet_tbl')) {
                            
                            table = $('#a_timesheet_tbl').DataTable();
                        
                        }
                        else {
                        
                            table = $('#a_timesheet_tbl').DataTable({
                                        "order": [[ 6, "desc" ]]
                                    });
                        
                        }
                        
                        table.clear().draw();
                        // // $('#summary_table').html('');
                        $.each(data, function(key, val) {
                            var approved_by = '';
                            var cal_st = '';
                            var cal_ot = '';
                            var start_date = '';
                            var end_date = '';
                            var employee_type = '';
                            var pr_invoice_complete_anchor_string = '';
                            var vn_invoice_complete_anchor_string = '';

                            var url = '<?php echo base_url() . "sadmin-view-period-timesheet/"; ?>';

                            var complete_url = url+btoa(val.id);

                            var complete_anchor_string = "<a href='"+complete_url+"'>"+val.timesheet_id+"</a>";

                            var approved_string = "<span style='color: green;'>Approved</span>";

                            if (val.pr_invoice) {

                                var pr_invoice_url = '<?php echo base_url() . "sa_invoice_pdf/"; ?>';

                                var pr_invoice_complete_url = pr_invoice_url+btoa(val.pr_invoice);

                                pr_invoice_complete_anchor_string = "<a class='tbl_icon fancybox' href='"+pr_invoice_complete_url+"' data-toggle='tooltip' title='Download PDF'><i class='fa fa-eye' aria-hidden='true' style='color: #09274b;'></i></a>";
                            
                            }

                            if (val.vn_invoice) {

                                var vn_invoice_url = '<?php echo base_url() . "superadmin_invoice_pdf/"; ?>';

                                var vn_invoice_complete_url = vn_invoice_url+btoa(val.vn_invoice);

                                vn_invoice_complete_anchor_string = "<a class='tbl_icon fancybox' href='"+vn_invoice_complete_url+"' data-toggle='tooltip' title='Download PDF'><i class='fa fa-eye' aria-hidden='true' style='color: #09274b;'></i></a>";
                            }
                            

                            if (val.approved_by != '') {
                                if (val.approved_by == 'superadmin') {
                                    
                                    if (val.sa_name) {
                                        approved_by = val.sa_name;
                                    }
                                } else if (val.approved_by == 'admin') {
                                    
                                    if (val.first_name) {
                                        approved_by = val.first_name + " " + val.last_name;
                                    }
                                }

                            } else {
                                approved_by = "";
                            }

                            cal_st = val.tot_time;
                            cal_ot = val.over_time;

                            if (cal_st == null) {
                                cal_st = '0.00';
                            }
                            if (cal_ot == null) {
                                cal_ot = '0.00';
                            }

                            var period_arr = val.period.split("~");
                            
                            if (period_arr[0] != 'NaN/NaN/NaN' && period_arr[0] != '0' && typeof period_arr[0] !== "undefined") {
                                start_date = new Date(period_arr[0]);
                            
                                start_date = ((start_date.getMonth() > 8) ? (start_date.getMonth() + 1) : ('0' + (start_date.getMonth() + 1))) + '-' + ((start_date.getDate() > 9) ? start_date.getDate() : ('0' + start_date.getDate())) + '-' + start_date.getFullYear();
                            }
                            else {
                                start_date = '01-01-1970';
                            }
                            
                            if (period_arr[1] != 'NaN/NaN/NaN' && period_arr[1] != '0' && typeof period_arr[1] !== "undefined") {
                                var ed = period_arr[1] ? period_arr[1] : "" ;
                                end_date = new Date(ed);
                                
                                end_date = ((end_date.getMonth() > 8) ? (end_date.getMonth() + 1) : ('0' + (end_date.getMonth() + 1))) + '-' + ((end_date.getDate() > 9) ? end_date.getDate() : ('0' + end_date.getDate())) + '-' + end_date.getFullYear();
                            }
                            else {
                                end_date = '01-01-1970';
                            }

                            if (val.employee_type == 'C') {
                                employee_type = "Consultant";
                            } else if (val.employee_type == 'E') {
                                employee_type = "Employee";
                            }

                            table.row.add( [
                                complete_anchor_string,
                                val.project_code,
                                val.project_name,
                                val.employee_code,
                                val.employee_first_name+" "+val.employee_last_name,
                                employee_type,
                                start_date,
                                end_date,
                                cal_st,
                                cal_ot,
                                approved_string,
                                approved_by,
                                val.approved_by,
                                pr_invoice_complete_anchor_string,
                                vn_invoice_complete_anchor_string
                            ] ).draw( false );

                        });
                        
                        table.columns.adjust().draw();
                        $('#tab-2').hide();
                        $('#tab-3').hide();
                        $('#tab-1').show();
                        $('#overlay').hide();
                    }
                    if (status == 2) {
                        if ($.fn.DataTable.isDataTable('#p_timesheet_tbl')) {
                        
                            table = $('#p_timesheet_tbl').DataTable();
                        
                        }
                        else {
                            table = $('#p_timesheet_tbl').DataTable({
                                        "order": [[ 6, "desc" ]]
                                    });
                        }

                        table.clear().draw();
                        
                        $.each(data, function(key, val) {
                            var cal_st = '';
                            var cal_ot = '';
                            var start_date = '';
                            var end_date = '';
                            var employee_type = '';
                            var url = '<?php echo base_url() . "sadmin-view-period-timesheet/"; ?>';

                            var complete_url = url+btoa(val.id);

                            var complete_anchor_string = "<a href='"+complete_url+"'>"+val.timesheet_id+"</a>";

                            var pending_approval_string = "<span style='color: #f39c12;'>Pending Approval</span>";

                            cal_st = val.tot_time;
                            cal_ot = val.over_time;

                            if (cal_st == null) {
                                cal_st = '0.00';
                            }
                            if (cal_ot == null) {
                                cal_ot = '0.00';
                            }

                            var period_arr = val.period.split("~");

                            // console.log(period_arr[1]);
                            // console.log(typeof period_arr[1]);

                            if (period_arr[0] != 'NaN/NaN/NaN' && period_arr[0] != '0' && typeof period_arr[0] !== "undefined") {
                                start_date = new Date(period_arr[0]);
                                
                                start_date = ((start_date.getMonth() > 8) ? (start_date.getMonth() + 1) : ('0' + (start_date.getMonth() + 1))) + '-' + ((start_date.getDate() > 9) ? start_date.getDate() : ('0' + start_date.getDate())) + '-' + start_date.getFullYear();
                            }
                            else {
                                start_date = '01-01-1970';
                            }
                            
                            if (period_arr[1] != 'NaN/NaN/NaN' && period_arr[1] != '0' && typeof period_arr[1] !== "undefined") {
                                var ed = period_arr[1] ? period_arr[1] : "" ;
                                end_date = new Date(ed);
                                
                                end_date = ((end_date.getMonth() > 8) ? (end_date.getMonth() + 1) : ('0' + (end_date.getMonth() + 1))) + '-' + ((end_date.getDate() > 9) ? end_date.getDate() : ('0' + end_date.getDate())) + '-' + end_date.getFullYear();
                            }
                            else {
                                end_date = '01-01-1970';
                            }

                            if (val.employee_type == 'C') {
                                employee_type = "Consultant";
                            } else if (val.employee_type == 'E') {
                                employee_type = "Employee";
                            }

                            table.row.add( [
                                complete_anchor_string,
                                val.project_code,
                                val.project_name,
                                val.employee_code,
                                val.employee_first_name+" "+val.employee_last_name,
                                employee_type,
                                start_date,
                                end_date,
                                cal_st,
                                cal_ot,
                                pending_approval_string
                            ] ).draw( false );

                        });
                        
                        table.columns.adjust().draw();
                        $('#tab-1').hide();
                        $('#tab-3').hide();
                        $('#tab-2').show();
                        $('#overlay').hide();
                    }
                    if (status == 0) {
                        if ($.fn.DataTable.isDataTable('#n_timesheet_tbl')) {
                            
                            table = $('#n_timesheet_tbl').DataTable();
                        
                        }
                        else {

                            table = $('#n_timesheet_tbl').DataTable({
                                    "order": [[ 6, "desc" ]]
                                });
                        }

                        table.clear().draw();
                        // // $('#summary_table').html('');
                        $.each(data, function(key, val) {
                            var approved_by = '';
                            var cal_st = '';
                            var cal_ot = '';
                            var start_date = '';
                            var end_date = '';
                            var employee_type = '';
                            var url = '<?php echo base_url() . "sadmin-view-period-timesheet/"; ?>';

                            var complete_url = url+btoa(val.id);

                            var complete_anchor_string = "<a href='"+complete_url+"'>"+val.timesheet_id+"</a>";

                            var not_approved_string = "<span style='color: #f31c02;'>Not Approved</span>";

                            if (val.approved_by != '') {
                                if (val.approved_by == 'superadmin') {
                                    
                                    if (val.sa_name) {
                                        approved_by = val.sa_name;
                                    }
                                } else if (val.approved_by == 'admin') {
                                    
                                    if (val.first_name) {
                                        approved_by = val.first_name + " " + val.last_name;
                                    }
                                }

                            } else {
                                approved_by = "";
                            }

                            cal_st = val.tot_time;
                            cal_ot = val.over_time;

                            if (cal_st == null) {
                                cal_st = '0.00';
                            }
                            if (cal_ot == null) {
                                cal_ot = '0.00';
                            }

                            var period_arr = val.period.split("~");
                            
                            if (period_arr[0] != 'NaN/NaN/NaN' && period_arr[0] != '0' && typeof period_arr[0] !== "undefined") {
                                start_date = new Date(period_arr[0]);
                            
                                start_date = ((start_date.getMonth() > 8) ? (start_date.getMonth() + 1) : ('0' + (start_date.getMonth() + 1))) + '-' + ((start_date.getDate() > 9) ? start_date.getDate() : ('0' + start_date.getDate())) + '-' + start_date.getFullYear();
                            }
                            else {
                                start_date = '01-01-1970';
                            }
                            
                            if (period_arr[1] != 'NaN/NaN/NaN' && period_arr[1] != '0' && typeof period_arr[1] !== "undefined") {
                                var ed = period_arr[1] ? period_arr[1] : "" ;
                                end_date = new Date(ed);
                                
                                end_date = ((end_date.getMonth() > 8) ? (end_date.getMonth() + 1) : ('0' + (end_date.getMonth() + 1))) + '-' + ((end_date.getDate() > 9) ? end_date.getDate() : ('0' + end_date.getDate())) + '-' + end_date.getFullYear();
                            }
                            else {
                                end_date = '01-01-1970';
                            }

                            if (val.employee_type == 'C') {
                                employee_type = "Consultant";
                            } else if (val.employee_type == 'E') {
                                employee_type = "Employee";
                            }

                            table.row.add( [
                                complete_anchor_string,
                                val.project_code,
                                val.project_name,
                                val.employee_code,
                                val.employee_first_name+" "+val.employee_last_name,
                                employee_type,
                                start_date,
                                end_date,
                                cal_st,
                                cal_ot,
                                not_approved_string,
                                approved_by,
                                val.approved_by
                            ] ).draw( false );

                        });
                        
                        table.columns.adjust().draw();
                        $('#tab-1').hide();
                        $('#tab-2').hide();
                        $('#tab-3').show();
                        $('#overlay').hide();
                    }
                }
            });
            // console.log("approved");
        });

    })
</script>

<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>