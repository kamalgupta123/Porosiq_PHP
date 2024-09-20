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
                Access Log
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage User Account</a></li>
                <li class="active">Access Log</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="alert alert-success succ-msg" style="display: none;"></div>
                    <div class="alert alert-danger succ-err" style="display: none;"></div>
                    <div class="box">
                        <div class="box-body">
                            <table id="sadmin_tbl" class="table table-bordered table-striped" style="font-size: 12px;" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">SL No.</th>
                                        <th>Name</th>
                                        <th>User Email ID</th>
                                        <th>User Type</th>
                                        <th>User IP</th>
                                        <th>Login Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($get_access_log_details)) {
                                        $i = 1;
                                        $user_name = "";
                                        foreach ($get_access_log_details as $uval) {
                                            if ($uval['user_type'] == "superadmin") {
                                                $get_name = $this->profile_model->getSuperAdminData($uval['user_id']);
                                                if (!empty($get_name)) {
                                                    $user_name = ucwords($get_name[0]['sa_name']);
                                                }
                                            } elseif ($uval['user_type'] == "admin") {
                                                $get_name = $this->profile_model->getAdminData($uval['user_id']);
                                                if (!empty($get_name)) {
                                                    $user_name = ucwords($get_name[0]['first_name'] . " " . $get_name[0]['last_name']);
                                                }
                                            } elseif ($uval['user_type'] == "vendor") {
                                                $get_name = $this->profile_model->getVendorData($uval['user_id']);
                                                if (!empty($get_name)) {
                                                    $user_name = ucwords($get_name[0]['first_name'] . " " . $get_name[0]['last_name']);
                                                }
                                            } elseif ($uval['user_type'] == "consultant" || $uval['user_type'] == "employee") {
                                                $get_name = $this->profile_model->getEmployeeData($uval['user_id']);
                                                if (!empty($get_name)) {
                                                    $user_name = ucwords($get_name[0]['first_name'] . " " . $get_name[0]['last_name']);
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $user_name; ?></td>
                                                <td><?php echo $uval['user_email_id']; ?></td>
                                                <td><?php echo ucwords($uval['user_type']); ?></td>
                                                <td><?php echo $uval['user_ip']; ?></td>
                                                <td>
                                                    <?php
                                                        $date = new DateTime($uval['user_login_date_time']);
                                                        echo $date->format('m-d-Y H:i:s');
//                                                        echo date_format($uval['user_login_date_time'],"m/d/Y H:i:s"); 
                                                        ?>
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
        $('#sadmin_tbl').DataTable();
    });

</script>
<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    });

</script>

