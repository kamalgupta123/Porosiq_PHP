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
                <li class="active">Employee Documentation</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
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

                    <div class="box">
                        <div class="box-header">
                            <?php
                            if (!empty($get_employee_details)) {
                                $employee_code = $get_employee_details[0]['employee_code'];
                                $employee_name = $get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name'];
                                $employee_type = $get_employee_details[0]['employee_type'];
                                $employee_name_prefix = $get_employee_details[0]['name_prefix'];
                            }
                            ?>
                            <h3 class="box-title">Documentation for <?php echo $employee_name_prefix . " " . ucwords($employee_name) . " [ " . strtoupper($employee_code) . " ] "; ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body tab-div">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Document Name</th>
                                        <th>File</th>
                                        <th>Upload Documents</th>
                                        <th>View File</th>
                                        <th>1st Level Approval Status</th>
                                        <th>2nd Level Approval Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_documents_details > 0)) {

                                        foreach ($get_documents_details as $aval) {
                                            $required_for_arr = array();
                                          $required_for_arr = explode(",", $aval['required_for']);
                                          //print_r($required_for_arr);
                                            $get_uploaded_document = $this->employee_model->checkPrevUploadedDetails($aval['id'], $employee_id);
                                            if (in_array($employee_type, $required_for_arr)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo stripslashes($aval['document_name']); ?></td>
                                                    <td>
                                                        <?php
                                                        if ($aval['file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-download" aria-hidden="true"></i> Download Document and Upload With Proper Details</a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>upload_superadmin_employee_documents/<?php echo base64_encode($aval['id']) . '/' . base64_encode($employee_id); ?>" style="color: #09274B;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Document</a>    
                                                    </td>
                                                    <td align="center">
                                                        <?php
                                                        if (!empty($get_uploaded_document)) {
                                                            if ($get_uploaded_document[0]['file'] != '') {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>uploads/<?php echo $get_uploaded_document[0]['file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>superadmin-show-files/<?php echo base64_encode($get_uploaded_document[0]['form_no']) . "/" . base64_encode($get_uploaded_document[0]['consultant_id']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_uploaded_document)) {
                                                            if ($get_uploaded_document[0]['form_status'] == '1') {
                                                                ?>
                                                                <label style="color:green;">Approved</label>
                                                                <?php
                                                            } elseif ($get_uploaded_document[0]['form_status'] == '0') {
                                                                ?>
                                                                <label style="color:#f39c12;">Pending Approval</label>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_uploaded_document)) {
                                                            if ($get_uploaded_document[0]['admin_form_status'] == '1') {
                                                                ?>
                                                                <label style="color:green;">Approved</label>
                                                                <?php
                                                            } elseif ($get_uploaded_document[0]['admin_form_status'] == '0') {
                                                                ?>
                                                                <label style="color:#f39c12;">Pending Approval</label>
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
<script>
    $(function () {
        $('#admin_tbl').DataTable();
    });
</script>