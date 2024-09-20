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

    label {
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
                PTS Internal Files
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> PTS Internal Files</a></li>
                <li class="active">For Consultants/Employees</li>
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

            <div class="alert alert-success succ-msg" style="display: none;"></div>
            <div class="alert alert-danger succ-err" style="display: none;"></div>

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box" style="margin-top: 30px;">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add-consultant-internal-files'); ?>" style="color: #09274B;"><i
                                        class="fa fa-plus" style="color: green;"></i> Add Consultant/Employees Internal Files</a>
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
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Designation</th>
                                        <th>Category</th>
                                        <th>File Name</th>
                                        <th>File</th>
                                        <th>Consultants/Employees File</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_emp_internal_files_details > 0)) {

                                        foreach ($get_emp_internal_files_details as $aval) {
                                            $get_employee_login_details = $this->employee_model->getLoginDetails($aval['employee_id']);
                                            $get_employee_details = $this->employee_model->getEmployeeData($aval['employee_id']);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $get_employee_details[0]['employee_code']; ?></td>
                                                <td>
                                                    <?php echo $get_employee_details[0]['name_prefix'] . " " . $get_employee_details[0]['first_name'] . " " . $get_employee_details[0]['last_name']; ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    if (!empty($get_employee_login_details)) {
                                                        echo $get_employee_login_details[0]['consultant_email'];
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $get_employee_details[0]['employee_designation']; ?></td>
                                                <td>
                                                    <?php
                                                    if ($get_employee_details[0]['employee_category'] == '1') {
                                                        echo "W2";
                                                    } elseif ($get_employee_details[0]['employee_category'] == '2') {
                                                        echo "Subcontractor";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo $aval['docs_name'];
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($aval['file'] != '') {
                                                        ?>
                                                        <a class="tbl_icon fancybox"
                                                           href="<?php echo base_url(); ?>uploads/<?php echo $aval['file']; ?>"
                                                           data-toggle="tooltip" title="View "><i
                                                                class="fa fa-eye" aria-hidden="true"
                                                                style="color: #09274B;"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($aval['employee_internal_files'] != '') {
                                                        ?>
                                                        <a class="tbl_icon fancybox"
                                                           href="<?php echo base_url(); ?>uploads/<?php echo $aval['employee_internal_files']; ?>"
                                                           data-toggle="tooltip" title="View "><i
                                                                class="fa fa-eye" aria-hidden="true"
                                                                style="color: #09274B;"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                                                    <br/><br/>
                                                    <a class=""
                                                       href="<?php echo base_url('upload-consultant-signed-internal-files/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="Upload" style="color: #09274B;">
                                                        <i class="fa fa-upload" aria-hidden="true"></i> Upload Signed File
                                                    </a>
                                                </td>
                                                <td style="text-align: center;">
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('edit-consultant-internal-files/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="Edit "><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"
                                                            style="color: #09274B;"></i>
                                                    </a>
                                                    <?php
                                                    if ($aval['status'] == 0) {
                                                        ?>
                                                        <a class="tbl_icon"
                                                           href="javascript:void(0)"
                                                           data-toggle="tooltip" title="Send Mail" onclick="sendMail('<?php echo $aval['employee_id']; ?>', '<?php echo $aval['id']; ?>');"><i
                                                                class="fa fa-paper-plane" aria-hidden="true"
                                                                style="color: #09274B;"></i>
                                                        </a>
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
    function sendMail(emp_id, fid) {
        var employee_id = emp_id;
        var file_id = fid;

        bootbox.confirm({
            message: "Do You Want To Send Mail?",
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
                    $.post("<?php echo site_url('send_internal_files_mail'); ?>", {employee_id: employee_id, file_id: file_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Mail Send Successfully';
                            $(".succ-msg").show();
                            $(".succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else
                        {
                            var msg = 'Oops!! Something errors';
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