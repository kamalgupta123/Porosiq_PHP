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
                <li class="active"><a href="">Consultant List</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <?php
                    //                            echo '<pre>';
                    //                            print_r($get_admin_details);
                    ?>
                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add_vendor_consultant'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Consultant</a>
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
                            <h3 class="box-title">Consultant Lists</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                <thead>
                                    <tr style="text-align: center;">
                                        <th width="5%">SL No.</th>
                                        <th>Photo</th>
                                        <th>Consultant Code</th>
                                        <th>Consultant Full Name</th>
                                        <th>Consultant Email</th>
                                        <th>Consultant Designation</th>
                                        <th>Consultant Classification</th>
                                        <th>Consultant Category</th>
                                        <th>Address</th>
                                        <th>Phone No.</th>
                                        <th>Date of Joining</th>
                                        <th>Resume</th>
                                        <th>Work Order</th>
                                        <th>Bill Rate</th>
                                        <th>Pay Rate</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_employee_details) > 0) {

                                        foreach ($get_employee_details as $aval) {

                                            $vendor_arr = $this->employee_model->getVendorName($aval['vendor_id']);
                                            $check_work = $this->employee_model->checkWorkOrder($aval['employee_id']);
                                            $get_work_order_details = $this->employee_model->getWorkOrder($aval['employee_id']);
                                            $work_status = $this->employee_model->checkWorkOrderStatus($aval['employee_id']);
                                            $get_employee_login_details = $this->employee_model->getLoginDetails($aval['employee_id']);
                                            $final_approved_work_order = $this->employee_model->final_approved_work_order($aval['employee_id']);
                                            
                                            ?>
                                            <tr style="text-align: center;">
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <div id="img_div" style="height:60px;width:60px;">

                                                        <?php
                                                        if ($aval['file'] != '') {
                                                            ?>
                                                            <img
                                                                src="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>"
                                                                alt="User Image" class="img-circle"
                                                                style="width: 100%; max-height: 100%; object-fit: contain;">
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <img alt="User Image" class="img-circle"
                                                                 src="<?php echo base_url(); ?>assets/images/blank-profile.png"
                                                                 style="width: 100%;max-height: 100%; object-fit: contain;">
                                                                 <?php
                                                             }
                                                             ?>
                                                    </div>
                                                </td>
                                                <td><label><?php echo $aval['employee_code']; ?></label></td>
                                                <td><label><?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?></label></td>
                                                <td>
                                                    <?php
                                                    if (!empty($get_employee_login_details)) {
                                                        echo $get_employee_login_details[0]['consultant_email'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><label><?php echo $aval['employee_designation']; ?></label></td>
                                                <td>
                                                    <label>
                                                    <?php
                                                        if (empty($aval['temp_classification'])) {
                                                            if ($aval['employee_category'] == '1') {
                                                                echo "W2";
                                                            } elseif ($aval['employee_category'] == '2') {
                                                                echo "Subcontractor";
                                                            }
                                                        } else {
                                                            echo show_classifications($aval['temp_classification'], false);
                                                        }
                                                    ?>  
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                    <?php 

                                                    echo show_categories($aval['temp_category'], false);
                                                    ?>
                                                    </label>
                                                </td>
                                                <td><?php echo $aval['address']; ?></td>
                                                <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                <td><label><?php echo date("m-d-Y", strtotime($aval['date_of_joining']));; ?></label></td>
                                                <td>
                                                    <?php
                                                    if ($aval['resume_file'] != '') {
                                                        ?>
                                                        <a href="<?php echo base_url(); ?>uploads/<?php echo $aval['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i> </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if (DEMO) { ?>
                                                    <?php
                                                    if (!empty($work_status)) {
                                                            if (empty($final_approved_work_order)) {
                                                                if ($work_status[0]['approved_by_superadmin'] == '1') {
                                                                ?>
                                                                   <a class="tbl_icon"
                                                                       href="<?php echo base_url('edit_vendor_consultant_work_order/' . base64_encode($aval['employee_id'])); ?>"
                                                                       data-toggle="tooltip" title="Sign Work Order"><i
                                                                       class="fa fa-pencil"
                                                                       aria-hidden="true" style="color: #09274B;"></i></a> 

                                                                <?php
                                                                }

                                                             } else { ?>

                                                                <a href="<?php echo base_url(); ?>uploads/historical_work_order/<?php echo $final_approved_work_order[0]['file']; ?>"
                                                                class="fancybox" data-toggle="tooltip" title="View Work Order"
                                                                ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #09274B; font-size: 20px;"></i></a>
                                                            <?
                                                            }
                                                        }
                                                        ?>
                                                    </a>
                                                    <?php } ?>
                                                    <?php if (INDIA || US) { ?>
                                                        <?php
                                                            if (!empty($work_status)) {
                                                                    if (empty($final_approved_work_order)) {
                                                                        if (!empty($work_status[0]['approved_by_superadmin'])) {
                                                                        ?>
                                                                        <a class="tbl_icon"
                                                                            href="<?php echo base_url('edit_vendor_consultant_work_order/' . base64_encode($aval['employee_id'])); ?>"
                                                                            data-toggle="tooltip" title="Sign Work Order"><i
                                                                            class="fa fa-pencil"
                                                                            aria-hidden="true" style="color: #09274B;"></i></a> 

                                                                        <?php
                                                                        }

                                                                    } else { ?>

                                                                        <a href="<?php echo base_url(); ?>uploads/historical_work_order/<?php echo $final_approved_work_order[0]['file']; ?>"
                                                                        class="fancybox" data-toggle="tooltip" title="View Work Order"
                                                                        ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #09274B; font-size: 20px;"></i></a>
                                                                    <?
                                                                    }
                                                                }
                                                                ?>
                                                            </a>
                                                    <?php } ?>
                                                    <?php if (LATAM) { ?>
                                                        <?php
                                                            if (!empty($work_status)) {
                                                                if ($work_status[0]['approved_by_admin'] == '1') {
                                                                    if (empty($final_approved_work_order)) {
                                                                    ?>
                                                                    <a class="tbl_icon fancybox"
                                                                    href="<?php echo base_url('view_consultant_work_order_pdf/' . base64_encode($aval['employee_id'])); ?>"
                                                                    data-toggle="tooltip" title="Download PDF" target="_blank"><i
                                                                            class="fa fa-file-pdf-o" aria-hidden="true" style="color: #09274B;"></i></a>
                                                                            
                                                                    <?php } else { ?>

                                                                        <a href="<?php echo base_url(); ?>uploads/historical_work_order/<?php echo $final_approved_work_order[0]['file']; ?>"
                                                                        class="fancybox" data-toggle="tooltip" title="View Work Order"
                                                                        ><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: #09274B; font-size: 20px;"></i></a>
                                                                        <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                <?php
                                                                if ($check_work[0]['cnt'] > 0) {
                                                                    if (!empty($work_status)) {
                                                                        if ($work_status[0]['approved_by_superadmin'] == '1' && $work_status[0]['approved_by_admin'] == '0') {
                                                                            ?>
                                                                        <a class="tbl_icon"
                                                                        href="<?php echo base_url('edit_vendor_consultant_work_order/' . base64_encode($aval['employee_id'])); ?>"
                                                                        data-toggle="tooltip" title="Edit Work Order"><i
                                                                                class="fa fa-pencil-square-o"
                                                                                aria-hidden="true" style="color: #09274B;"></i></a>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                ?>

                                                            </a>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if (!empty($get_work_order_details)) {
                                                            echo "$" . $get_work_order_details[0]['bill_rate'];
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if ($aval['v_employee_bill_rate'] != '') {
                                                            echo "$" . number_format($aval['v_employee_bill_rate'], 2);
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?php
                                                    if (!empty($get_employee_login_details)) {
                                                        if ($get_employee_login_details[0]['status'] == '0' || $get_employee_login_details[0]['block_status'] == '0') {
                                                            ?>
                                                            <label style="color: red;font-size: 10px;"><i class="fa fa-cross" aria-hidden="true" style="color: red;"></i>Account Not Activated</label>
                                                            <?php
                                                        } elseif ($get_employee_login_details[0]['status'] == '1' || $get_employee_login_details[0]['block_status'] == '1') {
                                                            ?>
                                                            <label style="color: green;font-size: 10px;"><i class="fa fa-check" aria-hidden="true" style="color: green;"></i>Activated</label>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('edit_vendor_consultant/' . base64_encode($aval['employee_id'])); ?>"
                                                       data-toggle="tooltip" title="Edit "><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i></a>
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
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    function changeBlockStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'block') {
            var type = 'Unblock';
        } else if (bs_type == 'unblock') {
            var type = 'Block';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Employee User?",
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
                    $.post("<?php echo site_url('change_vendor_employee_block_status'); ?>", {
                        bs_type: bs_type,
                        employee_id: employee_id
                    }, function (data) {
                        location.reload();

                    });
                }
            }
        });


    }

    function changeStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'activate') {
            var type = 'Deactivate';
        } else if (bs_type == 'deactivate') {
            var type = 'Activate';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Employee User?",
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
                    $.post("<?php echo site_url('change_vendor_employee_status'); ?>", {
                        bs_type: bs_type,
                        employee_id: employee_id
                    }, function (data) {
                        //alert(data);
                        location.reload();

                    });
                }
            }
        });


    }
</script>