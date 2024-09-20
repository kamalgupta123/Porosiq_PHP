<?php
$this->load->view('vendor/includes/header');
?>

<style>
    .dataTables_filter {
        display: none !important;
    }

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
                <li class="active"><a href="">Invoice Management</a></li>
            </ol>
        </section>

        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">

                        <div class="box" style="margin-top: 30px;">

                            <div class="panel panel-default">
                                <div class="panel-heading"><strong>Search :</strong></div>
                                <div class="panel-body">
                                    <form id="search_form" action="<?php echo site_url('search_vendor_payment'); ?>"
                                          method="post"
                                          enctype="multipart/form-data">
                                        <table width="100%" class="table table-bordered table-striped"
                                               style="font-size: 10px;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label>Employee Code</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="search_by_emp_code" id="search_by_emp_code"
                                                           class="form-control"
                                                           placeholder="Search by Employee Code"
                                                           value="<?php
                                                           if (isset($search_by_emp_code) && $search_by_emp_code != '') {
                                                               echo $search_by_emp_code;
                                                           }
                                                           ?>">
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                            if (isset($search_by_payment_mode) && $search_by_payment_mode == '1') {
                                                ?>
                                                <tr id="t_weekly">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date" id="start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php
                                                               if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo date("m-d-Y", strtotime($search_by_start_date));
                                                               }
                                                               ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php
                                                               if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo date("m-d-Y", strtotime($search_by_end_date));
//                                                                       echo ;
                                                               }
                                                               ?>">
                                                    </td>
                                                </tr>

                                                <?php
                                            } else {
                                                ?>
                                                <tr id="t_weekly" style="display: none;">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date" id="start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php
                                                               if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo date("m-d-Y", strtotime($search_by_start_date));
                                                               }
                                                               ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php
                                                               if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo date("m-d-Y", strtotime($search_by_end_date));
                                                               }
                                                               ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (isset($search_by_payment_mode) && $search_by_payment_mode == '2') {
                                                ?>
                                                <tr id="t_monthly">
                                                    <td>
                                                        <label>Month</label>
                                                    </td>
                                                    <td>
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
                                                        <select name="search_by_month" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($month_arr as $mkey => $mval) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $mkey; ?>" <?php if (isset($search_by_month) && $mkey == $search_by_month) { ?> selected <?php } ?>><?php echo $mval; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><label>Year</label></td>
                                                    <td>
                                                        <select name="search_by_year" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            for ($j = 1990; $j <= 2200; $j++) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $j; ?>" <?php if (isset($search_by_year) && $j == $search_by_year) { ?> selected <?php } ?>><?php echo $j; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <tr id="t_monthly" style="display: none;">
                                                    <td>
                                                        <label>Month</label>
                                                    </td>
                                                    <td>
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
                                                        <select name="search_by_month" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($month_arr as $mkey => $mval) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $mkey; ?>" <?php if (isset($search_by_month) && $mkey == $search_by_month) { ?> selected <?php } ?>><?php echo $mval; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><label>Year</label></td>
                                                    <td>
                                                        <select name="search_by_year" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            for ($j = 1990; $j <= 2200; $j++) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $j; ?>" <?php if (isset($search_by_year) && $j == $search_by_year) { ?> selected <?php } ?>><?php echo $j; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (isset($search_by_payment_mode) && $search_by_payment_mode == '3') {
                                                ?>
                                                <tr id="t_daily">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date"
                                                               id="daily_start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php
                                                               if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo $search_by_start_date;
                                                               }
                                                               ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="daily_end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php
                                                               if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo $search_by_end_date;
                                                               }
                                                               ?>">
                                                    </td>
                                                </tr>

                                                <?php
                                            } else {
                                                ?>
                                                <tr id="t_daily" style="display: none;">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date"
                                                               id="daily_start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php
                                                               if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo $search_by_start_date;
                                                               }
                                                               ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="daily_end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php
                                                               if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo $search_by_end_date;
                                                               }
                                                               ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr>
                                                <td colspan="6" align="right">

                                                    <input class="btn btn-success" type="submit" name="submit"
                                                           value="Search">
                                                    <a href="<?php echo site_url('vendor_employee_payment'); ?>"
                                                       class="btn btn-warning">Show All</a>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </form>
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
                            <div class="box-header">
                                <h3 class="box-title">Payment Management</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="admin_tbl" class="table table-bordered table-striped"
                                       style="font-size: 11px;">
                                    <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Invoice ID</th>
                                        <th>Timesheet ID</th>
                                        <th>Consultant Name</th>
                                        <th>Consultant Code</th>
                                        <th>Consultant Designation</th>
                                        <th>Payment Mode</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Rate</th>
                                        <th>Pay</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_payment_details) > 0) {

                                        foreach ($get_payment_details as $aval) {

                                            $get_employee_details = $this->employee_model->getEmployeeData($aval['employee_id']);
                                            $get_timesheet_period_details = $this->employee_model->getTimesheetDetailsByID($aval['timesheet_period_id']);
                                            $get_invoice_details = $this->employee_model->getInvoiceCodeByID($aval['timesheet_period_id'], $aval['vendor_id']);
                                            if (!empty($get_invoice_details)) {
                                                $inv_code = $get_invoice_details[0]['invoice_code'];
                                            } else {
                                                $inv_code = "";
                                            }

                                            $check_invoice = $this->employee_model->checkInvoice($aval['employee_id'], $aval['payment_type']);

                                            $cur_date = strtotime(date("Y-m-d h:i:s"));
                                            $updated_date = strtotime("+30 days", strtotime($aval['updated_date']));

                                            $current_date = new DateTime(date("Y-m-d h:i:s"));
                                            $due_date = new DateTime(date("Y-m-d", strtotime("+30 days", strtotime($aval['updated_date']))));
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <?php echo $inv_code; ?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo base_url() . "vcon-view-period-timesheet/" . base64_encode($aval['timesheet_period_id']); ?>"
                                                       class="fancybox"><?php echo $get_timesheet_period_details[0]['timesheet_id']; ?></a>
                                                </td>
                                                <td><?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?></td>
                                                <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($aval['payment_type'] == '1') {
                                                        echo "Net 45";
                                                    } elseif ($aval['payment_type'] == '2') {
                                                        echo "Net 45";
                                                    } elseif ($aval['payment_type'] == '3') {
                                                        echo "Net 45";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo ($aval['start_date'] != '0000-00-00') ? date("m-d-Y", strtotime($aval['start_date'])) : '';
                                                    echo " - ";
                                                    echo ($aval['end_date'] != '0000-00-00') ? date("m-d-Y", strtotime($aval['end_date'])) : '';
                                                    ?>
                                                </td>

                                                <td>
                                                    <div><strong>Standard Time
                                                            :</strong><br/> <?php echo $aval['tot_time'] . " hours"; ?>
                                                    </div>
                                                    <br/>

                                                    <div><strong>Over Time
                                                            :</strong><br/> <?php echo $aval['over_time'] . " hours"; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><strong>Standard Rate
                                                            :</strong><br/> <?php echo ($aval['bill_rate'] != '') ? "$" . number_format($aval['bill_rate'], 2) : "0.00"; ?>
                                                    </div>
                                                    <br/>

                                                    <div><strong>Over Time Rate
                                                            :</strong><br/> <?php echo ($aval['ot_rate'] != '') ? "$" . number_format($aval['ot_rate'], 2) : "0.00"; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div><strong>Standard Pay
                                                            :</strong><br/> <?php echo ($aval['tot_time_pay'] != '') ? "$" . number_format($aval['tot_time_pay'], 2) : "0.00"; ?>
                                                    </div>
                                                    <br/>

                                                    <div><strong>Over Time Pay
                                                            :</strong><br/> <?php echo ($aval['over_time_pay'] != '') ? "$" . number_format($aval['over_time_pay'], 2) : "0.00"; ?>
                                                    </div>

                                                </td>
                                                <td>
                                                    <?php
                                                    if ($aval['status'] == '0') {
                                                        ?>
                                                        <label style="color:#e08e0b;">Pending Approval</label>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <label style="color:green;">Invoice Approved</label>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($aval['status'] != '0') {
                                                        ?>
                                                        <a class="tbl_icon fancybox"
                                                           href="<?php echo base_url('vendor_invoice_pdf/' . base64_encode($aval['id'])); ?>"
                                                           data-toggle="tooltip" title="Download PDF" target="_blank"><i
                                                                class="fa fa-file-pdf-o"
                                                                aria-hidden="true" style="color:red;"></i></a>
                                                        <?php
                                                        if ($current_date > $due_date) {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('vendor_payment_comments/' . base64_encode($aval['id'])); ?>"
                                                               data-toggle="tooltip" title="Comments"><i
                                                                    class="fa fa-comments"
                                                                    aria-hidden="true" style="color:#3c8dc8;"></i></a>
                                                            <?php
                                                        }
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
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
$this->load->view('vendor/includes/common_footer');
?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
?>

<script>

    $(function () {
        $('#admin_tbl').DataTable();
    });

    $(function () {
        $('#start_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
        $('#end_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
        $('#daily_start_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
        $('#daily_end_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
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
            $("#t_daily").show();
            $("#t_monthly").hide();
        } else {
            $("#t_weekly").hide();
            $("#t_monthly").hide();
            $("#t_daily").hide();
        }
    }


</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    $(function () {
        $("#search_by_emp_code").autocomplete({
            minLength: 3,
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('search_by_emp_code'); ?>",
                    dataType: "json",
                    data: request,
                    success: function (data) {
                        if (data.response == 'true') {
                            response(data.message);
                        }
                    }
                });
            }
        });
    });

</script>