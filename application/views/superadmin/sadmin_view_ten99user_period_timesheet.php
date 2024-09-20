<?php
$this->load->view('superadmin/includes/header');

//echo'<pre>';print_r($get_timesheet_details);exit;
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
    .dataTables_filter{
        display: none;
    }

    tfoot {
        display: table-header-group;
    }
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
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
                Timesheet
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Timesheet</a></li>
                <li class="active">1099 User Timesheet</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content" id="super_admin_tbl">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div
                    class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div
                    class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                <?php } ?>

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">
                    <div class="box">
                        <form id="timesheet_table" action="<?php echo site_url('sadmin_approve_disapprove_ten99user_timesheet_period'); ?>" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div>
                                    <table class="table table-bordered table-striped" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">Timesheet ID</th>
                                                <th style="text-align: center;">Project Code</th>
                                                <th style="text-align: center;">Project Name</th>
                                                <th style="text-align: center;">Code</th>
                                                <th style="text-align: center;">Name</th>
                                                <th style="text-align: center;">Type</th>
                                                <th style="text-align: center;">Start Date</th>
                                                <th style="text-align: center;">End Date</th>
                                                <th style="text-align: center;">ST</th>
                                                <th style="text-align: center;">OT</th>
                                                <th style="text-align: center;">Consultant Comment</th>
                                                <?php
                                                if (!empty($get_timesheet_details)) {
                                                    if (!empty($get_timesheet_details[0]['sadmin_comment'])) {
                                                        ?>
                                                        <th style="text-align: center;">Superadmin Comment</th>
                                                        <?php
                                                    }
                                                    if (!empty($get_timesheet_details[0]['admin_comment'])) {
                                                        ?>
                                                        <th style="text-align: center;">Admin Comment</th>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <th style="text-align: center;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $start_date = "";
                                            $end_date = "";
                                            $st = "";
                                            $ot = "";
                                            $sadmin_comment = "";
                                            if (!empty($get_timesheet_details)) {
                                                foreach ($get_timesheet_details as $tkey => $tvalue) {

                                                    $get_project_data = $this->employee_model->getProjectData($tvalue['project_id']);
                                                    $get_employee_data = $this->employee_model->getEmployeeData($tvalue['employee_id']);

                                                    $cal_st = $this->employee_model->getTotalST($tvalue['id']);
                                                    $cal_ot = $this->employee_model->getTotalOT($tvalue['id']);

                                                    $period_arr = explode("~", $tvalue['period']);
                                                    $start_date = date("m-d-Y", strtotime($period_arr[0]));
                                                    $end_date = date("m-d-Y", strtotime($period_arr[1]));
                                                    $sadmin_comment = stripslashes($tvalue['sadmin_comment']);
                                                    ?>
                                                    <tr>
                                                        <td><label><?php echo $tvalue['timesheet_id']; ?></label></td>
                                                        <td><?php echo $get_project_data[0]['project_code']; ?></td>
                                                        <td><?php echo $get_project_data[0]['project_name']; ?></td>
                                                        <td><?php echo $get_employee_data[0]['employee_code']; ?></td>
                                                        <td><?php echo $get_employee_data[0]['first_name'] . " " . $get_employee_data[0]['last_name']; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($get_employee_data[0]['employee_type'] == 'C') {
                                                                echo "Consultant";
                                                            } elseif ($get_employee_data[0]['employee_type'] == 'E') {
                                                                echo "Employee";
                                                            }else {echo "1099 User";}
                                                            ?>
                                                        </td>
                                                        <td><?php echo $start_date; ?></td>
                                                        <td><?php echo $end_date; ?></td>
                                                        <td><?php echo number_format($cal_st[0]['tot_time'], 2); ?></td>
                                                        <td><?php echo number_format($cal_ot[0]['over_time'], 2); ?></td>
                                                        <td>
                                                            <?php
                                                            echo stripslashes($tvalue['comment']);
                                                            ?>
                                                        </td>
                                                        <?php
                                                        if (!empty($get_timesheet_details)) {
                                                            if (!empty($get_timesheet_details[0]['sadmin_comment'])) {
                                                                ?>
                                                                <td>
                                                                    <?php
                                                                    echo stripslashes($tvalue['sadmin_comment']);
                                                                    ?>
                                                                </td>
                                                                <?php
                                                            }
                                                            if (!empty($get_timesheet_details[0]['admin_comment'])) {
                                                                ?>
                                                                <td>
                                                                    <?php
                                                                    echo stripslashes($tvalue['admin_comment']);
                                                                    ?>
                                                                </td>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <td>
                                                            <?php
                                                            if ($tvalue['status'] == '0') {
                                                                ?>
                                                                <span style="color: red;">Not Approved</span>
                                                                <?php
                                                            } elseif ($tvalue['status'] == '1') {
                                                                ?>
                                                                <span style="color: green;">Approved</span>
                                                                <?php
                                                            } elseif ($tvalue['status'] == '2') {
                                                                ?>
                                                                <span style="color: #f39c12;">Pending Approval</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <table class="table table-bordered table-striped tbl-checked" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox"></th>
                                                <th>Day</th>
                                                <th>Date</th>
                                                <th>ST/Hr</th>
                                                <th>OT/Hr</th>
                                                <th>Status</th>                                                
                                                <!--<th>Action</th>-->                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($get_timesheet_period_details)) {
                                                foreach ($get_timesheet_period_details as $pval) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="timesheet_period_id" value="<?php echo $pval['timesheet_period_id']; ?>">
                                                            <input type="hidden" name="employee_id" value="<?php echo $pval['employee_id']; ?>">
                                                            <input type="hidden" name="project_id" value="<?php echo $pval['project_id']; ?>">
                                                            <input type="checkbox" name="check[]" class="chk" value="<?php echo $pval['id']; ?>" <?php if ($pval['approved_by_status'] == '1') { ?> checked="checked" <?php } ?>>
                                                        </td>
                                                        <td><?php echo date("l", strtotime($pval['project_date'])); ?></td>
                                                        <td><?php echo date("m-d-Y", strtotime($pval['project_date'])); ?></td>
                                                        <td><input type="text" name="tot_time_<?php echo $pval['id']; ?>" value="<?php echo $pval['tot_time']; ?>"></td>
                                                        <td><input type="text" name="over_time_<?php echo $pval['id']; ?>" value="<?php echo $pval['over_time']; ?>"></td>
                                                        <td>
                                                            <?php
                                                            if ($pval['approved_by_status'] == '0') {
                                                                ?>
                                                                <span style="color: red;">Not Approved</span>
                                                                <?php
                                                            } elseif ($pval['approved_by_status'] == '1') {
                                                                ?>
                                                                <span style="color: green;">Approved</span>
                                                                <?php
                                                            } elseif ($pval['approved_by_status'] == '2') {
                                                                ?>
                                                                <span style="color: #f39c12;">Pending Approval</span>
                                                                <?php
                                                            }
                                                            ?>
                                                        </td>
        <!--                                                        <td>
                                                            <a href="<?php // echo base_url();              ?>save-timesheet/<?php // echo base64_encode($pval['timesheet_period_id']) . '/' . base64_encode($pval['employee_id']) . '/' . base64_encode($pval['project_id']);              ?>" style="color: #09274B;" title="Edit">
                                                                <i class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i>
                                                            </a>
                                                        </td>-->
                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td width="8%"><label>Comment</label> <span style="color: red;">*</span>
                                                </td>
                                                <td width="22%" align="center">
                                                    <textarea name="sadmin_comment" id="sadmin_comment" class="form-control validate[required]" rows="2" style="resize: none;height: 35px !important;"><?php echo $sadmin_comment; ?></textarea>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="box-header">
                                        <div style="float: left;">
                                            <input type="button" value="Approved" class="btn btn-success approve" style="font-size: 12px;" onclick="return checkStatus('approve');">
                                            <input type="button" value="Disapproved" class="btn btn-danger disapprove" style="font-size: 12px;"  onclick="return checkStatus('disapprove');">
                                            <input type="button" value="Save" class="btn btn-info save" style="font-size: 12px;" onclick="return saveData('save');">
                                            <input type="hidden" name="ad" value="" id="ad">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </form>
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
        $("#timesheet_table").validationEngine({promptPosition: 'inline'});
    });


</script>

<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })

</script>
<script>
    $(function () {
        $('#super_admin_tbl').DataTable({
            //scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
//            paging: false,

        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/jquery.tablecheckbox.js"></script>
<script>
    $(function () {
        //alert("sdf");
        $('.tbl-checked').tablecheckbox();
    });
    $(document).ready(function () {
        // you should use id on form too, this will bug if you have more forms on your page
        $(".approve").on('click', function (event) {
            //alert("dfs");
            if ($(".tbl-checked .chk:checked").length === 0) {
                event.preventDefault();
                //alert user here
                alert('You Need To Select At Least One Checkbox');
            }
        });
        $(".disapprove").on('click', function (event) {
            //alert("dfs");
            if ($(".tbl-checked .chk:checked").length === 0) {
                event.preventDefault();
                //alert user here
                alert('You Need To Select At Least One Checkbox');
            }
        });
        $(".save").on('click', function (event) {
            //alert("dfs");
            if ($(".tbl-checked .chk:checked").length === 0) {
                event.preventDefault();
                //alert user here
                alert('You Need To Select At Least One Checkbox');
            }
        });
    });
</script>
<script>
    $(function () {
        $("#start_date").datepicker({
            format: 'mm/dd/yyyy'
        });
        $("#end_date").datepicker({
            format: 'mm/dd/yyyy'
        });
    });
</script>
<script>

    $(function () {
        $('.alert').delay(5000).fadeOut('slow');
    })
    $(document).ready(function () {

        $('ul.tabs li').click(function () {
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.tab-content').removeClass('current');

            $(this).addClass('current');
            $("#" + tab_id).addClass('current');
        })

    })

    function checkStatus(type) {
        var type = type;
        if (type == "approve") {
            var msg = "Approved";
            $("#ad").val("Approved");
        } else if (type == "disapprove") {
            var msg = "Disapproved";
            $("#ad").val("Disapproved");
        }

        bootbox.confirm({
            message: "Do You Want To " + msg + " The timesheet?",
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
                    $("#timesheet_table").submit();
                    return true;
                } else {
//                    alert("here1");
                    return true;
                }
            }
        });
    }
    
     function saveData(type) {
        var type = type;
        if (type == "save") {
            var msg = "Save";
            $("#sadmin_comment").removeAttr("class");
            $("#sadmin_comment").addClass("form-control");
            $("#ad").val("Save");
        }

        bootbox.confirm({
            message: "Do You Want To " + msg + " The timesheet?",
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
                    $("#timesheet_table").submit();
                    return true;
                } else {
//                    alert("here1");
                    return true;
                }
            }
        });
    }
</script>

<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>