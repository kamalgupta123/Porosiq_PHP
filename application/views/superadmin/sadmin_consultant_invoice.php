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

    ul.tabs-emp {
        margin: 0px;
        padding: 0px;
        list-style: none;
    }

    ul.tabs-emp li {
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }

    ul.tabs-emp li.current {
        background: #09274b;
        color: #fff;

    }

    .tab-content-emp {
        display: none;
        background: #fff;
        padding: 15px 0px;
    }

    .tab-content-emp.current {
        display: inherit;
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
                Invoice
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Invoice</a></li>
                <li class="active">Invoice Lists</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

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
                    <div class="alert alert-danger err" style="display: none;">Invoice Not Approved.</div>
                    <div class="alert alert-success succ" style="display: none;">Invoice Approved Successfully.</div>
                    <div class="alert alert-danger succ-err" style="display: none;">&nbsp;</div>
                    <div class="alert alert-success succ-msg" style="display: none;">&nbsp;</div>
                    <div class="box">
                        <div class="box-body">
                            <h4>Consultant's Invoice</h4>
                            <hr/>
                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><label>Approved[Consultant]</label></li>
                                <li class="tab-link" data-tab="tab-2"><label>Not Approved[Consultant]</label></li>
                               
                            </ul>

                            <div id="tab-1" class="tab-content current">
                                <table id="pa_tbl" class="table table-bordered table-striped table-responsive"
                                       style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
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
                                        if (count($get_admin_invoice_details > 0)) {

                                            foreach ($get_admin_invoice_details as $aval) {

                                                $get_employee_details = $this->employee_model->getEmployeeData($aval['employee_id']);
                                                $get_timesheet_period_details = $this->employee_model->getTimesheetDetailsByID($aval['timesheet_period_id']);
                                                //print_r($get_employee_details);
                                                //echo $get_employee_details[0]['employee_name'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $aval['invoice_code']; ?></td>
                                                    <td><a href="<?php echo base_url() . "view-period-timesheet/" . base64_encode($aval['timesheet_period_id']); ?>" class="fancybox"><?php echo $get_timesheet_period_details[0]['timesheet_id']; ?></a></td>
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
                                                        echo ($aval['start_date'] != '0000-00-00') ? $aval['start_date'] : '';
                                                        echo " - ";
                                                        echo ($aval['end_date'] != '0000-00-00') ? $aval['end_date'] : '';
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
                                                        } elseif ($aval['status'] == '1') {
                                                            ?>
                                                            <label style="color:green;">Invoice Approved</label>
                                                            <?php
                                                        } elseif ($aval['status'] == '2') {
                                                            ?>
                                                            <label style="color:red;">Invoice Not Approved</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    <td>
                                                        <?php
                                                        if ($aval['status'] == '1' || $aval['status'] == '2') {
                                                            ?>
                                                            <a class="tbl_icon fancybox"
                                                               href="<?php echo base_url('sa_invoice_pdf/' . base64_encode($aval['id'])); ?>"
                                                               data-toggle="tooltip" title="Download PDF"><i
                                                                    class="fa fa-file-pdf-o"
                                                                    aria-hidden="true" style="color: green;"></i></a>
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
                            </div>
                            <div id="tab-2" class="tab-content">
                                <table id="not_apprv_tbl" class="table table-bordered table-striped table-responsive"
                                       style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
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
                                        if (count($get_admin_not_apprv_invoice_details > 0)) {

                                            foreach ($get_admin_not_apprv_invoice_details as $not_aval) {

                                                $get_employee_details = $this->employee_model->getEmployeeData($not_aval['employee_id']);
                                                $get_timesheet_period_details = $this->employee_model->getTimesheetDetailsByID($not_aval['timesheet_period_id']);
                                                //print_r($get_employee_details);
                                                //echo $get_employee_details[0]['employee_name'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $not_aval['invoice_code']; ?></td>
                                                    <td><a href="<?php echo base_url() . "view-period-timesheet/" . base64_encode($not_aval['timesheet_period_id']); ?>" class="fancybox"><?php echo $get_timesheet_period_details[0]['timesheet_id']; ?></a></td>
                                                    <td><?php echo $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?></td>
                                                    <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                    <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($not_aval['payment_type'] == '1') {
                                                            echo "Net 45";
                                                        } elseif ($not_aval['payment_type'] == '2') {
                                                            echo "Net 45";
                                                        } elseif ($not_aval['payment_type'] == '3') {
                                                            echo "Net 45";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        echo ($not_aval['start_date'] != '0000-00-00') ? $not_aval['start_date'] : '';
                                                        echo " - ";
                                                        echo ($not_aval['end_date'] != '0000-00-00') ? $not_aval['end_date'] : '';
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <div><strong>Standard Time
                                                                :</strong><br/> <?php echo $not_aval['tot_time'] . " hours"; ?>
                                                        </div>
                                                        <br/>

                                                        <div><strong>Over Time
                                                                :</strong><br/> <?php echo $not_aval['over_time'] . " hours"; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><strong>Standard Rate
                                                                :</strong><br/> <?php echo ($not_aval['bill_rate'] != '') ? "$" . number_format($not_aval['bill_rate'], 2) : "0.00"; ?>
                                                        </div>
                                                        <br/>

                                                        <div><strong>Over Time Rate
                                                                :</strong><br/> <?php echo ($not_aval['ot_rate'] != '') ? "$" . number_format($not_aval['ot_rate'], 2) : "0.00"; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div><strong>Standard Pay
                                                                :</strong><br/> <?php echo ($not_aval['tot_time_pay'] != '') ? "$" . number_format($not_aval['tot_time_pay'], 2) : "0.00"; ?>
                                                        </div>
                                                        <br/>

                                                        <div><strong>Over Time Pay
                                                                :</strong><br/> <?php echo ($not_aval['over_time_pay'] != '') ? "$" . number_format($not_aval['over_time_pay'], 2) : "0.00"; ?>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($not_aval['status'] == '0') {
                                                            ?>
                                                            <label style="color:#e08e0b;">Pending Approval</label>
                                                            <?php
                                                        } elseif ($not_aval['status'] == '1') {
                                                            ?>
                                                            <label style="color:green;">Invoice Approved</label>
                                                            <?php
                                                        } elseif ($not_aval['status'] == '2') {
                                                            ?>
                                                            <label style="color:red;">Invoice Not Approved</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    <td>
                                                        <?php
                                                        if ($not_aval['status'] == '1' || $not_aval['status'] == '2') {
                                                            ?>
                                                            <a class="tbl_icon fancybox"
                                                               href="<?php echo base_url('sa_invoice_pdf/' . base64_encode($not_aval['id'])); ?>"
                                                               data-toggle="tooltip" title="Download PDF"><i
                                                                    class="fa fa-file-pdf-o"
                                                                    aria-hidden="true" style="color: red;"></i></a>
                                                                <?php
                                                            }
                                                            ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteInvoice('<?php echo base64_encode($not_aval['id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
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
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>
    $(function () {
        $('#pa_tbl').DataTable();
        $('#not_apprv_tbl').DataTable();
        $('#va_tbl').DataTable();
        $('#van_tbl').DataTable();
        $('#emp_tbl').DataTable();
    });
    function getApprove(val) {
        var invoice_id = val;

        $.post("<?php echo site_url('approve_invoice'); ?>", {invoice_id: invoice_id}, function (data) {
            //alert(data);
            if (data == 1) {
                location.reload();
                $(".err").hide();
                $(".succ").show();
            } else {
                location.reload();
                $(".err").show();
                $(".succ").hide();
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

//        $('ul.tabs-emp li').click(function () {
//            var tab_id = $(this).attr('data-tab');
//
//            $('ul.tabs-emp li').removeClass('current');
//            $('.tab-content-emp').removeClass('current');
//
//            $(this).addClass('current');
//            $("#" + tab_id).addClass('current');
//        })

    })


    function deleteInvoice(id) {
        var invoice_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete Invoice?",
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
                    $.post("<?php echo site_url('delete-consultant-invoice'); ?>", {invoice_id: invoice_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Invoice Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == '0')
                        {
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

    function deleteVendorInvoice(id) {
        var invoice_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete Invoice?",
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
                    $.post("<?php echo site_url('delete-vendor-invoice'); ?>", {invoice_id: invoice_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Invoice Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == '0')
                        {
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

    function deleteEmpInvoice(id) {
        var invoice_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete Invoice?",
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
                    $.post("<?php echo site_url('delete-emp-invoice'); ?>", {invoice_id: invoice_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Invoice Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == '0')
                        {
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
