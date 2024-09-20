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
                Super Admin User
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Super Admin User</a></li>
                <li class="active">Super Admin Lists</li>
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

            <div class="alert alert-success succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" style="display: none;">error</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right"><a
                                    href="<?php echo base_url('add-super-admin-user'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Super Admin
                                    User</a></div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">SL No.</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($get_sa_lists)) {
                                        $i = 1;
                                        foreach ($get_sa_lists as $sval) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <div id="img_div" style="height:60px;width:60px;">

                                                        <?php
                                                        if ($sval['file'] != '') {
                                                            $file_path = "./uploads/";
                                                            ?>
                                                            <img
                                                                src="<?php echo base_url() . $file_path . $sval['file']; ?>"
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

                                                <td><?php echo ucwords($sval['sa_name']); ?></td>
                                                <td><?php echo $sval['sa_email']; ?></td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('edit-super-admin-user/' . base64_encode($sval['sa_id'])); ?>"
                                                       data-toggle="tooltip" title="Edit"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i></a>
                                                    <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteSuperAdmin('<?php echo base64_encode($sval['sa_id']); ?>');">
                                                        <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
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
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    function deleteSuperAdmin(id) {
        var sa_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Super Admin User?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result == true) {
                    $.post("<?php echo site_url('delete-superadmin-user'); ?>", {sa_id: sa_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Super Admin Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 0)
                        {
                            var msg = 'OOPS !! Something went wrong!';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 3)
                        {
                            var msg = 'OOPS !! Super Admin has some Admin under him.';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                    });
                }
            }
        });
    }
</script>