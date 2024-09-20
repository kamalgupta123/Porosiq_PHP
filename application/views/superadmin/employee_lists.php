<?php $this->load->view('superadmin/includes/header'); ?>

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

    label {
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
            <?php $this->load->view('superadmin/includes/upper_menu'); ?>
        </nav>
    </header>
    
    <!-- Left side column contains the logo and sidebar -->
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
                Consultant <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Consultant</a></li>
                <li class="active">Consultant Lists</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger"> 
                    <?php echo $this->session->flashdata('error_msg'); ?> 
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div class="alert alert-success"> 
                    <?php echo $this->session->flashdata('succ_msg'); ?> 
                </div>
            <?php } ?>

            <div class="alert alert-success succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" style="display: none;">error</div>

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box" style="margin-top: 30px;">
                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add-consultant'); ?>" 
                                style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Consultant</a>
                                &nbsp;&nbsp;
                                <a href="<?php echo base_url('assign-projects-to-superadmin-consultant');?>" 
                                style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Assign Project To Consultant</a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <table id="admin_tbl" 
                                    class="table table-bordered table-striped" 
                                    style="font-size: 11px;" width="100%">
                                <thead>
                                <tr>
                                    <th width="1%">SL No.</th>
                                    <th>Admin Name</th>
                                    <th>Company Name</th>
                                    <th>Photo</th>
                                    <th>Consultant Code</th>
                                    <th>Consultant Name</th>
                                    <th>Consultant Email</th>
                                    <th>Consultant Designation</th>
                                    <th>Consultant Classification</th>
                                    <th>Consultant Category</th>
                                    <th>Phone No.</th>
                                    <th>Resume</th>
                                    <th>Timesheet (Detailed View)</th>
                                    <th>Timesheet (Quick View)</th>
                                    <th>Work Order</th>
                                    <th>Consultant Documents</th>
                                    <th>Generate Login Detail</th>
                                    <?php if (US || INDIA) { ?>
                                        <th>Blocked Work Orders</th>
                                    <?php } ?>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            <?php if (US || INDIA) { ?>
                                <tbody>
                                <?php
                                $i = 1;
                                if (count($get_employee_details) > 0) {

                                    foreach ($get_employee_details as $aval) {
                                        $admin_arr = $this->employee_model->getAdminName($aval['admin_id']);
                                        $vendor_arr = $this->employee_model->getVendorName($aval['vendor_id']);
                                        $get_employee_login_details = $this->employee_model->getLoginDetails($aval['employee_id']);
                                        $check_generate_status = $this->employee_model->getGenerateStatus($aval['employee_id']);
                                        $work_status = $this->employee_model->checkWorkOrderStatus($aval['employee_id']);
                                        $final_approved_work_order = $this->employee_model->final_approved_work_order($aval['employee_id']);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>

                                                <?php
                                                if (!empty($admin_arr)) {
                                                    echo ucwords($admin_arr[0]['name_prefix']) . " " . ucwords($admin_arr[0]['first_name']) . " " . ucwords($admin_arr[0]['last_name']);
                                                }
                                                ?>

                                            </td>
                                            <td>

                                                <?php
                                                if (!empty($vendor_arr)) {
                                                    echo $vendor_arr[0]['vendor_company_name'];
                                                }
                                                ?>

                                            </td>
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
                                                <a href="<?php echo base_url('edit-consultant/' . base64_encode($aval['employee_id'])); ?>">
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
                                            <td><?php echo $aval['employee_designation']; ?></td>
                                            <td>
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
                                            <!--<td><?php //echo $aval['address'];         ?></td>-->
                                            <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                            <!--<td><?php //echo ($aval['date_of_joining'] != '0000-00-00') ? $aval['date_of_joining'] : "";         ?></td>-->
                                            <td>
                                                <?php
                                                if ($aval['resume_file'] != '') {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>uploads/<?php echo $aval['resume_file']; ?>"
                                                       class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true"
                                                                           style="color: red; font-size: 20px;"></i>
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <!--<td><label><?php //echo "$" . $aval['employee_bill_rate'];         ?></label></td>-->
                                            <!--<td><label><?php //echo "$" . $aval['employee_pay_rate'];         ?></label></td>-->
                                            <td>
                                                <?php
                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                    ?>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view-superadmin-con-timesheet/' . base64_encode($aval['employee_id'])); ?>"
                                                       data-toggle="tooltip" title="View Detailed Timesheet"
                                                       style="color: #09274B;"><i
                                                            class="fa fa-calendar" aria-hidden="true"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><a class="tbl_icon" href="<?php echo base_url('con-timesheet?customid=').$aval['employee_id']; ?>" data-toggle="tooltip" title="View Quick Timesheet"
                                                       style="color: green;"><i
                                                            class="fa fa-calendar" aria-hidden="true"></i></a></td>
                                            <td>
                                                <?php
                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                    if (!empty($work_status)) {

                                                        if ($work_status[0]['approved_by_admin'] == '1') {
                                                            if (empty($final_approved_work_order)) {
                                                            ?>
                                                            <a class="tbl_icon fancybox"
                                                               href="<?php echo base_url('view_sadmin_employees_work_order_pdf/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="Download PDF"
                                                               style="color: red;"><i
                                                                    class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

                                                            <?php } else { ?>

                                                            <a href="<?php echo base_url(); ?>uploads/historical_work_order/<?php echo $final_approved_work_order[0]['file']; ?>"
                                                            class="fancybox" data-toggle="tooltip" title="View Work Order">
                                                            <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i></a>
                                                            
                                                            <?php
                                                            }
                                                        }
                                                    }

                                                    if (!empty($work_status)) {
                                                        if ($work_status[0]['approved_by_admin'] == '0') {
                                                    ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('edit-sadmin-employee-work-order/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="Edit Work Order"
                                                               style="color: #09274B;"><i
                                                                    class="fa fa-pencil-square-o"
                                                                    aria-hidden="true"></i></a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a class="tbl_icon"
                                                           href="<?php echo base_url('add_sadmin_employee_work_order/' . base64_encode($aval['employee_id'])); ?>"
                                                           data-toggle="tooltip" title="Add Work Order"
                                                           style="color: green;"><i
                                                                class="fa fa-plus-circle"
                                                                aria-hidden="true"></i></a>
                                                        <?php
                                                        }

                                                    ?>

                                                    <a class="tbl_icon" href="" data-toggle="tooltip" title="Click here to Upload Historical Approved WO">
                                                            <i class="fa fa-upload" aria-hidden="true" style="color: #09274B;"></i>
                                                        </a>
                                            <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                    ?>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_superadmin_consultant_documents/' . base64_encode($aval['employee_id'])); ?>"
                                                       data-toggle="tooltip" title="View Documents"
                                                       style="color: #09274B;"><i
                                                            class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                    <?php
                                                }
                                                ?>

                                            </td>
                                            <td>
                                                <?php
                                                //                                                        if ($aval['status'] == '1') {
                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '0') {
                                                    ?>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('generate-superadmin-consultant-login-details/' . base64_encode($aval['employee_id'])); ?>"
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
                                            <td style="text-align: center;">
                                                <?php
                                                if (!empty($get_employee_login_details)) {
                                                    if ($get_employee_login_details[0]['status'] == '0' || $get_employee_login_details[0]['block_status'] == '0') {
                                                        ?>
                                                        <label style="color: red;font-size: 10px;">Account Not
                                                            Activated</label>
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
                                                   href="<?php echo base_url('edit-consultant/' . base64_encode($aval['employee_id'])); ?>"
                                                   data-toggle="tooltip" title="Edit "><i
                                                        class="fa fa-pencil-square-o" aria-hidden="true"
                                                        style="color: #09274B;"></i>
                                                </a>

                                                <a class="tbl_icon" href="#<?php echo $aval['employee_id']; ?>"
                                                   data-toggle="modal" title="View Profile">
                                                    <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i>
                                                </a>

                                                <?php
                                                if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {

                                                    if ($get_employee_login_details[0]['block_status'] == '0') {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)"
                                                           data-toggle="tooltip"
                                                           title="Unblock"
                                                           onclick="changeBlockStatus('unblock', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                class="fa fa-lock" aria-hidden="true"></i></a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)"
                                                           data-toggle="tooltip"
                                                           title="Block"
                                                           onclick="changeBlockStatus('block', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                class="fa fa-unlock" aria-hidden="true"
                                                                style="color: green;"></i></a>
                                                        <?php
                                                    }

                                                    if ($get_employee_login_details[0]['status'] == '1') {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)"
                                                           data-toggle="tooltip"
                                                           title="Deactive"
                                                           onclick="changeStatus('deactivate', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                class="fa fa-check" aria-hidden="true"
                                                                style="color: green;"></i></a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)"
                                                           data-toggle="tooltip"
                                                           title="Active"
                                                           onclick="changeStatus('activate', '<?php echo base64_encode($aval['employee_id']); ?>');"><i
                                                                class="fa fa-times" aria-hidden="true"></i></a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                   title="Delete"
                                                   onclick="deleteUser('<?php echo base64_encode($aval['employee_id']); ?>');">
                                                    <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                </a>

                                                <!-- Consultant Details -->
                                                <div class="modal fade" id="<?php echo $aval['employee_id']; ?>"
                                                     role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                        data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="box box-primary">
                                                                    <div class="box-body box-profile">
                                                                        <?php
                                                                        if ($aval['file'] != '') {
                                                                            ?>
                                                                            <img
                                                                                src="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>"
                                                                                alt="User Image"
                                                                                class="profile-user-img img-responsive img-circle">
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <img alt="User Image"
                                                                                 src="<?php echo base_url(); ?>assets/images/blank-profile.png"
                                                                                 class="profile-user-img img-responsive img-circle">
                                                                            <?php
                                                                        }
                                                                        ?>

                                                                        <h3 class="profile-username text-center"><?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?></h3>

                                                                        <div class="row">
                                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                <table id="vendor_tbl"
                                                                                       class="table table-bordered table-striped table-responsive"
                                                                                       style="font-size: 11px;">
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td><label>Consultant
                                                                                                Code</label></td>
                                                                                        <td><?php echo $aval['employee_code']; ?></td>
                                                                                        <td><label>Employee Classification</label></td>
                                                                                        <td class="notranslate">
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
                                                                                        <td><label>Consultant
                                                                                                Designation</label></td>
                                                                                        <td><?php echo $aval['employee_designation']; ?></td>
                                                                                        <td><label>Consultant
                                                                                                Category</label></td>
                                                                                        <td>
                                                             <?php 

                                                                echo show_categories($aval['temp_category'], false);
                                                            ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label>Phone No.</label>
                                                                                        </td>
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
                                                                                        <td><label>Bill Rate</label>
                                                                                        </td>
                                                                                        <td><?php echo "$" . number_format($aval['employee_bill_rate'], 2); ?></td>
                                                                                        <td><label>Pay Rate</label></td>
                                                                                        <td><?php echo "$" . number_format($aval['employee_pay_rate'], 2); ?></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><label>Date of
                                                                                                Joining</label></td>
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
                                            echo'<strong>Access Denied</strong>'; }
                                            ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                }
                                ?>

                                </tbody>
                            <?php } ?>
                            <?php if (LATAM) { ?>
                                    <tbody>
                                        <?php
                                        if (count($get_employee_details)) {
                                            foreach ($get_employee_details as $_each_key => $_each_record) {
                                                $work_status = $this->employee_model->checkWorkOrderStatus($_each_record['employee_id']);
                                                $get_employee_login_details = $this->employee_model->getLoginDetails($_each_record['employee_id']);
                                                // print_r($work_status[0]['stage']);
                                            ?>
                                            <tr>
                                                <td align="center"><?php echo $_each_key + 1; ?></td>
                                                <td><?php echo $_each_record['admin_full_name']; ?></td>
                                                <td><?php echo $_each_record['vendor_company_name']; ?></td>

                                                <td>
                                                    <div id="img_div" style="height: 60px; width: 60px;">
                                                    <?php if (empty($_each_record['file'])) { ?>
                                                        <img alt="User Image" class="img-circle"
                                                            src="<?php echo base_url(); ?>assets/images/blank-profile.png"
                                                            style="width: 100%; max-height: 100%; object-fit:contain;">
                                                    <?php } else { ?>
                                                        <img alt="User Image" class="img-circle"
                                                            src="<?php echo base_url(); ?>uploads/<?php echo $_each_record['file']; ?>"
                                                            style="width: 100%; max-height: 100%; object-fit:contain;">
                                                    <?php } ?>
                                                    </div>
                                                </td>

                                                <td><?php echo $_each_record['employee_code']; ?></td>
                                                <td>
                                                    <a href="<?php echo $_each_record['url_edit']; ?>"><?php echo $_each_record['full_name']; ?></a>
                                                </td>
                                                <td><?php echo $_each_record['consultant_email']; ?></td>
                                                <td><?php echo $_each_record['employee_designation']; ?></td>
                                                <td><?php echo $_each_record['classification']; ?></td>
                                                <td><?php echo $_each_record['category']; ?></td>
                                                <td><?php echo $_each_record['phone_num_text']; ?></td>

                                                <td align="center">
                                                    <a href="<?php echo $_each_record['resume_file_path']; ?>"
                                                    class="fancybox"><i aria-hidden="true"
                                                    class="fa fa-file-pdf-o" style="color: red; font-size: 20px;"></i></a>
                                                </td>

                                                <td align="center">
                                                    <?php if (!empty($_each_record['consultant_email'])) { ?>
                                                        <a data-toggle="tooltip" title="View Detailed Timesheet"
                                                        href="<?php echo $_each_record['url_ts_view_detail']; ?>"
                                                        class="tbl_icon" style="color: #09274B;"><i aria-hidden="true"
                                                        class="fa fa-calendar"></i></a>
                                                <?php } ?>
                                                </td>

                                                <td align="center">
                                                    <?php if (!empty($_each_record['consultant_email'])) { ?>
                                                        <a data-toggle="tooltip" title="View Quick Timesheet"
                                                        href="<?php echo $_each_record['url_ts_view_quick']; ?>"
                                                        class="tbl_icon" style="color: green;"><i aria-hidden="true"
                                                        class="fa fa-calendar"></i></a>
                                                    <?php } ?>
                                                </td>

                                                <td align="center">
                                                    <?php
                                                    // WO column section
                                                    if (!empty($_each_record['consultant_email'])) {
                                                        if (empty($_each_record['wo_employee_id'])) { // WO has not been initiated
                                                            if ($get_employee_login_details[0]['status'] == '1') {
                                                                ?>
                                                                <label style="color: red;font-size: 10px;">Work order was not generated</label>
                                                                <?php
                                                                    // $update_arr = array(
                                                                    //     'status' => '0',
                                                                    //     'updated_date' => date("Y-m-d")
                                                                    // );

                                                                    // $this->employee_model->change_status($update_arr, $aval['employee_id']);
                                                                }
                                                                else {
                                                        ?>

                                                            <a data-toggle="tooltip" title="Add Work Order"
                                                            href="<?php echo $_each_record['url_wo_add']; ?>"
                                                            class="tbl_icon" style="color: green;"><i aria-hidden="true"
                                                            class="fa fa-plus-circle"></i></a>

                                                        <?php
                                                        } } else { // WO has been initated
                                                            if (empty($_each_record['wo_file'])) { // WO has not been finalized
                                                                if ($work_status[0]['stage'] == 0 || $work_status[0]['stage'] < 5 && $get_employee_login_details[0]['status'] == '1') {

                                                                    // if(!file_exists(FCPATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $_each_record['employee_id']. "_work_order_.pdf")) {
                                                                    // $this->employee_model->copy_work_order($_each_record['employee_id'],$_each_record['employee_id']. "_work_order_.pdf", $work_status[$_each_key]['stage'], $get_employee_login_details[0]['status']);
                                                                    // }
                                                                    ?>
                                                                        <label style="color: red;font-size: 10px;">Work order was generated but vendor never signed</label>
                                                                        <?php
                                                                        // $update_arr = array(
                                                                        //     'status' => '0',
                                                                        //     'updated_date' => date("Y-m-d")
                                                                        // );

                                                                        // $this->employee_model->change_status($update_arr, $aval['employee_id']);
                                                                    } else {
                                                                
                                                            ?>

                                                                <a data-toggle="tooltip" title="Edit Work Order"
                                                                href="<?php echo $_each_record['url_wo_edit']; ?>"
                                                                class="tbl_icon" style="color: #09274B;"><i aria-hidden="true"
                                                                class="fa fa-pencil-square-o"></i></a>

                                                            <?php } } else { // WO has been finalized ?>

                                                                <a data-toggle="tooltip" title="View Work Order"
                                                                href="<?php echo $_each_record['url_wo_view']; ?>"
                                                                class="fancybox" style="color: #09274B;"><i aria-hidden="true"
                                                                class="fa fa-file-pdf-o"
                                                                style="color: red; font-size: 20px;"></i></a>

                                                            <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td align="center">
                                                    <?php if (!empty($_each_record['consultant_email'])) { ?>
                                                        <a data-toggle="tooltip" title="View Documents"
                                                        href="<?php echo $_each_record['url_docs_list']; ?>"
                                                        class="tbl_icon"
                                                        style="color: #09274B;"><i aria-hidden="true"
                                                        class="fa fa-file-text-o"></i></a>
                                                    <?php } ?>
                                                </td>

                                                <td align="center">
                                                    <?php if (empty($_each_record['consultant_email'])) { ?>
                                                        <a data-toggle="tooltip" title="Generate Login Detail"
                                                        href="<?php echo $_each_record['url_generate_login_detail']; ?>"
                                                        class="tbl_icon"><i aria-hidden="true"
                                                        class="fa fa-refresh"></i></a>
                                                    <?php } else { ?>
                                                        <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                                                    <?php } ?>
                                                </td>

                                                <td align="center">
                                                    <?php 
                                                    // echo $_each_record['wo_file'];
                                                        if(file_exists(FCPATH . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $_each_record['employee_id']. "_work_order_.pdf") && $get_employee_login_details[0]['status'] == '1') {
                                                            ?>
                                                            <a href="<?php echo base_url() . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR . $_each_record['employee_id']. "_work_order_.pdf"; ?>"><i aria-hidden="true"
                                                            class="fa fa-file-pdf-o"
                                                            style="color: red; font-size: 20px;"></i></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>

                                                <td align="center">
                                                    <?php
                                                    if (!empty($_each_record['consultant_email'])) {
                                                        if ($_each_record['login_status'] == '0'
                                                            || $_each_record['login_block_status'] == '0') {
                                                        ?>
                                                            <label style="color: red;">Account Not Activated</label>
                                                        <?php } else if ($_each_record['login_status'] == '1'
                                                                || $_each_record['login_block_status'] == '1') { ?>
                                                            <label style="color: green;">Activated</label>
                                                        <?php
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <td align="center">
                                                    <?php if ($super_admin_email == 'aurica@procuretechstaff.com') { ?>
                                                        <strong>Access Denied</strong>
                                                    <?php } else { ?>
                                                        <a data-toggle="tooltip" title="Edit Consultant"
                                                        href="<?php echo $_each_record['url_edit']; ?>"
                                                        class="tbl_icon"
                                                        style="color: #09274B;"><i aria-hidden="true"
                                                        class="fa fa-pencil-square-o"></i></a>

                                                        <a data-toggle="modal" title="View Profile"
                                                        href="#<?php echo $_each_record['employee_id']; ?>"
                                                        class="tbl_icon"
                                                        style="color: #09274B;"><i aria-hidden="true"
                                                        class="fa fa-eye"></i></a>

                                                        <?php
                                                        if (!empty($_each_record['consultant_email'])) {
                                                            if ($_each_record['login_block_status'] == '0') {
                                                            ?>
                                                                <a data-toggle="tooltip" title="Unblock"
                                                                href="javascript:void(0);"
                                                                onclick="changeBlockStatus('unblock', '<?php echo $_each_record['emp_id_encoded']; ?>');" 
                                                                class="tbl_icon"><i aria-hidden="true"
                                                                class="fa fa-lock"></i></a>
                                                            <?php } else { ?>
                                                                <a data-toggle="tooltip" title="Block"
                                                                href="javascript:void(0);"
                                                                onclick="changeBlockStatus('block', '<?php echo $_each_record['emp_id_encoded']; ?>');" 
                                                                class="tbl_icon"><i aria-hidden="true"
                                                                class="fa fa-unlock" style="color: green;"></i></a>
                                                            <?php
                                                            }

                                                            if ($_each_record['login_status'] == '1') {
                                                            ?>
                                                                <a data-toggle="tooltip" title="Deactivate"
                                                                href="javascript:void(0);"
                                                                onclick="changeStatus('deactivate', '<?php echo $_each_record['emp_id_encoded']; ?>' , '<?php echo $_each_record['employee_id']; ?>', '<?php echo $_each_record['employee_id']. '_work_order_.pdf'; ?>', '<?php echo $work_status[$_each_key]['stage']; ?>', '<?php echo $get_employee_login_details[0]['status']; ?>');" 
                                                                class="tbl_icon"><i aria-hidden="true"
                                                                class="fa fa-check" style="color: green;"></i></a>
                                                            <?php } else { ?>
                                                                <a data-toggle="tooltip" title="Activate"
                                                                href="javascript:void(0);"
                                                                onclick="changeStatus('activate', '<?php echo $_each_record['emp_id_encoded']; ?>', '<?php echo $_each_record['employee_id']; ?>', '<?php echo $_each_record['employee_id']. '_work_order_.pdf'; ?>', '<?php echo $work_status[$_each_key]['stage']; ?>', '<?php echo $get_employee_login_details[0]['status']; ?>');" 
                                                                class="tbl_icon"><i aria-hidden="true"
                                                                class="fa fa-times"></i></a>
                                                            <?php
                                                            }
                                                        }
                                                        ?>

                                                        <a data-toggle="tooltip" title="Delete"
                                                        href="javascript:void(0);"
                                                        onclick="deleteUser('<?php echo $_each_record['emp_id_encoded']; ?>');" 
                                                        class="tbl_icon"><i aria-hidden="true"
                                                        class="fa fa-trash-o" style="color: red;"></i></a>

                                                        <!-- Consultant View Details -->
                                                        <div class="modal fade" role="dialog" id="<?php echo $_each_record['employee_id']; ?>">
                                                            <div class="modal-dialog">

                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="box box-primary">
                                                                            <div class="box-body box-profile">
                                                                                <h3 class="profile-username text-center"><?php echo $_each_record['full_name']; ?></h3>

                                                                                <div class="row">
                                                                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                        <table id="vendor_tbl" style="font-size: 11px;"
                                                                                            class="table table-bordered table-striped table-responsive">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td><label>Consultant Code</label></td>
                                                                                                    <td><?php echo $_each_record['employee_code']; ?></td>
                                                                                                    <td><label>Employee Classification</label></td>
                                                                                                    <td><?php echo $_each_record['classification']; ?></td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td><label>Consultant Designation</label></td>
                                                                                                    <td><?php echo $_each_record['employee_designation']; ?></td>
                                                                                                    <td><label>Consultant Category</label></td>
                                                                                                    <td><?php echo $_each_record['category']; ?></td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td><label>Phone Number</label></td>
                                                                                                    <td><?php echo $_each_record['phone_num_text']; ?></td>
                                                                                                    <td><label>Fax No.</label></td>
                                                                                                    <td><?php echo $_each_record['fax_num_text']; ?></td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td><label>Address</label></td>
                                                                                                    <td colspan="3"><?php echo stripslashes($_each_record['address']); ?></td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td><label>Bill Rate</label></td>
                                                                                                    <td>
                                                                                                        <?php echo "$" . number_format($_each_record['employee_bill_rate'], 2); ?>
                                                                                                    </td>
                                                                                                    <td><label>Pay Rate</label></td>
                                                                                                    <td>
                                                                                                        <?php echo "$" . number_format($_each_record['employee_pay_rate'], 2); ?>
                                                                                                    </td>
                                                                                                </tr>

                                                                                                <tr>
                                                                                                    <td><label>Date of Joining</label></td>
                                                                                                    <td><?php echo $_each_record['mod_joining_date']; ?></td>
                                                                                                    <td>&nbsp;</td>
                                                                                                    <td>&nbsp;</td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </div>
                                                                                </div>
                                                                            </div><!-- /.box-body -->
                                                                        </div><!-- /.box -->
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!-- End of Consultant Details -->
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td align="center" colspan="19">No records found</td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                <?php } ?>
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
    
    <?php $this->load->view('superadmin/includes/common_footer'); ?>
</div>
<!-- ./wrapper -->

<?php $this->load->view('superadmin/includes/footer'); ?>

<?php if (LATAM) { ?>
<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>

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
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script type="text/javascript">
    function changeBlockStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'block') {
            var type = 'Block';
        } else if (bs_type == 'unblock') {
            var type = 'Unblock';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Consultant User?",
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
                    $.post("<?php echo site_url('change_employee_block_status'); ?>", {
                        bs_type: bs_type,
                        employee_id: employee_id
                    }, function (data) {
                        if (data == 1) {
                            var msg = 'Consultant ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
                            $(".succ-msg").hide();
                        }
                    });
                }
            }
        });
    }
</script>
<?php if (LATAM) { ?>
<script type="text/javascript">
    function changeStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'activate') {
            var type = 'Activate';
        } else if (bs_type == 'deactivate') {
            var type = 'Deactivate';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Consultant User?",
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
                    $.post("<?php echo site_url('change_employee_status'); ?>", {
                        bs_type: bs_type,
                        employee_id: employee_id
                    }, function (data) {
                        if (data == 1) {
                            var msg = 'Consultant ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else {
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
            message: "Do You Want To Delete The Consultant User?",
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
                            var msg = 'Consultant Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 0) {
                            var msg = 'OOPS !! Something went wrong!';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 3) {
                            var msg = 'OOPS !! A Project has already assigned to Consultant.';
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
    <?php } ?>
<?php if (US || INDIA) { ?>
<script type="text/javascript">
function changeStatus(type, id, employee_id, pdf, stage, status) {
    var bs_type = type;
    var employee_id = id;
    var employee_id_2 = employee_id;
    var pdf = pdf;
    var stage = stage;
    var status = status;

    if (bs_type == 'activate') {
        var type = 'Activate';
    } else if (bs_type == 'deactivate') {
        var type = 'Deactivate';
    }

    bootbox.confirm({
        message: "Do you want to " + type + " the Consultant User?",
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
            if (result) {
                $.post("<?php echo site_url('change_employee_status'); ?>", {
                    bs_type: bs_type,
                    employee_id: employee_id,
                    employee_id_2:employee_id_2,
                    pdf:pdf,
                    stage:stage,
                    status:status,
                }, function (data) {
                    if (data == 1) {
                        var msg = 'Consultant ' + type + 'd successfully';
                        $(".succ-msg").show();
                        $(".succ-msg").html(msg);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else {
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
        message: "Do you want to Delete the Consultant User?",
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
                $.post("<?php echo site_url('delete-employee-user'); ?>", {
                    employee_id: employee_id
                }, function (data) {
                    if (data == 1) {
                        var msg = 'Consultant Deleted successfully';
                        $(".succ-msg").show();
                        $(".succ-msg").html(msg);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else if (data == 0) {
                        var msg = 'OOPS!!! Something went wrong!';
                        $(".succ-err").show();
                        $(".succ-err").html(msg);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    } else if (data == 3) {
                        var msg = 'OOPS!!! A Project has already been assigned to Consultant.';
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
<?php } ?>
<?php if (US || INDIA) { ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.alert').delay(5000).fadeOut('slow');

    $('#admin_tbl').DataTable({
        scrollCollapse: true,
        scrollX: true,
        // scrollY: "300px",
        // paging: false,
    });
});
</script>
<?php } ?>
    