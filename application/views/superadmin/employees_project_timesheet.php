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
                Consultant
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Consultant</a></li>
                <li class="active">Consultant Timesheet</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="text-align: left;line-height: 1px;font-size: 12px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: left;">

                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <label>Consultant Code
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['employee_code']; ?>
                                    <hr/>
                                    <label>Consultant Name
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['first_name']." ".$get_employee_details[0]['last_name']; ?>
                                    <hr/>
                                    <label>Consultant Designation
                                        : </label> &nbsp;<?php echo $get_employee_details[0]['employee_designation']; ?>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6">
                                    <?php
                                    if(!empty($get_vendor_details)) {
                                        ?>
                                        <label>Vendor Name
                                            : </label> &nbsp;<?php echo $get_vendor_details->name_prefix . " " . $get_vendor_details->first_name . " " . $get_vendor_details->last_name; ?>
                                        <hr/>
                                        <label>Company
                                            Name: </label> &nbsp;<?php echo $get_vendor_details->vendor_company_name; ?>
                                        <hr/>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Employee Timesheets</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body tab-div">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Project Details</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Approx. Total Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_project_details > 0)) {

                                        foreach ($get_project_details as $pval) {
                                            $get_prj_details = $this->employee_model->getProjectData($pval['project_id']);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $get_prj_details[0]['project_code']; ?></td>
                                                <td><?php echo $get_prj_details[0]['project_type']; ?></td>
                                                <td><?php echo $get_prj_details[0]['project_name']; ?></td>
                                                <td><?php echo stripslashes($get_prj_details[0]['project_details']); ?></td>
                                                <td><?php echo date("m-d-Y", strtotime($get_prj_details[0]['start_date'])); ?></td>
                                                <td><?php echo date("m-d-Y", strtotime($get_prj_details[0]['end_date'])); ?></td>
                                                <td><?php echo $get_prj_details[0]['approx_total_time']; ?></td>
                                                <td style="text-align: center;">
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_superadmin_project_timesheet/' . base64_encode($pval['project_id']) . '/' . base64_encode($get_employee_details[0]['employee_id'])); ?>"
                                                       data-toggle="tooltip" title="View Timesheet" style="color: #09274B;"><i
                                                            class="fa fa-eye" aria-hidden="true"></i></a>
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
<input type="button" value="Back" class="btn btn-default" onclick="window.history.back();">
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
