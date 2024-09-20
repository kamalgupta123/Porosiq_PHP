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
                <li class="active"><a href="">View Consultant Consultant</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: left;">
                                <div class="col-lg-6 col-sm-6 col-md-6" style="line-height: 1px;">
                                    <label>Project Code : </label>&nbsp;<?php echo $get_project_details[0]['project_code']; ?>
                                    <hr/>
                                    <label>Project Name : </label>&nbsp;<?php echo $get_project_details[0]['project_name']; ?>
                                    <hr/>
                                    <label>Client Name : </label>&nbsp;<?php echo $get_project_details[0]['client_name']; ?>
                                    <hr/>
                                    <label>Date
                                        : </label> &nbsp;<?php echo date("m-d-Y", strtotime($get_project_details[0]['start_date'])) . " - " . date("m-d-Y", strtotime($get_project_details[0]['end_date'])); ?>

                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <label>Project Details
                                        : </label>&nbsp;<span style="line-height: 15px;"><?php echo preg_replace("/\r|n/", "", strip_tags(stripslashes($get_project_details[0]['project_details']))); ?></span>
                                    <br/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Assigned Consultant Lists</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Photo</th>
                                            <th>Consultant Code</th>
                                            <th>Consultant Full Name</th>
                                            <th>Consultant Designation</th>
                                            <th>Consultant Category</th>
                                            <th>Address</th>
                                            <th>Phone No.</th>
                                            <th>Fax No.</th>
                                            <th>Date of Joining</th>
                                            <th>Resume</th>
                                            <th>Bill Rate</th>
                                            <th>Pay Rate</th>
                                            <th>Status</th>
                                            <th>Onboarding Status</th>
                                            <th>Generate Login Details</th>
                                            <th>Onboarding</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (!empty($get_employee_details)) {
//echo "<pre>";
//print_r($get_employee_details);
                                            foreach ($get_employee_details as $aval) {

                                                $get_emp_dtls = $this->employee_model->getEmployeeData($aval['employee_id']);
                                                $get_employee_login_details = $this->employee_model->getLoginDetails($aval['employee_id']);
                                                $get_work_order_details = $this->employee_model->getWorkOrder($aval['employee_id']);
//                                                echo "<pre>";
//                                                print_r($get_emp_dtls);
                                                ?>
                                                <tr style="text-align: center;">
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <div id="img_div" style="height:60px;width:60px;">

                                                            <?php
                                                            if ($get_emp_dtls[0]['file'] != '') {
                                                                ?>
                                                                <img
                                                                    src="<?php echo base_url(); ?>uploads/<?php echo $get_emp_dtls[0]['file']; ?>"
                                                                    alt="User Image"
                                                                    style="width: 100%; max-height: 100%; object-fit: contain;">
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                <img alt="User Image"
                                                                     src="<?php echo base_url(); ?>assets/images/blank-profile.png"
                                                                     style="width: 100%;max-height: 100%; object-fit: contain;">
                                                                     <?php
                                                                 }
                                                                 ?>
                                                        </div>
                                                    </td>
                                                    <td><label><?php echo $get_emp_dtls[0]['employee_code']; ?></label></td>
                                                    <td><label><?php echo $get_emp_dtls[0]['name_prefix'] . " " . $get_emp_dtls[0]['first_name'] . " " . $get_emp_dtls[0]['last_name']; ?></label></td>
                                                    <td><label><?php echo $get_emp_dtls[0]['employee_designation']; ?></label></td>
                                                    <td>
                                                        <label>
                                                            <?php
                                                            if ($get_emp_dtls[0]['employee_category'] == '1') {
                                                                echo "W2";
                                                            } elseif ($get_emp_dtls[0]['employee_category'] == '2') {
                                                                echo "Subcontractor";
                                                            }
                                                            ?>
                                                        </label>
                                                    </td>
                                                    <td><?php echo $get_emp_dtls[0]['address']; ?></td>
                                                    <td><?php echo ($get_emp_dtls[0]['phone_no'] != '0') ? $get_emp_dtls[0]['phone_no'] : ''; ?></td>
                                                    <td><?php echo ($get_emp_dtls[0]['fax_no'] != '0') ? $get_emp_dtls[0]['fax_no'] : ''; ?></td>
                                                    <td><label><?php echo date("m-d-Y", strtotime($get_emp_dtls[0]['date_of_joining'])); ?></label></td>
                                                    <td>
                                                        <?php
                                                        if ($get_emp_dtls[0]['resume_file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $get_emp_dtls[0]['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i> </a>
                                                            <?php
                                                        }
                                                        ?>
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
                                                            if ($get_emp_dtls[0]['v_employee_bill_rate'] != '') {
                                                                echo "$" . number_format($get_emp_dtls[0]['v_employee_bill_rate'], 2);
                                                            }
                                                            ?>
                                                        </label>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        if (!empty($get_employee_login_details)) {
                                                            if ($get_employee_login_details[0]['status'] == '0' || $get_employee_login_details[0]['block_status'] == '0') {
                                                                ?>
                                                                <label style="color: red;font-size: 10px;">Account Not Activated</label>
                                                                <?php
                                                            } elseif ($get_employee_login_details[0]['status'] == '1' || $get_employee_login_details[0]['block_status'] == '1') {
                                                                ?>
                                                                <label style="color: green;font-size: 10px;">Activated</label>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?php
                                                        if ($aval['status'] == '0') {
                                                            ?>
                                                            <label style="color: red;font-size: 10px;">Not Hired</label>
                                                            <?php
                                                        } elseif ($aval['status'] == '1') {
                                                            ?>
                                                            <label style="color: green;font-size: 10px;">Hired</label>
                                                            <?php
                                                        } elseif ($aval['status'] == '2') {
                                                            ?>
                                                            <label style="color: #f39c12;font-size: 10px;">Pending Approval</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $check_generate_status = $this->employee_model->checkGenerateStatus($aval['employee_id']);
//                                                    print_r($check_generate_status);
                                                        //if ($get_employee_login_details[0]['status'] == '1') {
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '0') {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('generate_consultant_login_details/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="Generate Login Details"><i
                                                                    class="fa fa-refresh" aria-hidden="true"></i></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                                                            <?php
                                                        }
                                                        //}
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($aval['status'] == '1') {
                                                            if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                                ?>
                                                                <a class="tbl_icon"
                                                                   href="<?php echo base_url('consultant_onboarding/' . base64_encode($aval['employee_id'])); ?>"
                                                                   data-toggle="tooltip" title="Onboarding"><img src="<?php echo base_url(); ?>assets/images/onboarding.png" style="width: 25px;"></a>
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
        $('#admin_tbl').DataTable();
    });
</script>