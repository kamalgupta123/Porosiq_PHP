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
                User Recovery
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage User Account</a></li>
                <li class="active">User Recovery</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="alert alert-success succ-msg" style="display: none;">success</div>
                    <div class="alert alert-danger succ-err" style="display: none;">error</div>
                    <div class="box">
                        <div class="box-body">

                            <ul class="tabs">
                                <li class="tab-link current" data-tab="tab-1"><label>Super Admin Lists</label></li>
                                <li class="tab-link" data-tab="tab-2"><label>Admin Lists</label></li>
                                <li class="tab-link" data-tab="tab-3"><label>Vendor Lists</label></li>
                                <li class="tab-link" data-tab="tab-4"><label>Consultant Lists</label></li>
                                <li class="tab-link" data-tab="tab-5"><label>Employee Lists</label></li>
                            </ul>

                            <div id="tab-1" class="tab-content current">
                                <table id="sadmin_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
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
                                        if (!empty($get_inactive_sadmin_details)) {
                                            $i = 1;
                                            foreach ($get_inactive_sadmin_details as $sval) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td>
                                                        <div id="img_div" style="height:60px;width:60px;">

                                                            <?php
                                                            if ($sval['file'] != '') {
                                                                $file_path = "./uploads/superadmin/profile_pic/" . strtolower($sval['sa_name']) . "/";
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
                                                    <td width="5%">
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Recover Account"
                                                           onclick="recoverAccount('0', 'superadmin', '<?php echo base64_encode($sval['sa_id']); ?>');">
                                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUserPermanently('superadmin', '<?php echo base64_encode($sval['sa_id']); ?>');">
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

                            <div id="tab-2" class="tab-content">
                                <table id="admin_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
                                            <th>Photo</th>
                                            <th>Name</th>
                                            <th>Company Name</th>
                                            <th>Email ID</th>
                                            <th>Phone No.</th>
                                            <th>Fax No.</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $j = 1;
                                        if (!empty($get_inactive_admin_details)) {

                                            foreach ($get_inactive_admin_details as $aval) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $j; ?></td>
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

                                                        <?php echo $aval['name_prefix'] . " " . $aval['first_name'] . " " . $aval['last_name']; ?>

                                                    </td>
                                                    <td><?php echo $aval['admin_company_name']; ?></td>
                                                    <td><?php echo $aval['admin_email']; ?></td>
                                                    <td><?php echo ($aval['phone_no'] != '0') ? $aval['phone_no'] : ''; ?></td>
                                                    <td><?php echo ($aval['fax_no'] != '0') ? $aval['fax_no'] : ''; ?></td>
                                                    <td style="text-align: center;" width="5%">
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Recover Account"
                                                           onclick="recoverAccount('0', 'admin', '<?php echo base64_encode($aval['admin_id']); ?>');">
                                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUserPermanently('admin', '<?php echo base64_encode($aval['admin_id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $j++;
                                            }
                                        }
                                        ?>

                                    </tbody>

                                </table>
                            </div>

                            <div id="tab-3" class="tab-content">
                                <table id="vendor_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
                                            <th>Admin Name</th>
                                            <th>Company Logo</th>
                                            <th>Vendor Name</th>
                                            <th>Vendor Email ID</th>
                                            <th>Phone No.</th>
                                            <th>Contract From Date</th>
                                            <th>Contract To Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $v = 1;
                                        if (count($get_inactive_vendor_details > 0)) {

                                            foreach ($get_inactive_vendor_details as $vval) {

                                                $get_admin_details = $this->vendor_model->getAdminDetails($vval['admin_id']);
                                                if (!empty($get_admin_details)) {
                                                    $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                                }
                                                // print_r($employee_details);
                                                ?>
                                                <tr>
                                                    <td><?php echo $v; ?></td>
                                                    <td><?php echo $admin_name; ?></td>
                                                    <td>
                                                        <div id="img_div" style="height:60px;width:60px;">

                                                            <?php
                                                            if ($vval['photo'] != '') {
                                                                ?>
                                                                <img
                                                                    src="<?php echo base_url(); ?>uploads/<?php echo $vval['photo']; ?>"
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
                                                    <td>
                                                        <a href="<?php echo base_url('edit-vendor-user/' . base64_encode($vval['vendor_id'])); ?>">
                                                            <?php echo $vval['name_prefix'] . " " . $vval['first_name'] . " " . $vval['last_name']; ?>
                                                        </a>
                                                    </td>
                                                    <td><?php echo $vval['vendor_email']; ?></td>
                                                    <td><?php echo ($vval['phone_no'] != '0') ? $vval['phone_no'] : ''; ?></td>
                                                    <td><?php echo $vval['contract_from_date']; ?></td>
                                                    <td><?php echo $vval['contract_to_date']; ?></td>
                                                    <td style="text-align: center;" width="5%">
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Recover Account"
                                                           onclick="recoverAccount('0', 'vendor', '<?php echo base64_encode($vval['vendor_id']); ?>');">
                                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUserPermanently('vendor', '<?php echo base64_encode($vval['vendor_id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $v++;
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table> 
                            </div>

                            <div id="tab-4" class="tab-content">
                                <table id="con_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
                                            <th>Admin Name</th>
                                            <th>Vendor Name</th>
                                            <th>Photo</th>
                                            <th>Consultant Code</th>
                                            <th>Consultant Name</th>
                                            <th>Consultant Email</th>
                                            <th>Consultant Designation</th>
                                            <th>Consultant Category</th>
                                            <th>Phone No.</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $c = 1;
                                        if (!empty($get_inactive_con_details)) {

                                            foreach ($get_inactive_con_details as $cval) {
                                                $admin_arr = $this->employee_model->getAdminName($cval['admin_id']);
                                                $vendor_arr = $this->employee_model->getVendorName($cval['vendor_id']);
                                                $get_employee_login_details = $this->employee_model->getLoginDetails($cval['employee_id']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $c; ?></td>
                                                    <td>

                                                        <?php
                                                        if (!empty($admin_arr)) {
                                                            echo ucwords($admin_arr[0]['name_prefix']) . " " . ucwords($admin_arr[0]['first_name']) . " " . ucwords($admin_arr[0]['last_name']);
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>

                                                        <?php
                                                        if (!empty($vendor_arr)) {
                                                            echo $vendor_arr[0]['name_prefix'] . " " . $vendor_arr[0]['first_name'] . " " . $vendor_arr[0]['last_name'];
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <div id="img_div" style="height:60px;width:60px;">

                                                            <?php
                                                            if ($cval['file'] != '') {
                                                                ?>
                                                                <img
                                                                    src="<?php echo base_url(); ?>uploads/<?php echo $cval['file']; ?>"
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
                                                    <td><?php echo $cval['employee_code']; ?></td>
                                                    <td>

                                                        <?php echo $cval['name_prefix'] . " " . $cval['first_name'] . " " . $cval['last_name']; ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_employee_login_details)) {
                                                            echo $get_employee_login_details[0]['consultant_email'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $cval['employee_designation']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($cval['employee_category'] == '1') {
                                                            echo "W2";
                                                        } elseif ($cval['employee_category'] == '2') {
                                                            echo "Subcontractor";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo ($cval['phone_no'] != '0') ? $cval['phone_no'] : ''; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($cval['resume_file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $cval['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i> </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;" width="5%">
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Recover Account"
                                                           onclick="recoverAccount('0', 'consultant', '<?php echo base64_encode($cval['employee_id']); ?>');">
                                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUserPermanently('consultant', '<?php echo base64_encode($cval['employee_id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $c++;
                                            }
                                        }
                                        ?>

                                    </tbody>

                                </table>
                            </div>

                            <div id="tab-5" class="tab-content">
                                <table id="emp_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="1%">SL No.</th>
                                            <th>Admin Name</th>
                                            <th>Photo</th>
                                            <th>Consultant Code</th>
                                            <th>Consultant Name</th>
                                            <th>Consultant Email</th>
                                            <th>Consultant Designation</th>
                                            <th>Consultant Category</th>
                                            <th>Phone No.</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $c = 1;
                                        if (!empty($get_inactive_emp_details)) {

                                            foreach ($get_inactive_emp_details as $eval) {
                                                $admin_arr = $this->employee_model->getAdminName($eval['admin_id']);
                                                $get_employee_login_details = $this->employee_model->getLoginDetails($eval['employee_id']);
                                                ?>
                                                <tr>
                                                    <td><?php echo $c; ?></td>
                                                    <td>

                                                        <?php
                                                        if (!empty($admin_arr)) {
                                                            echo ucwords($admin_arr[0]['name_prefix']) . " " . ucwords($admin_arr[0]['first_name']) . " " . ucwords($admin_arr[0]['last_name']);
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <div id="img_div" style="height:60px;width:60px;">

                                                            <?php
                                                            if ($eval['file'] != '') {
                                                                ?>
                                                                <img
                                                                    src="<?php echo base_url(); ?>uploads/<?php echo $eval['file']; ?>"
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
                                                    <td><?php echo $eval['employee_code']; ?></td>
                                                    <td>

                                                        <?php echo $eval['name_prefix'] . " " . $eval['first_name'] . " " . $eval['last_name']; ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_employee_login_details)) {
                                                            echo $get_employee_login_details[0]['consultant_email'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $eval['employee_designation']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($eval['employee_category'] == '1') {
                                                            echo "W2";
                                                        } elseif ($eval['employee_category'] == '2') {
                                                            echo "Subcontractor";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo ($eval['phone_no'] != '0') ? $eval['phone_no'] : ''; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($eval['resume_file'] != '') {
                                                            ?>
                                                            <a href="<?php echo base_url(); ?>uploads/<?php echo $eval['resume_file']; ?>" class="fancybox"><i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red; font-size: 20px;"></i> </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align: center;" width="5%">
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Recover Account"
                                                           onclick="recoverAccount('0', 'employee', '<?php echo base64_encode($eval['employee_id']); ?>');">
                                                            <i class="fa fa-repeat" aria-hidden="true"></i>
                                                        </a>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUserPermanently('employee', '<?php echo base64_encode($eval['employee_id']); ?>');">
                                                            <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php
                                                $c++;
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
        $('#admin_tbl').DataTable();
        $('#vendor_tbl').DataTable();
        $('#con_tbl').DataTable();
        $('#emp_tbl').DataTable();
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
</script>

<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>
    function recoverAccount(del_value, type, id) {
        var del_val = del_value;
        var user_type = type;
        var user_id = id;

        bootbox.confirm({
            message: "Do You Want To Recover Account?",
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
                    $.post("<?php echo site_url('recover_user_account'); ?>", {
                        del_val: del_val,
                        user_type: user_type,
                        user_id: user_id
                    }, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Account Recovered Successfully';
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
                        }
                    });
                }
            }
        });
    }

    function deleteUserPermanently(type, id) {
        var user_type = type;
        var user_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete User Account Permamnently?",
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
                    $.post("<?php echo site_url('per_delete_user_account'); ?>", {
                        user_type: user_type,
                        user_id: user_id
                    }, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Account Deleted Successfully';
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
                        }
                    });
                }
            }
        });
    }
</script>
