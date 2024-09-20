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
                <li class="active"><a href="">Consultant Timesheet</a></li>
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
                            <h3 class="box-title">Consultant Timesheet</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                <thead>
                                <tr>
                                    <th>SL No.</th>
                                    <th>Photo</th>
                                    <th>Consultant Code</th>
                                    <th>Consultant Name</th>
                                    <th>Consultant Designation</th>
                                    <th>Email ID</th>
                                    <th>Phone No.</th>
                                    <th>Consultant Timesheet</th>
                                    <!--<th>Generate Invoice</th>-->
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i = 1;
                                if (count($get_employee_details) > 0) {

                                    foreach ($get_employee_details as $aval) {
                                        $has_timesheet = $this->employee_model->checkTimesheet($aval['employee_id']);
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
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
                                            <td><?php echo $aval['first_name'] . " " . $aval['last_name']; ?></td>
                                            <td><?php echo $aval['employee_designation']; ?></td>
                                            <td><?php echo $aval['employee_email']; ?></td>
                                            <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                            <td>
                                                <a class="tbl_icon"
                                                   href="<?php echo base_url('view_consultant_timesheet/' . base64_encode($aval['employee_id'])); ?>"
                                                   data-toggle="tooltip" title="View Consultants Timesheet" style="color: #09274B;"><i
                                                        class="fa fa-calendar" aria-hidden="true"></i></a>
                                            </td>
<!--                                            <td>
                                                <?php
                                                /*if($has_timesheet[0]['cnt'] > 0) {
                                                    ?>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('generate_vendor_consultant_invoice/' . base64_encode($aval['employee_id'])); ?>"
                                                       data-toggle="tooltip" title="Generate Invoice" style="color: #09274B;"><i
                                                            class="fa fa-credit-card" aria-hidden="true"></i></a>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <label style="color: red;">Consultant need to first add Timesheet.</label>
                                                    <?php
                                                }*/
                                                    ?>
                                            </td>-->
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
    $this->load->view('vendor/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
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