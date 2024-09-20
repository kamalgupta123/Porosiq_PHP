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
                Employee
                <small>Timesheet</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Employee Timesheet </a></li>
                <li class="active">Employee Lists</li>
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
            <div class="alert alert-success succ-msg" style="display: none;"></div>
            <div class="alert alert-danger succ-err" style="display: none;"></div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
<!--                                <a href="<?php // echo base_url('add-superadmin-employee-user');       ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Add Employee User</a>&nbsp;&nbsp;
                                <a href="<?php // echo base_url('assign-projects-to-superadmin-employee');       ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Assign Project To Employees</a>&nbsp;&nbsp;-->

                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-body">
                            <div class="">
                                <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Employee Name</th>
                                            <th>Timesheet</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($get_employee_details > 0)) {
                                            foreach ($get_employee_details as $aval) {
                                                $check_generate_status = $this->employee_model->getGenerateStatus($aval['employee_id']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') {
                                                            ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('view-superadmin-emp-timesheet/' . base64_encode($aval['employee_id'])); ?>"
                                                               data-toggle="tooltip" title="View Timesheet" style="color: #09274B;"><i
                                                                    class="fa fa-calendar" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
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
        $('#admin_tbl').DataTable({
            //scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
//            paging: false,

        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    function changeBlockStatus(type, id) {
        var bs_type = type;
        var employee_id = id;

        if (bs_type == 'block') {
            var type = 'Block';
        } else if (bs_type == 'unblock') {
            var type = 'Unlock';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Employee User?",
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
                    $.post("<?php echo site_url('change_employee_block_status'); ?>", {bs_type: bs_type, employee_id: employee_id}, function (data) {
                        //location.reload();
                        if (data == 1) {
                            var msg = 'Employee ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
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
        var employee_id = id;

        if (bs_type == 'activate') {
            var type = 'Activate';
        } else if (bs_type == 'deactivate') {
            var type = 'Deactivate';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Employee User?",
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
                    $.post("<?php echo site_url('change_employee_status'); ?>", {bs_type: bs_type, employee_id: employee_id}, function (data) {
                        if (data == 1) {
                            var msg = 'Employee ' + type + ' Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
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
        var employee_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Employee User?",
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
                    $.post("<?php echo site_url('delete-employee-user'); ?>", {employee_id: employee_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == '1') {
                            var msg = 'Employee Deleted Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == '0')
                        {
                            var msg = 'OOPS !! Something went wrong!';
                            $(".succ-err").show();
                            $(".succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == '3')
                        {
                            var msg = 'OOPS !! A Project has already assigned to Employee.';
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