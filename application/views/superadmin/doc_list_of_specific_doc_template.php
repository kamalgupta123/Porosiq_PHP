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

    .fa-lock  {
        color: #f90000;
    }
    .fa-times  {
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
            <!-- Sidebar user panel -->

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
                Document
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i>Manage Document</a></li>
                <li class="active">Document List</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="admin_div">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
            <?php } ?>
            <div class="alert alert-success succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" style="display: none;">error</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">
                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url() . 'add-doc-in-specific-doc-template/' . base64_encode($doc_template_id); ?>" style="color: #09274B;">
                                    <i class="fa fa-plus" style="color: green;"></i> Add Document To This Template
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <!--Write your codes here-->
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <span class="glyphicon glyphicon-file"></span>
                                        Documents List for <b><?php echo $doc_template_name; ?></b>
                                    </h3>
                                </div>
							</div>

							 <div class="table-responsive">
                                    <table id="docs_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                        <thead>
                                            <tr>
                                                <th>Sl.</th>
                                                <th>Document Name</th>
                                                <th>Applicable Date</th>
                                                <th>Status</th>
                                                <th>View</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($document_list)) {

                                            foreach ($document_list as $each_document) { 

                                                if ($each_document['status'] == 1) {
                                                    $status = 'Active';
                                                } else if ($each_document['status'] == 2) {
                                                    $status = 'Archive';
                                                } else {
                                                    $status = '';
                                                }
                                                
                                                ?>
                                                <tr>
                                                	<td><?php echo $i; ?></td>
                                                	<td>
                                                        <?php echo $each_document['document_name']; ?>
                                                    </td>
                                                	<td>
                                                        <?php echo get_date_db_value($each_document['applicable_date']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $status; ?>
                                                    </td>
                                                	<td>
                                                        <a class="tbl_icon fancybox"
                                                            href="<?php echo base_url(); ?>uploads/template_documents/<?php echo $each_document['file']; ?>"
                                                            data-toggle="tooltip" title="View Document">
                                                            <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i>
                                                        </a>   
                                                    </td>
                                                	<td>
                                                        <a class="tbl_icon"
                                                        href="#"
                                                        data-toggle="tooltip" title="Edit ">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"
                                                            style="color: #09274B;"></i>
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
                        <!-- /.box-body -->
                    </div>
                    <a href="<?php echo site_url('document-template-list'); ?>" class="btn btn-default">Back</a>
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

    $(function () {
        $('#docs_tbl').DataTable({
            scrollX: true,
            scrollCollapse: true,
        });
    });
</script>