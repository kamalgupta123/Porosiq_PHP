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
                Documents
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Documents</a></li>
                <li class="active">Documents Lists</li>
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

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <?php
                    //                            echo '<pre>';
                    //                            print_r($get_admin_details);
                    ?>
                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <?php if (DEMO) { ?>
                                    <a href="<?php echo site_url('document-template-list'); ?>"
                                    style="color: #09274B;"><i
                                            class="fa fa-list" style="color: green;"></i> Document Template List </a>&nbsp;&nbsp;
                                    <a href="<?php echo site_url('add-document-template'); ?>"
                                    style="color: #09274B;"><i
                                            class="fa fa-plus" style="color: green;"></i> Add Document Template</a>&nbsp;&nbsp;
                                <?php } ?>
                                <a href="<?php echo base_url('add_consultant_documentations'); ?>"
                                   style="color: #09274B;"><i
                                        class="fa fa-plus" style="color: green;"></i> Add Documents</a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th width="1%">SL No.</th>
                                    <th>Required For</th>
                                    <th>Document Name</th>
                                    <th>File</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if (count($get_documents_details) > 0) {

                                    foreach ($get_documents_details as $aval) {
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td>

                                                <?php
                                                $required_for_arr = array();
                                                $required_for_arr = explode(",", $aval['required_for']);
//                                                echo count($required_for_arr);
                                                if (!empty($required_for_arr) && count($required_for_arr) > 0) {
                                                    ?>
                                                    <ol>
                                                        <?php
                                                        foreach ($required_for_arr as $fval) {
                                                            ?>
                                                            <li>
                                                                <?php
                                                                if ($fval == 'C') {
                                                                    echo "Consultants" . "<br/>";
                                                                }
                                                                if ($fval == 'E') {
                                                                    echo "Employees" . "<br/>";
                                                                }
                                                                if (LATAM || $fval == 'TE') {
                                                                    echo "Temporary Employees" . "<br/>";
                                                                }
																
                                                                ?>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ol>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo stripslashes($aval['document_name']); ?></td>
                                            <td>
                                                <?php
                                                if ($aval['file'] != '') {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>"
                                                       class="fancybox" style="color: #09274B;"><i
                                                            class="fa fa-eye" aria-hidden="true"></i> View Document</a>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url(); ?>edit-consultant-documents/<?php echo base64_encode($aval['id']); ?>"
                                                   style="color: #09274B;"><i class="fa fa-edit" aria-hidden="true"></i></a>
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