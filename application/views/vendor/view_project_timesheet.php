<?php
$this->load->view('vendor/includes/header');
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

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <?php
            $this->load->view('vendor/includes/upper_menu');
            ?>
        </nav>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!--                <h1>-->
            <!--                    User Profile-->
            <!--                </h1>-->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Timesheet</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: left;line-height: 1px;font-size: 12px;">
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <label>Employee Name
                                        : </label><?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?>
                                    <hr/>
                                    <label>Employee Designation
                                        : </label><?php echo $get_employee_details[0]['employee_designation']; ?>
                                    <hr/>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <label>Requirement Code : </label><?php echo $get_project_details[0]['project_code']; ?>
                                    <hr/>
                                    <label>Requirement Name : </label><?php echo $get_project_details[0]['project_name']; ?>
                                    <hr/>
                                    <label>Requirement Details
                                        : </label><span style="line-height: 15px;"><?php echo stripslashes($get_project_details[0]['project_details']); ?></span>
                                    <hr/>
                                    <label>Client Name : </label><?php echo $get_project_details[0]['client_name']; ?>
                                    <hr/>
                                    <label>Date : </label> 
                                    <?php
                                    echo date("m-d-Y", strtotime($get_project_details[0]['start_date'])) . " - ";

                                    if (($get_project_details[0]['end_date']) != '0000-00-00') {
                                        echo date("m-d-Y", strtotime($get_project_details[0]['end_date']));
                                    } else {
                                        echo "N/A";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($this->session->flashdata('error_msg')) { ?>
                        <div
                            class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                        <div
                            class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                        <?php } ?>

                    <div class="box">

                        <form id="timesheet_table"
                              action="<?php echo site_url('approve_disapprove_timesheet'); ?>"
                              method="post" enctype="multipart/form-data">

                            <div class="box-header">&nbsp;</div>
                            <!-- /.box-header -->
                            <div class="box-body tab-div">

                                <table class="table table-bordered table-striped tbl-checked" style="font-size: 11px;" width="100%">
                                    <thead style="background-color: #4e4e4e;color: #fff;text-align: center;">
                                        <tr>
                                            <th style="text-align: center;">SL No.</th>
                                            <th style="text-align: center; width: 35%;">Comment</th>
                                            <th style="text-align: center;">Day</th>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">Start Time</th>
                                            <th style="text-align: center;">End Time</th>
                                            <th style="text-align: center; width: 10%;">Total Time (Hours)</th>
                                            <th style="text-align: center; width: 10%;">Over Time (Hours)</th>
                                            <th style="text-align: center; width: 15%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $times = array();
                                        $otimes = array();
                                        if (!empty($get_timesheet_data)) {
                                            foreach ($get_timesheet_data as $tval) {
                                                $times[] = $tval['tot_time'];
                                                $otimes[] = $tval['over_time'];

                                                $n_start_time = date("g:i a", strtotime($tval['start_time']));
                                                $n_end_time = date("g:i a", strtotime($tval['end_time']));
                                                ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo $i; ?></td>
                                                    <td><?php echo stripcslashes($tval['comment']); ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo date("l", strtotime($tval['project_date'])); ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo date("m-d-Y", strtotime($tval['project_date'])); ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_start_time); ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo strtoupper($n_end_time); ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo $tval['tot_time']; ?></td>
                                                    <td style="text-align: center; font-weight: bold;"><?php echo $tval['over_time']; ?></td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        if ($tval['approved_by_admin'] == '0') {
                                                            ?>
                                                            <label style="color: red;"><i class="fa fa-times" aria-hidden="true" style="color: red;"></i> Not Approve</label>
                                                            <?php
                                                        } elseif ($tval['approved_by_admin'] == '1') {
                                                            ?>
                                                            <label style="color: green;"><i class="fa fa-check" aria-hidden="true" style="color: green;"></i> Approved</label>
                                                            <?php
                                                        } elseif ($tval['approved_by_admin'] == '2') {
                                                            ?>
                                                            <label style="color: #f39c12;"><i class="fa fa-clock-o" aria-hidden="true" style="color: #f39c12;"></i> Pending Approval</label>
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
                                            <td style="text-align: center; font-weight: bold; width: 65%;" colspan="6">Total Working Time</td>
                                            <td style="text-align: center; font-weight: bold; width:10%;">
                                                <?php
                                                $hours = "";
                                                $minutes = "";
                                                foreach ($times as $time) {
                                                    //echo $time;
                                                    $t_arr = explode(' ', $time);
                                                    $minutes += $t_arr[0] * 60;
                                                    //$minutes += $minute;
                                                }

                                                $hours = floor($minutes / 60);
                                                //$minutes -= $hours * 60;
                                                ?>
                                                <label>
                                                    <?php echo $hours; ?> Hours
                                                </label>
                                            </td>
                                            <td style="text-align: center; font-weight: bold; width:10%;">
                                                <?php
                                                $ohours = "";
                                                $ominutes = "";
                                                foreach ($otimes as $otime) {
                                                    $o_arr = explode(' ', $otime);
                                                    $ominutes += $o_arr[0] * 60;
                                                    //$ominutes += $ominute;
                                                }

                                                $ohours = floor($ominutes / 60);
                                                //$ominutes -= $ohours * 60;
                                                ?>
                                                <label>
                                                    <?php echo $ohours; ?> Hours
                                                </label>
                                            </td>
                                            <td width="15%">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.box-body -->

                            <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                            <input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">

                        </form>

                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row (main row) -->
            <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('vendor/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
?>
