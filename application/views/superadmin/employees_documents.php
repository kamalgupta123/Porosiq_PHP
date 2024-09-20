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
                <?php
                if (isset($emp_type)) {
                    echo $emp_type;
                }
                ?>
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage <?php
                        if (isset($emp_type)) {
                            echo $emp_type;
                        }
                        ?></a></li>
                <li class="active"><?php
                    if (isset($emp_type)) {
                        echo $emp_type;
                    }
                    ?> Document Lists</li>
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
            <div class="alert alert-success succ-msg" style="display: none;"></div>
            <div class="alert alert-danger succ-err" style="display: none;"></div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">

                        <div class="panel panel-default">
                            <div class="" style="text-align: left; padding: 0px 0px 0px 10px;">
                                <?php
                                if (!empty($get_employee_details)) {
                                    $employee_code = $get_employee_details[0]['employee_code'];
                                    $employee_name = $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name'];
                                    $employee_name_prefix = $get_employee_details[0]['name_prefix'];
                                    $employee_type = $get_employee_details[0]['employee_type'];
                                }
                                ?>
                                <h3 class="box-title"><?php
                                    if (isset($emp_type)) {
                                        echo $emp_type;
                                    }
                                    ?> Document Lists for <?php echo $employee_name_prefix . " " . ucwords($employee_name) . " [ " . strtoupper($employee_code) . " ] "; ?></h3>
                            </div>
                        </div>
                    </div>
                    <form id="timesheet_table" action="<?php echo site_url('sa_approve_disapprove_documents'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box">
                            <div class="box-header">

                                <div style="float: left;">
                                    <input type="submit" name="ad" value="Approved" class="btn btn-success approve"
                                           style="font-size: 12px;">
                                    <input type="submit" name="ad" value="Disapproved" class="btn btn-danger disapprove"
                                           style="font-size: 12px;">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="" class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>SL No.</th>
                                            <?php if ($employee_type == 'C') { ?>
                                                <th>Consultant Code</th>
                                            <?php } else { ?>
                                                <th>Employee Code</th>
                                            <?php } ?>
                                            <?php if ($employee_type == 'C') { ?>
                                                <th>Consultant Name</th>
                                            <?php } else { ?>
                                                <th>Employee Name</th>
                                            <?php } ?>
                                            <?php if ($employee_type == 'C') { ?>
                                                <th>Consultant Designation</th>
                                            <?php } else { ?>
                                                <th>Employee Designation</th>
                                            <?php } ?>
                                            <th>Document Name</th>
                                            <th>Upload Documents</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Admin Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($get_documents_details) > 0) {

                                            if(strtotime(NEW_DOC_DATE) > strtotime($get_employee_details[0]['date_of_joining'])) {

                                                    $document_timing = "0";

                                                } else if (strtotime(NEW_DOC_DATE) <= strtotime($get_employee_details[0]['date_of_joining'])) {

                                                    $document_timing = "1";

                                                }


                                            foreach ($get_documents_details as $aval) {

                                                <?php if (US || INDIA) { ?>
                                                    if ($aval['document_timing'] == $document_timing) {
                                                <?php } ?>  
                                                <?php if (LATAM) { ?>
                                                    if($aval['document_timing'] == $document_timing || $aval['document_timing'] == "0") {
                                                <?php } ?>

                                                    $doc_status = "";
                                                    $admin_doc_status = "";
                                                    $get_consultant_documents = $this->employee_model->getUploadedDocs($aval['id'], $get_employee_details[0]['employee_id']);
    //                                                echo "<pre>";
    //                                                print_r($get_consultant_documents);
                                                    ?>
                                                    <tr>
                                                        <?php
                                                        if (!empty($get_consultant_documents)) {
                                                            $doc_status = $get_consultant_documents[0]['form_status'];
                                                            $admin_doc_status = $get_consultant_documents[0]['admin_form_status'];
                                                            ?>
                                                            <td>
                                                            <?php if (INDIA) { ?>
                                                                <input type="checkbox" name="check[]" class="chk" value="<?php echo $aval['id']; ?>" <?php //if ($doc_status == '1') { checked="checked"?>  <?php //} ?>>
                                                            <?php } ?>
                                                            <?php if (US || LATAM) { ?>
                                                                <input type="checkbox" name="check[]" class="chk" value="<?php echo $aval['id']; ?>" <?php if ($doc_status == '1') { ?> checked="checked" <?php } ?>>
                                                            <?php } ?>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td>&nbsp;</td>
                                                        <?php } ?>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo stripslashes($get_employee_details[0]['employee_code']); ?></td>
                                                        <td><?php echo stripslashes($get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']); ?></td>
                                                        <td><?php echo stripslashes($get_employee_details[0]['employee_designation']); ?></td>
                                                        <td><?php echo stripslashes($aval['document_name']); ?></td>
                                                        <td>
                                                            <a href="<?php echo base_url(); ?>upload_sa_consultant_documents/<?php echo base64_encode($aval['id']) . '/' . base64_encode($employee_id); ?>" style="color: #09274B;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Document</a>    
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($get_consultant_documents)) {
                                                                if ($get_consultant_documents[0]['file'] != '') {
                                                                    ?>
                                                                    <a href="<?php echo base_url(); ?>uploads/<?php echo $get_consultant_documents[0]['file']; ?>"
                                                                       class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                       <?php
                                                                   } else {
                                                                       ?>
                                                                    <a href="<?php echo base_url(); ?>superadmin-show-files/<?php echo base64_encode($get_consultant_documents[0]['form_no']) . "/" . base64_encode($get_consultant_documents[0]['consultant_id']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php if (INDIA) { ?>
                                                                <?php
                                                                if (!empty($get_consultant_documents)) {
                                                                    if ($doc_status == '2') {
                                                                        ?>
                                                                        <label style="color: #f39c12;">Pending Approval</label>
                                                                        <?php
                                                                    } elseif ($doc_status == '0') {
                                                                        ?>
                                                                        <label style="color: #f39c12;">Disapproved</label>
                                                                        <?php
                                                                    } elseif ($doc_status == '1') {
                                                                        ?>
                                                                        <label style="color: green;">Approved</label>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            <?php } ?>
                                                            <?php if (US || LATAM) { ?>
                                                                <?php
                                                                if (!empty($get_consultant_documents)) {
                                                                    if ($doc_status == '0') {
                                                                        ?>
                                                                        <label style="color: #f39c12;">Pending Approval</label>
                                                                        <?php
                                                                    } elseif ($doc_status == '1') {
                                                                        ?>
                                                                        <label style="color: green;">Approved</label>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            <?php }?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if (!empty($get_consultant_documents)) {
                                                                if ($admin_doc_status == '0') {
                                                                    ?>
                                                                    <label style="color:#f39c12;">Pending Approval</label>
                                                                    <?php
                                                                } else if ($admin_doc_status == '1') {
                                                                    ?>
                                                                    <label style="color:green;">Approved</label>
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
                                        }
                                        ?>

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <input type="hidden" name="employee_id" value="<?php echo $get_employee_details[0]['employee_id']; ?>">
                    </form>

                    <?php
//                    if (!empty($get_work_order_status)) {
//                        if ($get_work_order_status[0]['client_name'] == '1') {
                    ?>

                    <form id="upload_document" action="<?php echo site_url('sa_approve_disapprove_ucsic_docs'); ?>" method="post" enctype="multipart/form-data">    
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Employment Eligibility Verification Department of Homeland Security</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="docs_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>List A</th>
                                                <th>View File</th>
                                                <th>List B</th>
                                                <th>View File</th>
                                                <th>List C</th>
                                                <th>View File</th>
                                                <th>Admin Approval Status</th>
                                                <th>Super Admin Approval</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (count($get_emp_uscis_files) == 0) {
//                                            
                                                ?>
                                                <tr>
                                                    <td width="15%">
                                                        <select name="list_a_name" id="list_a_name" class="form-control validate[required]" onChange="getlistadetails(this.value)">
                                                            <option value="">---Select List-A---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_a)) {
                                                                foreach ($get_vms_emp_id_list_a as $adval) {
                                                                    ?>
                                                                    <option value="<?php echo $adval['id']; ?>"><?php echo $adval['id'] . ".&nbsp;&nbsp;" . $adval['list_a_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td width="15%">
                                                        <select name="list_b_name" id="list_b_name" class="form-control validate[required]" onChange="getvendordetails(this.value)">
                                                            <option value="">---Select List-B---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_b)) {
                                                                foreach ($get_vms_emp_id_list_b as $bdval) {
                                                                    ?>
                                                                    <option value="<?php echo $bdval['id']; ?>"><?php echo $bdval['id'] . ".&nbsp;&nbsp;" . $bdval['list_b_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td align="center">
                                                        &nbsp;
                                                    </td>
                                                    <td width="15%">
                                                        <select name="list_c_name" id="list_c_name" class="form-control validate[required]" onChange="getvendordetails(this.value)">
                                                            <option value="">---Select List-C---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_c)) {
                                                                foreach ($get_vms_emp_id_list_c as $cdval) {
                                                                    ?>
                                                                    <option value="<?php echo $cdval['id']; ?>"><?php echo $cdval['id'] . ".&nbsp;&nbsp;" . $cdval['list_c_name']; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                    <td>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                <tr class="hideme">
                                                    <th>
                                                        <label for="photo" style="font-size:15px" class="lbl-css">Upload Document :<span style="color: red;">*</span></label>
                                                    </th>
                                                </tr>
                                                <tr class="hideme_fst">
                                                    <td colspan="8" align="center">
                                                        <!--                                                            <br>-->
                                                        <label for="photo" class="lbl-css">Upload List-A 1st Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_a_doc_name[]" id="image-file">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_sec">
                                                    <td colspan="8" align="center">
                                                        <label for="photo" class="lbl-css">Upload List-A 2nd Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_a_doc_name[]" id="image-file1">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_thrd">
                                                    <td colspan="8" align="center">
                                                        <!--                                                            <br>-->
                                                        <label for="photo" class="lbl-css">Upload List-B Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_b_doc_name[]" id="image-file2">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_frth">
                                                    <td colspan="8" align="center">
                                                        <label for="photo" class="lbl-css">Upload List-C 1st Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_c_doc_name[]" id="image-file3">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_btn">
                                                    <td colspan="8" align="center">
                                                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                                        <input type="hidden" name="employee_type" value="<?php echo $employee_type; ?>">
                                                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Upload Document">
                                                    </td>
                                                </tr>
                                                <?php
//                                                    $i++;
                                            } else {
                                                $get_uscis_doc_status = $this->employee_model->checkUscisUploadedDocss($employee_id);
                                                $list_a_docs_id = $get_emp_uscis_files[0]['list_a_docs_id'];
                                                $list_b_docs_id = $get_emp_uscis_files[0]['list_b_docs_id'];
                                                $list_c_docs_id = $get_emp_uscis_files[0]['list_c_docs_id'];

                                                if ($list_a_docs_id != "") {
                                                    $list_a_docs_arr = array();
                                                    foreach ($get_emp_uscis_files as $uscisfile) {
//
                                                        $list_a_docs_arr = explode(",", $uscisfile['list_a_docs']);
//                                                            print_r($list_a_docs_arr);
                                                    }
                                                }

                                                if ($list_b_docs_id != "") {
                                                    $list_b_docs_arr = array();
                                                    foreach ($get_emp_uscis_files as $uscisfile) {
//
                                                        $list_b_docs_arr = explode(",", $uscisfile['list_b_docs']);
                                                        //print_r($list_b_docs_arr);
                                                    }
                                                }

                                                if ($list_c_docs_id != "") {
                                                    $list_c_docs_arr = array();
                                                    foreach ($get_emp_uscis_files as $uscisfile) {
//
                                                        $list_c_docs_arr = explode(",", $uscisfile['list_c_docs']);
                                                        //print_r($list_c_docs_arr);
                                                    }
                                                }
                                                ?>

                                                <tr>
                                                    <td width="15%">
                                                        <select name="list_a_name" id="list_a_name" class="form-control">
                                                            <option value="">---Select List-A---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_a)) {
                                                                foreach ($get_vms_emp_id_list_a as $adval) {
                                                                    if ($list_a_docs_id != "") {
                                                                        ?>
                                                                        <option value="<?php echo $adval['id']; ?>" <?php if ($adval['id'] == $list_a_docs_id) { ?> selected="selected" <?php } ?>><?php echo $adval['id'] . ".&nbsp;&nbsp;" . $adval['list_a_name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $adval['id']; ?>"><?php echo $adval['id'] . ".&nbsp;&nbsp;" . $adval['list_a_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($list_a_docs_id == "") {
                                                            ?>
                                                            <span><b>There are no List-A files for view</b></span>
                                                        <?php } elseif ($list_a_docs_id == 5) { ?>
                                                            <a href="<?php echo base_url(); ?>uploads/lista_pdf/<?php echo $list_a_docs_arr[0]; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                            &nbsp;&nbsp;
                                                            <a href="<?php echo base_url(); ?>uploads/lista_pdf/<?php echo $list_a_docs_arr[1]; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                        <?php } else { ?>
                                                            <a href="<?php echo base_url(); ?>uploads/lista_pdf/<?php echo $list_a_docs_arr[0]; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="15%">
                                                        <select name="list_b_name" id="list_b_name" class="form-control">
                                                            <option value="">---Select List-B---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_b)) {
                                                                foreach ($get_vms_emp_id_list_b as $bdval) {
                                                                    if ($list_b_docs_id != "") {
                                                                        ?>
                                                                        <option value="<?php echo $bdval['id']; ?>" <?php if ($bdval['id'] == $list_b_docs_id) { ?> selected="selected" <?php } ?>><?php echo $bdval['id'] . ".&nbsp;&nbsp;" . $bdval['list_b_name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $bdval['id']; ?>"><?php echo $bdval['id'] . ".&nbsp;&nbsp;" . $bdval['list_b_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        if ($list_b_docs_id != "") {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/listb_pdf/<?php echo $list_b_docs_arr[0]; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                        <?php } else { ?>
                                                            <span><b>There are no List-B files for view</b></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="15%">
                                                        <select name="list_c_name" id="list_c_name" class="form-control">
                                                            <option value="">---Select List-C---</option>
                                                            <?php
                                                            if (!empty($get_vms_emp_id_list_c)) {
                                                                foreach ($get_vms_emp_id_list_c as $cdval) {
                                                                    if ($list_c_docs_id != "") {
                                                                        ?>
                                                                        <option value="<?php echo $cdval['id']; ?>" <?php if ($cdval['id'] == $list_c_docs_id) { ?> selected="selected" <?php } ?>><?php echo $cdval['id'] . ".&nbsp;&nbsp;" . $cdval['list_c_name']; ?></option>
                                                                    <?php } else { ?>
                                                                        <option value="<?php echo $cdval['id']; ?>"><?php echo $cdval['id'] . ".&nbsp;&nbsp;" . $cdval['list_c_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ($list_c_docs_id != "") {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/listc_pdf/<?php echo $list_c_docs_arr[0]; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                        <?php } else { ?>
                                                            <span><b>There are no List-C files for view</b></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (isset($get_uscis_doc_status[0]['admin_status']) && $get_uscis_doc_status[0]['admin_status'] == '1') {
                                                            ?>
                                                            <label style="color:green;">Approved</label>
                                                            <?php
                                                        } else if (isset($get_uscis_doc_status[0]['admin_status']) && $get_uscis_doc_status[0]['admin_status'] == '0') {
                                                            ?>
                                                            <label style="color:red;">Not Approve</label>
                                                            <?php
                                                        } else if (isset($get_uscis_doc_status[0]['admin_status']) && $get_uscis_doc_status[0]['admin_status'] == '2') {
                                                            ?>
                                                            <label style="color:#f39c12;">Pending</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sadmin_approval = $get_uscis_doc_status[0]['sadmin_status'];
                                                        ?>
                                                        <select name="sadmin_approval" id="sadmin_approval" class="form-control" onchange="return changeUscApprovalStatus();">

                                                            <!--<option value="">---Select---</option>-->
                                                            <option value="1" <?php if ($sadmin_approval == '1') { ?> selected="selected" <?php } ?>>Approve</option>
                                                            <option value="0" <?php if ($sadmin_approval == '0') { ?> selected="selected" <?php } ?>>Disapprove</option>
                                                            <option value="2" <?php if ($sadmin_approval == '2') { ?> selected="selected" <?php } ?>>Pending Approval</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr class="hideme">
                                                    <th>
                                                        <label for="photo" style="font-size:15px" class="lbl-css">Upload Document :<span style="color: red;">*</span></label>
                                                    </th>
                                                </tr>
                                                <tr class="hideme_fst">
                                                    <td colspan="8" align="center">
                                                        <!--                                                            <br>-->
                                                        <label for="photo" class="lbl-css">Upload List-A 1st Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_a_doc_name[]" id="image-file">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_sec">
                                                    <td colspan="8" align="center">
                                                        <label for="photo" class="lbl-css">Upload List-A 2nd Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_a_doc_name[]" id="image-file1">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_thrd">
                                                    <td colspan="8" align="center">
                                                        <!--                                                            <br>-->
                                                        <label for="photo" class="lbl-css">Upload List-B Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_b_doc_name[]" id="image-file2">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_frth">
                                                    <td colspan="8" align="center">
                                                        <label for="photo" class="lbl-css">Upload List-C 1st Document :<span style="color: red;">*</span></label>
                                                        <input class="validate[required]" type="file" name="list_c_doc_name[]" id="image-file3">
                                                    </td>
                                                </tr>
                                                <tr class="hideme_btn">
                                                    <td colspan="8" align="center">
                                                        <input type="hidden" id="uscis_id" value="<?php echo $get_uscis_doc_status[0]['id']; ?>">
                                                        <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
                                                        <input type="hidden" name="employee_type" value="<?php echo $employee_type; ?>">
                                                        <input class="btn btn-success btn-sm" type="submit" name="submit" value="Upload Document">
                                                    </td>
                                                </tr>

                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </form>

                    <?php
//                        }
//                    }
                    ?>

                </div>
            </div>
            <!-- /.row (main row) -->
            <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
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
<link rel="stylesheet"
      href="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/css/validationEngine.jquery.css"
      type="text/css"/>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js"
        type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url(); ?>assets/jQuery-Validation-Engine-master/js/jquery.validationEngine.js"
        type="text/javascript" charset="utf-8">
</script>
<script>
    $(document).ready(function () {
        // binds form submission and fields to the validation engine
        $("#upload_document").validationEngine({promptPosition: 'inline'});
    });


</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
        $('select').select2('destroy');
    });
</script>

<script src="<?php echo base_url(); ?>assets/js/jquery.tablecheckbox.js"></script>
<script>
    $(function () {
        //alert("sdf");
        $('.tbl-checked').tablecheckbox();
    });
    $(document).ready(function () {
        // you should use id on form too, this will bug if you have more forms on your page
        $(".approve").on('click', function (event) {
            //alert("dfs");
            if ($(".tbl-checked .chk:checked").length === 0) {
                event.preventDefault();
                //alert user here
                $(".succ-err").show();
                $(".succ-err").html('You Need To Select At Least One Checkbox');
                setTimeout(function () {
                    $(".succ-err").hide();
                }, 2000);
            }
        });
        $(".disapprove").on('click', function (event) {
            //alert("dfs");
            if ($(".tbl-checked .chk:checked").length === 0) {
                event.preventDefault();
                //alert user here
                $(".succ-err").show();
                $(".succ-err").html('You Need To Select At Least One Checkbox');
                setTimeout(function () {
                    $(".succ-err").hide();
                }, 2000);
            }
        });
    });
</script>

<script>
    $('#docs_tbl .hideme').hide();
    $('#docs_tbl .hideme_fst').hide();
    $('#docs_tbl .hideme_sec').hide();
    $('#docs_tbl .hideme_thrd').hide();
    $('#docs_tbl .hideme_frth').hide();
    $('#docs_tbl .hideme_btn').hide();


    $(function () {

        $("#list_a_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_b_name = $("#list_b_name");
            var list_c_name = $("#list_c_name");
            if ($(this).val()) {
                list_b_name.attr('disabled', 'disabled');
                list_c_name.attr('disabled', 'disabled');
//                list_b_name.rules('remove', 'required');
//                list_c_name.rules('remove', 'required');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').show();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').show();
                if (($(this).val()) == 5) {
                    list_b_name.attr('disabled', 'disabled');
                    list_c_name.attr('disabled', 'disabled');
//                    list_b_name.rules('remove', 'required');
//                    list_c_name.rules('remove', 'required');
                    $('#docs_tbl .hideme').show();
                    $('#docs_tbl .hideme_fst').show();
                    $('#docs_tbl .hideme_sec').show();
                    $('#docs_tbl .hideme_thrd').hide();
                    $('#docs_tbl .hideme_frth').hide();
                    $('#docs_tbl .hideme_btn').show();
                }
            } else {
                list_b_name.removeAttr('disabled');
                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').hide();
            }
        });

        $("#list_b_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_a_name = $("#list_a_name");
            var list_c_name = $("#list_c_name");
            if ($(this).val()) {
                list_a_name.attr('disabled', 'disabled');
//                list_c_name.attr('disabled', 'disabled');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').show();
                if (list_c_name.val()) {
                    $('#docs_tbl .hideme_frth').show();
                    $('#docs_tbl .hideme_btn').show();
                } else {
                    $('#docs_tbl .hideme_frth').hide();
                    $('#docs_tbl .hideme_btn').hide();
                }
            } else {
                list_a_name.removeAttr('disabled');
//                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                if (list_c_name.val()) {
                    $('#docs_tbl .hideme_frth').show();
                    list_a_name.attr('disabled', 'disabled');
                } else {
                    $('#docs_tbl .hideme_frth').hide();
                    list_a_name.removeAttr('disabled');
                }
                $('#docs_tbl .hideme_btn').hide();
            }
        });

        $("#list_c_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_a_name = $("#list_a_name");
            var list_b_name = $("#list_b_name");
            if ($(this).val()) {
                list_a_name.attr('disabled', 'disabled');
//                list_c_name.attr('disabled', 'disabled');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                if (list_b_name.val()) {
                    $('#docs_tbl .hideme_thrd').show();
                    $('#docs_tbl .hideme_btn').show();
                } else {
                    $('#docs_tbl .hideme_thrd').hide();
                    $('#docs_tbl .hideme_btn').hide();
                }
                $('#docs_tbl .hideme_frth').show();
            } else {
                list_a_name.removeAttr('disabled');
//                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                if (list_b_name.val()) {
                    $('#docs_tbl .hideme_thrd').show();
                    list_a_name.attr('disabled', 'disabled');
                } else {
                    $('#docs_tbl .hideme_thrd').hide();
                    list_a_name.removeAttr('disabled');
                }
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $('#image-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file1').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file1').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file1').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file2').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file2').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file2').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file3').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file3').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file3').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>

<script>
    function changeUscApprovalStatus() {
        var uscis_id = $("#uscis_id").val();
        var sadmin_approval = $("#sadmin_approval").val();

        $.post("<?php echo site_url('ajax_change_uscis_status'); ?>", {uscis_id: uscis_id, sadmin_approval: sadmin_approval}, function (data) {
            //if (data == 1) {
            var msg = 'Employment Eligibility Verification Status Changed Successfully';
            $(".succ-msg").show();
            $(".succ-msg").html(msg);
            setTimeout(function () {
                location.reload();
            }, 2000);
            //} 
            /*else if (data == 0)
             {
             $(".succ-msg").hide();
             } else if (data == 'OOPS !! Admin has vendor under him.')
             {
             var msg = 'OOPS !! Admin has vendor under him.';
             $(".succ-err").show();
             $(".succ-err").html(msg);
             setTimeout(function () {
             location.reload();
             }, 2000);
             }*/
        });

    }
</script>