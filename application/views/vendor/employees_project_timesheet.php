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

    .dataTables_filter {
        display: none;
    }

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
                <li class="active"><a href="">View Consultant Timesheets</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <?php if ($this->session->flashdata('error_msg')) { ?>
                        <div
                            class="alert alert-danger succ-err"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('succ_msg')) { ?>
                        <div
                            class="alert alert-success succ-msg"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                    <?php } ?>

                    <div class="alert alert-success succ-msg" style="display: none;"></div>
                    <div class="alert alert-danger succ-err" style="display: none;"></div>

                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: center;">
                                <?php
                                if (!empty($get_employee_details)) {
                                    echo strtoupper($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Consultant Timesheets</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body tab-div">
                            <?php
                            /*
                              <form id="add_employee_form" action="<?php echo site_url('search-sa-con-timesheet'); ?>" method="post" enctype="multipart/form-data">
                              <table class="table table-bordered table-striped" style="font-size: 14px;">
                              <tbody>
                              <tr>
                              <td width="8%"><label>Period</label></td>
                              <td width="10%">
                              <?php
                              $start_date = date("Y-m-d", strtotime("-14 days"));
                              ?>
                              <input type="text" id="start_date" name="start_date" value="<?php echo date("m/d/Y", strtotime($start_date)); ?>">
                              </td>
                              <td width="8%">To</td>
                              <td width="10%">
                              <?php
                              $end_date = date("Y-m-d", strtotime("+3 month"));
                              ?>
                              <input type="text" id="end_date" name="end_date" value="<?php echo date("m/d/Y", strtotime($end_date)); ?>">
                              </td>
                              <td width="20%" align="right">
                              <input class="btn btn-success" type="submit" name="submit" value="Filter">
                              <a href="<?php echo base_url() . 'view-superadmin-con-timesheet/' . base64_encode($get_employee_details[0]['employee_id']); ?>" class="btn btn-success">All</a>
                              </td>
                              </tr>
                              </tbody>
                              </table>
                              <input type="hidden" name="employee_id" value="<?php echo $get_employee_details[0]['employee_id']; ?>">
                              </form>
                             */
                            ?>

                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><label>Approved Timesheets</label></li>
                                <li class="tab-link" data-tab="tab-2"><label>Pending Timesheets</label></li>
                                <li class="tab-link" data-tab="tab-3"><label>Not Approved Timesheets</label></li>
                            </ul>

                            <!--<div class="box-body table-responsive no-padding">-->
                            <div id="tab-1" class="tab-content current">
                                <table class="table table-bordered table-striped" style="font-size: 12px;"
                                       id="a_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">Total Time</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;">Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $start_date = "";
                                    $end_date = "";
                                    $st = "";
                                    $ot = "";
                                    if (!empty($get_timesheet_details)) {
                                        foreach ($get_timesheet_details as $tkey => $tvalue) {

                                            $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);

                                            $check_gen_invoice = $this->employee_model->checkGenInvoice($tvalue['id']);

                                            $cal_st = $this->employee_model->getTotalST($tvalue['id']);
                                            $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);

                                            $period_arr = explode("~", $tvalue['period']);
                                            $start_date = date("m-d-Y", strtotime($period_arr[0]));
                                            $end_date = date("m-d-Y", strtotime($period_arr[1]));
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url() . "vcon-view-period-timesheet/" . base64_encode($tvalue['id']); ?>"
                                                       class="fancybox"><?php echo $tvalue['timesheet_id']; ?></a></td>
                                                <td><?php echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php echo $start_date; ?></td>
                                                <td><?php echo $end_date; ?></td>
                                                <td>
                                                    <?php
                                                    $tot_time = $cal_ot[0]['over_time'] + $cal_st[0]['tot_time'];
                                                    echo number_format($tot_time, 2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <span style="color: green;">Approved</span>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($check_gen_invoice)) {
                                                        if ($check_gen_invoice[0]['cnt'] > 0) {
                                                            ?>
                                                            <span style="color: green;">Invoice Generated</span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a class="tbl_icon" href="javascript:void(0)"
                                                               data-toggle="tooltip"
                                                               title="INVOICE"
                                                               onclick="generateVendorInvoice('<?php echo $tvalue['id']; ?>');">
                                                                <i class="fa fa-credit-card" aria-hidden="true"
                                                                   style="color: #00a7d0;"></i>
                                                            </a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)"
                                                           data-toggle="tooltip"
                                                           title="INVOICE"
                                                           onclick="generateVendorInvoice('<?php echo $tvalue['id']; ?>');">
                                                            <i class="fa fa-credit-card" aria-hidden="true"
                                                               style="color: #00a7d0;"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tab-2" class="tab-content">
                                <table class="table table-bordered table-striped" style="font-size: 12px;"
                                       id="p_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">Total Time</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $p_start_date = "";
                                    $p_end_date = "";
                                    //                                        $st = "";
                                    //                                        $ot = "";
                                    if (!empty($get_timesheet_details_pending)) {
                                        foreach ($get_timesheet_details_pending as $pkey => $pvalue) {

                                            $get_project_data = $this->employee_model->getProjectData($pvalue['project_id']);

                                            $p_cal_st = $this->employee_model->getTotalST($pvalue['id']);
                                            $p_cal_ot = $this->employee_model->getTotalOT($pvalue['id']);

                                            $period_arr = explode("~", $pvalue['period']);
                                            $p_start_date = date("m-d-Y", strtotime($period_arr[0]));
                                            $p_end_date = date("m-d-Y", strtotime($period_arr[1]));
                                            ?>
                                            <tr>
                                                <td>
<!--                                                    <a href="--><?php //echo base_url() . "vcon-view-period-timesheet/" . base64_encode($pvalue['id']); ?><!--"-->
<!--                                                       class="fancybox">-->
                                                        <?php echo $pvalue['timesheet_id']; ?>
<!--                                                    </a>-->
                                                </td>
                                                <td><?php echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php echo $p_start_date; ?></td>
                                                <td><?php echo $p_end_date; ?></td>
                                                <td>
                                                    <?php
                                                    $tot_time = $p_cal_ot[0]['over_time'] + $p_cal_st[0]['tot_time'];
                                                    echo number_format($tot_time, 2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <span style="color: #f39c12;">Pending Approval</span>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="tab-3" class="tab-content">
                                <table class="table table-bordered table-striped" style="font-size: 12px;"
                                       id="n_timesheet_tbl">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">Timesheet ID</th>
                                        <th style="text-align: center;">Project Code</th>
                                        <th style="text-align: center;">Project Name</th>
                                        <th style="text-align: center;">Start Date</th>
                                        <th style="text-align: center;">End Date</th>
                                        <th style="text-align: center;">Total Time</th>
                                        <th style="text-align: center;">Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">&nbsp;</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php
                                    $n_start_date = "";
                                    $n_end_date = "";
                                    //                                        $st = "";
                                    //                                        $ot = "";
                                    if (!empty($get_timesheet_details_nt_approved)) {
                                        foreach ($get_timesheet_details_nt_approved as $nkey => $nvalue) {

                                            $get_project_data = $this->employee_model->getProjectData($nvalue['project_id']);

                                            $n_cal_st = $this->employee_model->getTotalST($nvalue['id']);
                                            $n_cal_ot = $this->employee_model->getTotalOT($nvalue['id']);

                                            $period_arr = explode("~", $nvalue['period']);
                                            $n_start_date = date("m-d-Y", strtotime($period_arr[0]));
                                            $n_end_date = date("m-d-Y", strtotime($period_arr[1]));
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="<?php echo base_url() . "vcon-view-period-timesheet/" . base64_encode($nvalue['id']); ?>"
                                                       class="fancybox"><?php echo $nvalue['timesheet_id']; ?></a></td>
                                                <td><?php echo $get_project_data[0]['project_code']; ?></td>
                                                <td><?php echo $get_project_data[0]['project_name']; ?></td>
                                                <td><?php echo $n_start_date; ?></td>
                                                <td><?php echo $n_end_date; ?></td>
                                                <td>
                                                    <?php
                                                    $tot_time = $n_cal_ot[0]['over_time'] + $n_cal_st[0]['tot_time'];
                                                    echo number_format($tot_time, 2);
                                                    ?>
                                                </td>
                                                <td>
                                                    <span style="color: #f31c02;">Not Approved</span>
                                                </td>

                                            </tr>
                                            <?php
                                        }
                                    }
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
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    $(function () {

        $('#a_timesheet_tbl tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        $('#a_timesheet_tbl').DataTable();

        $('#a_timesheet_tbl').DataTable().columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#p_timesheet_tbl tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        $('#p_timesheet_tbl').DataTable();

        $('#p_timesheet_tbl').DataTable().columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#n_timesheet_tbl tfoot th').each(function () {
            var title = $(this).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" />');
        });

        $('#n_timesheet_tbl').DataTable();

        $('#n_timesheet_tbl').DataTable().columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
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

    function generateVendorInvoice(id) {
        var t_id = id;

        bootbox.confirm({
            message: "Do You Want To Generate The Consultant Invoice?",
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
                if (result == true) {
                    $.post("<?php echo site_url('generate_con_invoice_by_vendor'); ?>", {t_id: t_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Consultant Invoice Has Generated Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            var msg = 'OOPS !! Something went wrong!';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                    });
                }
            }
        });
    }
</script>
<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })
    $(document).ready(function () {

        $('ul.tabs li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        })

    });

</script>
