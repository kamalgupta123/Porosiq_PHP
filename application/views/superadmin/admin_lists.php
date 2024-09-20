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
                Admin User
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Admin User</a></li>
                <li class="active">Admin Lists</li>
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
                                <a href="<?php echo base_url('add-admin-user'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Admin User</a>
                            </div>
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
                                        <th>Company Name</th>
                                        <th>Designation</th>
                                        <th>Email ID</th>
                                        <th>Phone No.</th>
                                        <th>Fax No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_admin_details) > 0) {

                                        foreach ($get_admin_details as $aval) {
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td>
                                                    <div id="img_div" style="height:60px;width:60px;">

                                                        <?php
                                                        if ($aval['file'] != '') {
                                                            $file_path = "uploads/admin/profile_pic/" . strtolower($aval['first_name']) . "_" . strtolower($aval['last_name']) . "/";
                                                            ?>
                                                            <img
                                                                src="<?php echo site_url() . $file_path . $aval['file']; ?>"
                                                                alt="User Image" class="img-circle"
                                                                style="width: 100%; max-height: 100%; object-fit: contain;">
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <img alt="User Image" class="img-circle"
                                                                 src="<?php echo site_url(); ?>assets/images/blank-profile.png"
                                                                 style="width: 100%;max-height: 100%; object-fit: contain;">
                                                                 <?php
                                                             }
                                                             ?>
                                                    </div>
                                                </td>

                                                <td>
                                                    <a href="<?php echo base_url('edit-admin-user/' . base64_encode($aval['admin_id'])); ?>">
                                                        <?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?>
                                                    </a>
                                                </td>
                                                <td><?php echo $aval['admin_company_name']; ?></td>
                                                <td><?php echo $aval['admin_designation']; ?></td>
                                                <td><?php echo $aval['admin_email']; ?></td>
                                                <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                <td><?php echo ($aval['fax_no'] != '0') ? $aval['fax_no'] : ''; ?></td>

                                                <td style="text-align: center;">
                                                    <a class="tbl_icon" href="<?php echo base_url('edit-admin-user/' . base64_encode($aval['admin_id'])); ?>" data-toggle="tooltip" title="Edit ">
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i>
                                                    </a>

                                                    <?php
                                                    if ($aval['block_status'] == '0') {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Block" onclick="changeBlockStatus('block', '<?php echo base64_encode($aval['admin_id']); ?>');"><i
                                                                class="fa fa-lock" aria-hidden="true"></i></a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Unblock" onclick="changeBlockStatus('unblock', '<?php echo base64_encode($aval['admin_id']); ?>');"><i
                                                                class="fa fa-unlock" aria-hidden="true" style="color: green;"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($aval['status'] == '1') {
                                                            ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Active" onclick="changeStatus('activate', '<?php echo base64_encode($aval['admin_id']); ?>');"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                           <?php
                                                       } else {
                                                           ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Deactive" onclick="changeStatus('deactivate', '<?php echo base64_encode($aval['admin_id']); ?>');">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>

                                                    <a class="tbl_icon" href="#<?php echo $aval['admin_id']; ?>" data-toggle="modal" title="View Admin Profile">
                                                        <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i>
                                                    </a>

                                                    <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUser('<?php echo base64_encode($aval['admin_id']); ?>');">
                                                        <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                    </a>

                                                    <!--                                                    <a class="tbl_icon" href="javascript:void(0)"
                                                                                                           data-toggle="tooltip" title="Delete User" onclick="deleteUser('<?php //echo base64_encode($aval['admin_id']);        ?>');">
                                                                                                            <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>
                                                                                                        </a>-->
                                                    <!-- Admin Details -->
                                                    <div class="modal fade" id="<?php echo $aval['admin_id']; ?>"
                                                         role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="box box-primary">
                                                                        <div class="box-body box-profile">
                                                                            <?php
                                                                            if ($aval['file'] != '') {
                                                                                $file_path = "uploads/admin/profile_pic/" . strtolower($aval['first_name']) . "_" . strtolower($aval['last_name']) . "/";
                                                                                ?>
                                                                                <img
                                                                                    class="profile-user-img img-responsive img-circle"
                                                                                    src="<?php echo site_url() . $file_path . $aval['file']; ?>"
                                                                                    alt="User Image">
                                                                                    <?php
                                                                                } else {
                                                                                    ?>
                                                                                <img alt="User Image"
                                                                                     class="profile-user-img img-responsive img-circle"
                                                                                     src="<?php echo base_url(); ?>assets/images/blank-profile.png">
                                                                                     <?php
                                                                                 }
                                                                                 ?>

                                                                            <h3 class="profile-username text-center"><?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?></h3>

                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <table id="vendor_tbl" class="table table-bordered table-striped table-responsive" style="font-size: 11px;">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><label>Email ID</label></td>
                                                                                                <td><?php echo $aval['admin_email']; ?></td>
                                                                                                <td><label>Employee ID</label></td>
                                                                                                <td><?php echo $aval['admin_employee_id']; ?></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Address</label></td>
                                                                                                <td><?php echo stripslashes($aval['address']); ?></td>
                                                                                                <td>&nbsp;</td>
                                                                                                <td>&nbsp;</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Phone No.</label></td>
                                                                                                <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                                                                <td><label>Fax No.</label></td>
                                                                                                <td><?php echo ($aval['fax_no'] != '0') ? $aval['fax_no'] : ''; ?></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!-- /.box-body -->
                                                                    </div>
                                                                    <!-- /.box -->
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
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

    function changeBlockStatus(type, id) {
        var bs_type = type;
        var admin_id = id;

        if (bs_type == 'block') {
            var type = 'Unblock';
        } else if (bs_type == 'unblock') {
            var type = 'Block';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Admin User?",
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
                    $.post("<?php echo site_url('change_block_status'); ?>", {bs_type: bs_type, admin_id: admin_id}, function (data) {
                        if (data == 1) {
                            var msg = 'Admin ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else
                        {
                            $(".succ-msg").hide();
                        }

                    });
                }
            }
        });



    }

    function changeStatus(type, id) {
        var bs_type = type;
        var admin_id = id;

        if (bs_type == 'activate') {
            var type = 'Deactivate';
        } else if (bs_type == 'deactivate') {
            var type = 'Activate';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Admin User?",
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
                    $.post("<?php echo site_url('change_status'); ?>", {bs_type: bs_type, admin_id: admin_id}, function (data) {
                        if (data == 1) {
                            var msg = 'Admin ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
//                                $('#admin_tbl').DataTable().clear().draw();
                            }, 1000);
                        } else
                        {
                            $(".succ-msg").hide();
                        }

                    });
                }
            }
        });



    }

    function deleteUser(id) {
        var admin_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Admin User?",
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
                    $.post("<?php echo site_url('delete-admin-user'); ?>", {admin_id: admin_id}, function (data) {
                        //console.log(data)
                        if (data == 1) {
                            var msg = 'Admin Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 0)
                        {
                            $(".succ-msg").hide();
                        } else if (data == 2)
                        {
                            var msg = 'OOPS !! Admin has vendor under him.';
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