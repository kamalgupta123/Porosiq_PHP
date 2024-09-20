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
                <li class="active">Employee Lists</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div
                    class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div
                    class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                <?php } ?>
            <div class="alert alert-success succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" style="display: none;">error</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add-superadmin-employee-user'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Add Employee User</a>&nbsp;&nbsp;
                                <a href="<?php echo base_url('assign-projects-to-superadmin-employee'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Assign Project To Employees</a>&nbsp;&nbsp;

                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="">
                                <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Admin Name</th>
                                            <th>Client Name</th>
                                            <th>Photo</th>
                                            <th>Employee Code</th>
                                            <th>Employee Name</th>
                                            <th>Employee Email</th>
                                            <?php if (LATAM) { ?>
                                                <th>Employee Type</th>
                                            <?php } ?>
                                            <th>Employee Designation</th>
                                            <th>Employee Classification</th>
                                            <th>Employee Category</th>
                                            <!--<th>Address</th>-->
                                            <th>Phone No.</th>
                                            <!--<th>Date of Joining</th>-->
                                            <th>Resume</th>
                                            <!--<th>Bill Rate</th>-->
                                            <!--<th>Pay Rate</th>-->
                                            <th>Employee Documents</th>
                                            <th>Timesheet (Detailed View)</th>
                                            <th>Timesheet (Quick View)</th>
                                            <!--<th>Generate Invoice</th>
                                            <th>Work Order</th>-->
                                            <th>Generate Login Detail</th>
                                            <th>Onboarding</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($get_employee_details) > 0) {

                                            foreach ($get_employee_details as $aval) {

                                                $work_status = $this->employee_model->checkWorkOrderStatus($aval['employee_id']);
                                                $get_employee_login_details = $this->employee_model->getLoginDetails($aval['employee_id']);
                                                $check_generate_status = $this->employee_model->getGenerateStatus($aval['employee_id']);
                                                $get_admin_details = $this->employee_model->getAdminDetails($aval['admin_id']);
                                                $get_client_details = $this->employee_model->getClientData($aval['client_id']);
                                                $has_timesheet = $this->employee_model->checkTimesheet($aval['employee_id']);
                                                if (!empty($get_admin_details)) {
                                                    $admin_name = $get_admin_details[0]['name_prefix'] . " " . $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                }
                                                if (!empty($get_client_details)) {
                                                    $client_name = $get_client_details[0]['client_name'];
                                                }
//                                        print_r($check_generate_status);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $admin_name; ?></td>
                                                    <td><?php echo $client_name; ?></td>
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
                                                    <td><?php echo $aval['employee_code']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url('edit-superadmin-employee-user/' . base64_encode($aval['employee_id'])); ?>">
                                                            <?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_employee_login_details)) {
                                                            echo $get_employee_login_details[0]['consultant_email'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <?php if (US || INDIA) { ?>
                                                        <td><?php echo $aval['employee_designation']; ?></td>
                                                    <?php } ?>
                                                    <td>
                                                    <?php if (LATAM) { ?>
                                                        <?php
                                                        if ($aval['is_temp_emp']) {
                                                        
                                                            echo "Temporary";

                                                        } else {
                                                            echo "Permanent";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $aval['employee_designation']; ?></td>
                                                    <td 
                                                    <?php if (show_classifications($aval['temp_classification'], false) == 'ESA') { ?>
                                                    translate="no"
                                                    <?php } ?>>
                                                    <?php } ?>
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
                                                    </td>
                                                    <td>
                                                        <?php 

                                                            echo show_categories($aval['temp_category'], false);
                                                        ?>
                                                    </td>
                                                    <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                    <!--<td><label><?php //echo $aval['date_of_joining'];           ?></label></td>-->
                                                    <td>
                                                        <?php
                                                        if ($aval['resume_file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $aval['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i> </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <!--<td><label><?php //echo "$" . $aval['employee_bill_rate'];           ?></label></td>-->
                                                    <!--<td><label><?php //echo "$" . $aval['employee_pay_rate'];           ?></label></td>-->
                                                    <td>
                                                        <?php
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('view_superadmin_consultant_documents/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="View Documents" style="color: #09274B;"><i
                                                                    class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                            ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('view-superadmin-employee-timesheet/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="View Detailed Timesheet" style="color: #09274B;"><i
                                                                    class="fa fa-calendar" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                            ?>
                                                    </td>
                                                    <td>
                                                        <a class="tbl_icon" href="<?php echo base_url('emp-timesheet?customid=').$aval['employee_id']; ?>"data-toggle="tooltip" title="View Quick Timesheet" style="color: green;"><i
                                                                    class="fa fa-calendar" aria-hidden="true"></i></a>
                                                    </td>
                                                    <?php
                                                    /* <td>
                                                      <?php
                                                      if ($has_timesheet[0]['cnt'] > 0) {
                                                      ?>
                                                      <a class="tbl_icon"
                                                      href="<?php echo base_url('sa-generate-invoice/' . base64_encode($aval['employee_id'])); ?>"
                                                      data-toggle="tooltip" title="Generate Invoice" style="color: #09274B;"><i
                                                      class="fa fa-credit-card" aria-hidden="true"></i></a>
                                                      <?php
                                                      } else {
                                                      ?>
                                                      <label style="color: red;">Employee need to first add Timesheet.</label>
                                                      <?php
                                                      }
                                                      ?>
                                                      </td>

                                                      <td>
                                                      <?php
                                                      if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {

                                                      if (!empty($work_status)) {

                                                      if ($work_status[0]['approved_by_admin'] == '1') {
                                                      ?>
                                                      <a class="tbl_icon fancybox"
                                                      href="<?php echo base_url('view_superadmin_employees_work_order_pdf/' . base64_encode($aval['employee_id'])); ?>"
                                                      data-toggle="tooltip" title="Download PDF" style="color: red;"><i
                                                      class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                                      <?php
                                                      }
                                                      }

                                                      if (empty($work_status)) {
                                                      ?>
                                                      <a class="tbl_icon"
                                                      href="<?php echo base_url('add-superadmin-employee-work_order/' . base64_encode($aval['employee_id'])); ?>"
                                                      data-toggle="tooltip" title="Add Work Order" style="color: green;"><i
                                                      class="fa fa-plus-circle"
                                                      aria-hidden="true"></i></a>
                                                      <?php
                                                      }
                                                      }
                                                      ?>
                                                      </td>
                                                      <?php
                                                     */
                                                    ?>
                                                    <td>
                                                        <?php
                                                        //                                                        if ($aval['status'] == '1') {
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '0') {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('generate-superadmin-employee-login-details/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="Generate Login Details"><i
                                                                    class="fa fa-refresh" aria-hidden="true"></i></a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                                                            <?php
                                                        }
                                                        //                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $check_generate_status = $this->employee_model->checkGenerateStatus($aval['employee_id']);
//                                                        if (!empty($get_employee_login_details)) {
//                                                            if ($get_employee_login_details[0]['status'] == '1') {
//                                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                        ?>
                                                        <a class="tbl_icon"
                                                           href="<?php echo base_url('superadmin_employee_onboarding/' . base64_encode($aval['employee_id'])); ?>"
                                                           data-toggle="tooltip" title="Onboarding"><img src="<?php echo base_url(); ?>assets/images/onboarding.png" style="width: 25px;"></a>
                                                           <?php
//                                                                   }
//                                                               }
//                                                           }
                                                           ?>
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
                    <?php if($super_admin_email !='aurica@procuretechstaff.com') {?>                                    
                                                        <a class="tbl_icon"
                                                           href="<?php echo base_url('edit-superadmin-employee-user/' . base64_encode($aval['employee_id'])); ?>"
                                                           data-toggle="tooltip" title="Edit "><i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="#<?php echo $aval['employee_id']; ?>" data-toggle="modal" title="View Profile">
                                                            <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUser('<?php echo base64_encode($aval['employee_id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
                                                        <?php
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {

                                                            if ($get_employee_login_details[0]['block_status'] == '0') {
                                                                ?>
                                                                <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                                   title="Unblock" onclick="changeBlockStatus('unblock', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                        class="fa fa-lock" aria-hidden="true"></i></a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                                   title="Block" onclick="changeBlockStatus('block', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                        class="fa fa-unlock" aria-hidden="true" style="color: green;"></i></a>
                                                                    <?php
                                                                }

                                                                if ($get_employee_login_details[0]['status'] == '1') {
                                                                    ?>
                                                                <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                                   title="Deactive" onclick="changeStatus('deactivate', '<?php echo base64_encode($aval['employee_id']); ?>');"><i class="fa fa-check" aria-hidden="true" style="color: green;"></i></a>
                                                                   <?php
                                                               } else {
                                                                   ?>
                                                                <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                                   title="Active" onclick="changeStatus('activate', '<?php echo base64_encode($aval['employee_id']); ?>');">
                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <!-- Employee Details -->
                                                        <div class="modal fade" id="<?php echo $aval['employee_id']; ?>"
                                                             role="dialog">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="box box-primary">
                                                                            <div class="box-body box-profile">
                                                                                <?php
                                                                                if ($aval['file'] != '') {
                                                                                    ?>
                                                                                    <img src="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>" alt="User Image" class="profile-user-img img-responsive img-circle">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                    <img alt="User Image" src="<?php echo base_url(); ?>assets/images/blank-profile.png" class="profile-user-img img-responsive img-circle">
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                                <h3 class="profile-username text-center"><?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?></h3>

                                                                                <div class="row">
                                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                        <table id="vendor_tbl" class="table table-bordered table-striped table-responsive" style="font-size: 11px;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td><label>Employee Code</label></td>
                                                                                                    <td><?php echo $aval['employee_code']; ?></td>
                                                                                                    <td><label>Employee Classification</label></td>
                                                                                                    <?php if (US || INDIA) { ?>
                                                                                                        <td>
                                                                                                    <?php } ?>
                                                                                                    <?php if (LATAM) { ?>
                                                                                                        <td 
                                                                                                        <?php if (show_classifications($aval['temp_classification'], false) == 'ESA') { ?>
                                                                                                        translate="no"
                                                                                                        <?php } ?>>
                                                                                                    <?php } ?>
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
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label>Employee Designation</label></td>
                                                                                                    <td><?php echo $aval['employee_designation']; ?></td>
                                                                                                    <td><label>Employee Category</label></td>
                                                                                                    <td>
                                                            <?php 

                                                                echo show_categories($aval['temp_category'], false);
                                                            ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label>Phone No.</label></td>
                                                                                                    <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                                                                    <td><label>Fax No.</label></td>
                                                                                                    <td><?php echo ($aval['fax_no'] != '0') ? $aval['fax_no'] : ''; ?></td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label>Address</label></td>
                                                                                                    <td><?php echo stripslashes($aval['address']); ?></td>
                                                                                                    <td>&nbsp;</td>
                                                                                                    <td>&nbsp;</td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                    <td><label>Bill Rate</label></td>
                                                                                                    <td><?php echo "$" . number_format($aval['employee_bill_rate'], 2); ?></td>
                                                                                                    <td><label>Bill Rate Type</label></td>
                                                                                                    <td><?php echo $aval['emp_bill_rate_type']; ?></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                                if ($aval['emp_bill_rate_type'] == 'yearly') {
                                                                                                    $bill_rate = ($aval['employee_bill_rate'] / 2080);
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><label>Bill Rate</label></td>
                                                                                                        <td><?php echo "$" . number_format($bill_rate, 2); ?></td>
                                                                                                        <td><label>Bill Rate Type</label></td>
                                                                                                        <td><?php echo "hourly"; ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                                <tr>
                                                                                                    <td><label>Pay Rate</label></td>
                                                                                                    <td><?php echo "$" . number_format($aval['employee_pay_rate'], 2); ?></td>
                                                                                                    <td><label>Pay Rate Type</label></td>
                                                                                                    <td><?php echo $aval['emp_pay_rate_type']; ?></td>
                                                                                                </tr>
                                                                                                <?php
                                                                                                if ($aval['emp_pay_rate_type'] == 'yearly') {
                                                                                                    $pay_rate = ($aval['employee_pay_rate'] / 2080);
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><label>Pay Rate</label></td>
                                                                                                        <td><?php echo "$" . number_format($pay_rate, 2); ?></td>
                                                                                                        <td><label>Pay Rate Type</label></td>
                                                                                                        <td><?php echo "hourly"; ?></td>
                                                                                                    </tr>
                                                                                                <?php } ?>
                                                                                                <tr>
                                                                                                    <td><label>Date of Joining</label></td>
                                                                                                    <td><?php echo ($aval['date_of_joining'] != '0000-00-00') ? date("m-d-Y",strtotime($aval['date_of_joining'])) : ""; ?></td>
                                                                                                    <td>&nbsp;</td>
                                                                                                    <td>&nbsp;</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                            <!-- /.box-body -->
                                                                        </div>
                                                                        <!-- /.box -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                     <?php } else{
                        echo"<strong>Access Denied</strong>";

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
<?php if (US || INDIA) { ?>
<script>
    $(function () {
        $('#admin_tbl').DataTable({
            //scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
//            paging: false,

        });
    });
</script>
<?php } ?>
<?php if (LATAM) { ?>
    <script>
        $(function () {
            $('#admin_tbl').DataTable({
                dom:  "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                //scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                //paging: false,
                
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4, 5, 6, 7, 8 ,9, 10, 11, 18 ]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4, 5, 6, 7, 8 ,9, 10, 11, 18 ]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 4, 5, 6, 7, 8 ,9, 10, 11, 18 ]
                        }
                    }
                ]

            });
        });
    </script>
<?php } ?>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    function changeBlockStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'block') {
            var type = 'Block';
        } else if (bs_type == 'unblock') {
            var type = 'Unlock';
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
                    $.post("<?php echo site_url('change_employee_block_status'); ?>", {bs_type: bs_type, employee_id: employee_id}, function (data) {
                        //location.reload();
                        if (data == 1) {
                            var msg = 'Employee ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        } else
                        {
                            $(".succ-msg").hide();
                        }
                    });
                }
            }
        });



    }

    function changeStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'activate') {
            var type = 'Activate';
        } else if (bs_type == 'deactivate') {
            var type = 'Deactivate';
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
                    $.post("<?php echo site_url('change_employee_status'); ?>", {bs_type: bs_type, employee_id: employee_id}, function (data) {
                        if (data == 1) {
                            var msg = 'Employee ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        } else
                        {
                            $(".succ-msg").hide();
                        }

                    });
                }
            }
        });
    }

    function deleteUser(id) {
        var employee_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Employee User?",
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
                    $.post("<?php echo site_url('delete-employee-user'); ?>", {employee_id: employee_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Employee Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 0)
                        {
                            var msg = 'OOPS !! Something went wrong!';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 3)
                        {
                            var msg = 'OOPS !! A Project has already assigned to Employee.';
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