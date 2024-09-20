<?php
$this->load->view('admin/includes/header');
if (!empty($get_details)) {
    $admin_id = $get_details[0]['admin_id'];
}
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

    .select2 {
        width: 150px !important;
    }

    .formError .formErrorContent {
        min-width: 150px !important;
    }
    label{
        font-weight: 600;
    }
</style>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin_dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('admin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('admin/includes/user_panel');
            $this->load->view('admin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vendor Documents
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Vendor</a></li>
                <li class="active">Vendor Documents</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
            <?php } ?>
            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <?php
                                if (!empty($get_vendor_data)) {
                                    $company_name = $get_vendor_data[0]['vendor_company_name'];
                                    $vendor_name = ucwords($get_vendor_data[0]['first_name'] . " " . $get_vendor_data[0]['last_name']);
                                    $name_prefix = $get_vendor_data[0]['name_prefix'];
                                }
                                ?>
                                <h3 class="box-title">Verify documents for <?php echo strtoupper($company_name); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-file"></span>
                                Vendor Documents
                            </h3>
                        </div>

                        <?php if ($this->session->flashdata('error_msgs')) { ?>
                            <div class="alert alert-success">
                                <?php
                                echo $this->session->flashdata('error_msgs');
                                ?>
                            </div>
                        <?php } ?>

                        <form id="edit_admin_form"
                              action="<?php echo site_url('verify_documents'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">
                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1"
                                               cellspacing="2" cellpadding="2">
                                            <tbody>

                                                <?php
                                                //$docs_arr = array("1" => "ACH FORM", "2" => "COMPANY SUBCONTRACTOR AGREEMENT", "3" => "NDA FORM", "4" => "SUBCONTRACTOR MANDATORY INSURANCE REQUIREMENTS");
                                                if (!empty($get_vendor_documents)) {
                                                    $f = 1;

                                                    foreach ($get_vendor_documents as $fval) {
                                                        $get_form_status = $this->vendor_model->checkFormStatus($fval['id'], $vendor_id);
                                                        $get_admin_form = $this->vendor_model->checkAdminForm($fval['id'], $vendor_id);
//echo "<pre>";
//                                                    print_r($get_form_status);
                                                        ?>
                                                        <tr>
                                                            <td width="30%">
                                                                <label for="email"><?php echo ucwords($fval['document_name']) ?> :</label>
                                                            </td>
                                                            <td width="14%">
                                                                <?php
                                                                if (!empty($get_form_status)) {
                                                                    ?>
                                                                    <select name="file_status[]"
                                                                            class="form-control">
                                                                        <option
                                                                            value="0" <?php if (isset($get_form_status[0]['form_status']) && $get_form_status[0]['form_status'] == '0') { ?> selected <?php } ?>>
                                                                            Not Approved
                                                                        </option>
                                                                        <option
                                                                            value="1" <?php if (isset($get_form_status[0]['form_status']) && $get_form_status[0]['form_status'] == '1') { ?> selected <?php } ?>>
                                                                            Approved
                                                                        </option>
                                                                    </select>
                                                                    <input type="hidden" name="doc_id[]" value="<?php echo $fval['id']; ?>">
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <span style="color:red;">Document Not Uploaded Yet</span>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="14%">
                                                                <?php
                                                                if (!empty($get_form_status)) {
                                                                    if ($get_form_status[0]['form_data'] != '') {
                                                                        ?>
                                                                        <span><a
                                                                                href="<?php echo base_url(); ?>view_vendor_document/<?php echo base64_encode($fval['id']); ?>/<?php echo base64_encode($vendor_id); ?>"
                                                                                class="fancybox" style="color: #09274B;"><i
                                                                                    class="fa fa-eye"
                                                                                    aria-hidden="true"></i> View
                                                                                File</a></span>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="14%">
                                                                <?php
                                                                if (isset($get_form_status[0]['form_status']) && $get_form_status[0]['form_status'] != '') {
                                                                    if ($get_form_status[0]['file'] != '') {
                                                                        $get_form = $this->vendor_model->getVendorDocument($fval['id'], $vendor_id);
                                                                        ?>
                                                                        <span><a
                                                                                href="<?php echo base_url(); ?>uploads/vendor_pdfs/<?php echo $get_form[0]['file']; ?>"
                                                                                class="fancybox" style="color: #09274B;"><i
                                                                                    class="fa fa-download"
                                                                                    aria-hidden="true"></i> Download
                                                                                File</a></span>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td width="14%">
                                                                <?php
                                                                if (!empty($get_admin_form)) {
                                                                    if ($get_admin_form[0]['file'] != '') {
                                                                        ?>
                                                                        <span><a
                                                                                href="<?php echo base_url(); ?>uploads/<?php echo $get_admin_form[0]['file']; ?>"
                                                                                class="fancybox" style="color: #09274B;"><i
                                                                                    class="fa fa-download"
                                                                                    aria-hidden="true"></i> Download Approved File By Super Admin</a></span>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                                
                                                            </td>
<!--                                                            <td width="14%">
                                                                <a href="<?php //echo base_url(); ?>uploads-admin-vendor-documents/<?php echo base64_encode($fval['id']); ?>/<?php echo base64_encode($get_vendor_data[0]['vendor_id']); ?>"
                                                                   style="color: #09274B;">
                                                                    <i class="fa fa-upload" aria-hidden="true"></i> Sign and Upload File
                                                                </a>
                                                            </td>-->
                                                        </tr>
                                                        <?php
                                                        $f++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="hidden" name="vendor_id"
                                               value="<?php echo base64_encode($get_vendor_data[0]['vendor_id']); ?>">
                                        <input class="btn btn-success" type="submit" name="submit" value="Verify Documents">
                                        <a href="javascript:void(0)" onclick="window.history.back()" class="btn btn-default">Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('admin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('admin/includes/footer');
?>

