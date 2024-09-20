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
                Menu Permission
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Permission</a></li>
                <li class="active">Menu Permission</li>
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

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Menu Permission for <?php echo ucwords($get_superadmin_details[0]['sa_name']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form id="add_admin_form"
                                  action="<?php echo site_url('insert_superadmin_menu'); ?>"
                                  method="post" enctype="multipart/form-data">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="50%" colspan="2">
                                                        <label for="email" style="text-decoration: underline;">Menu Name</label>
                                                    </td>
                                                    <td width="50%" colspan="2">
                                                        <label for="email" style="text-decoration: underline;">Is View</label>
                                                    </td>
                                                </tr>
                                                <?php
                                                if (!empty($get_menu)) {
                                                    $m = 0;
                                                    foreach ($get_menu as $mval) {
                                                        ?>
                                                        <tr>
                                                            <td width="50%" colspan="2">
                                                                <label for="email"><?php echo ucwords($mval['menu_name']); ?></label>
                                                            </td>
                                                            <td width="50%" colspan="2">
                                                                <select name="is_view[]" class="form-control">
                                                                    <option value="<?php echo $mval['id']; ?>_0" <?php if (!empty($get_permission_details) && $get_permission_details[$m]['is_view'] == '0') { ?> selected="selected" <?php } ?>>No</option>
                                                                    <option value="<?php echo $mval['id']; ?>_1" <?php if (!empty($get_permission_details) && $get_permission_details[$m]['is_view'] == '1') { ?> selected="selected" <?php } ?>>Yes</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $m++;
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <input class="btn btn-success" type="hidden" name="sa_id" value="<?php echo $get_superadmin_details[0]['sa_id']; ?>">
                                                        <input class="btn btn-success" type="hidden" name="sa_name" value="<?php echo $get_superadmin_details[0]['sa_name']; ?>">
                                                        <input class="btn btn-success" type="submit" name="submit" value="Save">
                                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                                    </td>
                                                    <td colspan="2">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
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