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
    .morecontent span {
        display: none;
    }
    .morelink {
        display: block;
    }

    /*--------------------------------*/

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
                Project
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Projects</a></li>
                <li class="active">Project Lists</li>
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

                        <div class="box-body">
                            <div style="text-align: right">
                                <a href="<?php echo base_url('add-projects'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color: green;"></i> Add Projects</a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body table-responsive">
                            <table id="project_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">SL No.</th>
                                        <th>Admin Name</th>
                                        <th>Company Name</th>
                                        <th>Project Code</th>
                                        <th>Project Type</th>
                                        <th>Project Name</th>
                                        <th>Project Description</th>
                                        <th>Client Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>View Assigned Consultants</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (!empty($get_project_dtls)) {

                                        foreach ($get_project_dtls as $aval) {

                                            if ($aval['vendor_id'] != 0) {

                                                $vendor_name = "";
                                                $vendor_arr = $this->employee_model->getVendorsName($aval['vendor_id']);

//                                                echo "<pre>";
//                                                print_r($vendor_arr);
                                                if (!empty($vendor_arr)) {
                                                    foreach ($vendor_arr as $varr) {
                                                        //                                                        $j = 0;
                                                        $vendor_name .= $varr['vendor_company_name'] . "<hr>";
                                                        $get_admin_details = $this->employee_model->getAdminData($aval['admin_id']);
                                                        if (!empty($get_admin_details)) {
                                                            $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                            $admin_company_name = ucwords($get_admin_details[0]['admin_company_name']);
                                                        }
                                                    }
                                                }
                                                $check_name = "Consultant(s)";
                                            } else {
                                                $get_admin_details = $this->employee_model->getAdminData($aval['admin_id']);
                                                if (!empty($get_admin_details)) {
                                                    $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                }
                                                $vendor_name = ucwords($get_admin_details[0]['admin_company_name']);
                                                $check_name = "Employee(s)";
                                            }
                                            $get_count_employess = $this->employee_model->getCountEmployeesByProjects($aval['id']);


                                            if ($get_count_employess[0]['cnt'] != '') {
                                                $cnt_employees = $get_count_employess[0]['cnt'];
                                            } else {
                                                $cnt_employees = 0;
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><label><?php echo $admin_name; ?></label></td>
                                                <td><label><?php echo $vendor_name; ?></label></td>
                                                <td><label><?php echo $aval['project_code']; ?></label></td>
                                                <td><?php echo $aval['project_type']; ?></td>
                                                <td><label><?php echo $aval['project_name']; ?></label></td>
                                                <td width="30%">
                                                    <!--<span class="more">-->
                                                    <div style="text-overflow:ellipsis">

                                                        <?php
                                                        if (strlen($aval['project_details']) > 200) {
                                                            echo substr(preg_replace("/\r|n/", "", strip_tags(stripslashes($aval['project_details']))), 0, 150) . "..";
                                                        } else {
                                                            echo preg_replace("/\r|n/", "", strip_tags(stripslashes($aval['project_details'])));
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                                <td><?php echo $aval['client_name']; ?></td>
                                                <td><label><?php echo date("m-d-Y", strtotime($aval['start_date'])); ?></label></td>
                                                <td>
                                                    <label>
                                                        <?php
                                                        if ($aval['end_date'] != '0000-00-00') {
                                                            echo date("m-d-Y", strtotime($aval['end_date']));
                                                        }
                                                        ?>
                                                    </label>
                                                </td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('view_superadmin_consultant_details/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="View Consultant">
                                                        <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i> <span style="font-size: 12px; color: #09274B;">View</span>
                                                        <span class="badge"><?php echo $cnt_employees; ?> <?php echo $check_name; ?></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('edit-superamdin-projects/' . base64_encode($aval['id'])); ?>"
                                                       data-toggle="tooltip" title="Edit" style="color: #09274B;"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                    </a>
                                                    <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteProject('<?php echo base64_encode($aval['id']); ?>');">
                                                        <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                    </a>
                                                    <a href="#proj_<?php echo $aval['id']; ?>" data-toggle="modal" title="View" style="color: #09274B;font-size: 18px;"><i
                                                            class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <!-- Employee Details -->
                                                    <div class="modal fade" id="proj_<?php echo $aval['id']; ?>"
                                                         role="dialog">
                                                        <div class="modal-dialog" style="max-height: 600px;overflow-y: scroll;">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Project Details</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="box box-primary">
                                                                        <div class="">

                                                                            <div class="row">
                                                                                <div
                                                                                    class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <table id="vendor_tbl"
                                                                                           class="table table-bordered table-striped table-responsive"
                                                                                           style="font-size: 11px;">

                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td><label>Project Code</label></td>
                                                                                                <td>
                                                                                                    <?php echo $aval['project_code']; ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Project Type</label></td>
                                                                                                <td>
                                                                                                    <?php echo $aval['project_type']; ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Project Name</label></td>
                                                                                                <td>
                                                                                                    <?php echo stripslashes($aval['project_name']); ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Project Description</label></td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    echo preg_replace("/\r|n/", "", strip_tags(stripslashes($aval['project_details'])));
                                                                                                    ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Client Name</label></td>
                                                                                                <td>
                                                                                                    <?php echo $aval['client_name']; ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>Start Date</label></td>
                                                                                                <td>
                                                                                                    <?php echo date("m-d-Y", strtotime($aval['start_date'])); ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td><label>End Date</label></td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if ($aval['end_date'] != '0000-00-00') {
                                                                                                        echo date("m-d-Y", strtotime($aval['end_date']));
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
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
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

                                                        $(function () {
                                                            $('.alert').delay(5000).fadeOut('slow');
                                                        })

</script>
<script>
    $(function () {
        $('#project_tbl').DataTable();
    });

    $(document).ready(function () {
        // Configure/customize these variables.
        var showChar = 100;  // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function () {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function () {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });


    function deleteProject(id) {
        var project_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Consultant User?",
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
                    $.post("<?php echo site_url('delete-project'); ?>", {id: project_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Project Deleted Successfully';
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
                            var msg = 'OOPS !! This Project has already assigned to Someone.';
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
