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

    .alert-danger-d {
        color: #fff;
        background-color: #ff5c5c;
        border-color: #ff2d2d;
    }

    .alert-d {
        padding: 14px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-weight: bold;
    }

    ul.tabs{
        margin: 0px;
        padding: 0px;
        list-style: none;
    }
    ul.tabs li{
        background: none;
        color: #222;
        display: inline-block;
        padding: 10px 15px;
        cursor: pointer;
    }

    ul.tabs li.current{
        background: #09274b;
        color: #fff;

    }

    .tab-content{
        display: none;
        background: #fff;
        padding: 15px 0px;
    }

    .tab-content.current{
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
                <li class="active"><a href="">Documentation</a></li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


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
                            <h3 class="box-title">Documents Lists</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><label>Scan & Upload Documents</label></li>
                                <li class="tab-link" data-tab="tab-2"><label>Sign & Submit Documents</label></li>
                            </ul>

                            <div id="tab-1" class="tab-content current">
                                <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Documents Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th>View Counter Signed File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($get_details)) {
                                            $vendor_id = $get_details[0]['vendor_id'];
                                        }
                                        if (!empty($get_vendor_documents)) {
                                            $j = 1;
                                            foreach ($get_vendor_documents as $vval) {
                                                $get_file_status = $this->profile_model->getFileStatus($vval['id'], $vendor_id);
                                                $get_counter_files = $this->profile_model->checkCounterForm($vval['id'], $vendor_id);
                                                ?>
                                                <tr>
                                                    <td><?php echo $j; ?></td>
                                                    <td><?php echo $vval['document_name']; ?></td>
                                                    <td>
                                                        <?php
                                                        $condition = "";

                                                        if (!SHOW_DEMO) {

                                                            if (isset($get_file_status[0]['form_status']) && $get_file_status[0]['form_status'] == 1 && isset($get_file_status[0]['sa_form_status']) && $get_file_status[0]['sa_form_status'] == 1 ) {

                                                                $condition = 1;

                                                            } else {

                                                                $condition = 0;
                                                            }

                                                        } else {

                                                            if ($condition = isset($get_file_status[0]['form_status']) && $get_file_status[0]['form_status'] == 1) {

                                                                $condition = 1;

                                                            } else {

                                                                $condition = 0;
                                                            }
                                                        }

                                                        if ($condition) {
                                                            ?>
                                                            <label style="color: #008000;"><i class="fa fa-check" aria-hidden="true"></i>Approved</label>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <label style="color: #ff0d00"><i class="fa fa-cross" aria-hidden="true"></i>Not Approved</label>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $check_uploaded_form = $this->profile_model->checkUploadedForm($vval['document_name'], $vendor_id);

                                                        //if ($check_uploaded_form[0]['cnt'] != '1') {
                                                           // if (!isset($get_file_status[0]['form_no'])) {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>uploads/vendor/documents/<?php echo $vval['file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-download" aria-hidden="true"></i> Download Document</a> &nbsp;

                                                                <a href="<?php echo base_url(); ?>upload_vendor_files/<?php echo base64_encode($vval['id']) . "/" . base64_encode($vval['document_name']); ?>" style="color: #09274B;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Document</a>
                                                                <?php
                                                           // }
                                                        //}
                                                        ?>
                                                        &nbsp;

                                                        <?php
                                                        //print_r($get_file_status);
                                                        if (!empty($get_file_status)) {
                                                           //if (isset($get_file_status[0]['form_status']) && $get_file_status[0]['form_status'] == 1 && isset($get_file_status[0]['sa_form_status']) && $get_file_status[0]['sa_form_status'] == 1) {
                                                                if ($get_file_status[0]['file'] != '') {
                                                                    ?>
                                                                    <a href="<?php echo base_url(); ?>uploads/vendor_pdfs/<?php echo $get_file_status[0]['file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                                    <a href="<?php echo base_url(); ?>vendor-show-files/<?php echo base64_encode($get_file_status[0]['form_no']) . "/" . base64_encode($get_file_status[0]['vendor_id']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                    <?php
                                                                }
                                                           // }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_counter_files)) {
                                                            if ($get_counter_files[0]['file'] != '') {
                                                                ?>
                                                                <span><a
                                                                        href="<?php echo base_url(); ?>uploads/<?php echo $get_counter_files[0]['file']; ?>"
                                                                        class="fancybox" style="color: #09274B;"><i
                                                                            class="fa fa-download"
                                                                            aria-hidden="true"></i> Download Approved File</a></span>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>

                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tab-2" class="tab-content">
                                <table id="sign_docs_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Documents Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $docs_arr = array("1" => "ACH FORM", "2" => "COMPANY SUBCONTRACTOR AGREEMENT", "3" => "NDA FORM", "4" => "SUBCONTRACTOR MANDATORY INSURANCE REQUIREMENTS");
                                        if (!empty($get_details)) {
                                            $vendor_id = $get_details[0]['vendor_id'];
                                        }
                                        $i = 1;
                                        foreach ($docs_arr as $dkey => $dval) {
                                            $get_file_status = $this->profile_model->getFileStatus($dkey, $vendor_id);
                                            // print_r($get_file_status);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $dval; ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($get_file_status[0]['form_status']) && $get_file_status[0]['form_status'] == 1 && isset($get_file_status[0]['sa_form_status']) && $get_file_status[0]['sa_form_status'] == 1) {
                                                        ?>
                                                        <label style="color: #008000;"><i class="fa fa-check" aria-hidden="true"></i>Approved</label>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <label style="color: #ff0d00"><i class="fa fa-cross" aria-hidden="true"></i>Not Approved</label>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $check_uploaded_form = $this->profile_model->checkUploadedForm($dval, $vendor_id);
//                                                  
                                                    if ($check_uploaded_form[0]['cnt'] != '1') {

                                                        if (!isset($get_file_status[0]['form_no'])) {
                                                            ?>
                                                            <a href="<?php echo base_url('submit_documents') . "/" . base64_encode($dkey) . "/" . base64_encode($vendor_id); ?>" style="color: #09274B;"><i class="fa fa-view" aria-hidden="true"></i> View
                                                                and Submit</a>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    &nbsp;
                                                    <?php
                                                    //print_r($get_file_status);
                                                    if (!empty($get_file_status)) {
                                                        if (isset($get_file_status[0]['form_status']) && $get_file_status[0]['form_status'] == 1 && isset($get_file_status[0]['sa_form_status']) && $get_file_status[0]['sa_form_status'] == 1) {
                                                            if ($get_file_status[0]['file'] != '') {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>uploads/vendor_pdfs/<?php echo $get_file_status[0]['file']; ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>vendor-show-files/<?php echo base64_encode($get_file_status[0]['form_no']) . "/" . base64_encode($get_file_status[0]['vendor_id']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
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
        $('#sign_docs_tbl').DataTable();
    });
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

    })
</script>