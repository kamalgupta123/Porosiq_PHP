<?php
$this->load->view('admin/includes/header');
//echo "<pre>";
//print_r($get_admin_data);
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
                Purchase Order
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Purchase Order </a></li>
                <li class="active">Purchase Order List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                Purchase Order List
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
                            </h3>
                        </div>

                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <a href="<?php echo base_url('add_purchase_order_form'); ?>" style="color: #09274B; float:right; margin-bottom:10px;"><i class="fa fa-plus" style="color: green;"></i> Add Purchase Order</a>

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2" id="purchase_order_list">
                                            <thead>
                                                <tr>
                                                    <th>PO Number</th>
                                                    <th>Store Id</th>
                                                    <th>Date</th>
                                                    <th>Vendor Name</th>
                                                    <th>View File</th>
                                                    <th>Supporting Documents</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($get_purchase_order_list as $purchase_order) { ?>
                                                <tr>
                                                    <td><?php echo $purchase_order->PONumber; ?></td>
                                                    <td><?php echo $purchase_order->Store; ?></td>
                                                    <td><?php echo $purchase_order->Date; ?></td>
                                                    <td><?php echo $purchase_order->vendor_name; ?></td>
                                                    <td><a href="<?php echo base_url('uploads/admin/purchase_order/'.$purchase_order->poFilePath); ?>" class="fancybox"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                                    <td><a href="<?php echo base_url('uploads/admin/supporting_doc/'.$purchase_order->sdFilePath); ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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
        // $("#edit_employee_form").validationEngine({promptPosition: 'inline'});
        $('#purchase_order_list').DataTable();
    });
    // $(function () {
    //     $('#date_of_joining').datepicker(
    //             {
    //                 format: 'mm/dd/yyyy'
    //             }
    //     );
    // });

</script>
