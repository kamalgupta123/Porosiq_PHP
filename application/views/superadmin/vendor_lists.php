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
                Vendor
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Vendor User</a></li>
                <li class="active">Vendor Lists</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">
            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div
                    class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div
                    class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                <?php } ?>
            <div class="alert alert-success succ-msg" id="succ-msg" style="display: none;">success</div>
            <div class="alert alert-danger succ-err" id="succ-err" style="display: none;">Error</div>
            <!-- Main row -->
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="box">

                        <div class="panel panel-default">
                            <div class="panel-body" style="text-align: right">
                                <a href="<?php echo base_url('add-vendor-user'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Add Vendor User(Full Details)</a>
                                &nbsp;&nbsp;
                                <a href="<?php echo base_url('add-vendor-user-sd'); ?>" style="color: #09274B;"><i class="fa fa-plus" style="color:green;"></i> Add Vendor User(Short Details)</a>
                            </div>
                        </div>
                    </div>

                    <div class="box">
                        <div class="box-body">
                            <table id="vendor_tbl" class="table table-bordered table-striped" style="font-size: 11px;" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%" >SL No.</th>
                                        <th>Admin Name</th>
                                        <th>Company Logo</th>
                                        <th>Point Of Contact</th>
                                        <th>Company Name</th>
                                        <th>Vendor Email ID</th>
                                        <th>Phone No.</th>
                                        <th>Contract Start Date</th>
                                        <th>Contract End Date</th>
                                        <th>No. of Consultants</th>
                                        <th>Documents Verified</th>
										<th>Vendor Documents</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if (count($get_vendor_details ) > 0 ) {

                                        foreach ($get_vendor_details as $vval) {

//                                            $this->load->model('superadmin/manage_vendor_model', 'vendor_model');
                                            $country_arr = $this->vendor_model->getCountryName($vval['country']);
                                            $state_arr = $this->vendor_model->getStateName($vval['state']);
                                            $city_arr = $this->vendor_model->getCityName($vval['city']);
                                            $get_vendor_files = $this->vendor_model->getVendorFiles($vval['vendor_id']);
                                            $get_no_of_employess = $this->vendor_model->getNoEmployees($vval['vendor_id']);
                                            $employee_details = $this->vendor_model->getEmpDetails($vval['vendor_id']);
                                            $get_admin_details = $this->vendor_model->getAdminDetails($vval['admin_id']);
											$check_generate_status = $this->vendor_model->getGenerateStatus($vval['vendor_id']);
											
                                            if (!empty($get_admin_details)) {
                                                $admin_name = $get_admin_details[0]['first_name'] . " " . $get_admin_details[0]['last_name'];
                                            }
                                            // print_r($employee_details);
                                            ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
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
                                                <td><?php echo $vval['vendor_company_name']; ?></td>
                                                <td><?php echo $vval['vendor_email']; ?></td>
                                                <td>
                                                    <?php echo (($vval['phone_no'] != '0') ? $vval['phone_no'] : ''); ?>
                                                    <br/>
                                                    <?php echo "Ext - " . (($vval['phone_ext'] != '0') ? $vval['phone_ext'] : ''); ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($vval['contract_from_date'] != '0000-00-00') {
                                                        echo date("m-d-Y", strtotime($vval['contract_from_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($vval['contract_to_date'] != '0000-00-00') {
                                                        echo date("m-d-Y", strtotime($vval['contract_to_date']));
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php echo $get_no_of_employess[0]['cnt']; ?>
                                                    <br/>
                                                    <a href="#employee_<?php echo $vval['vendor_id']; ?>"
                                                       data-toggle="modal" title="View Consultant(s)"
                                                       style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i>
                                                        View Consultant(s)</a>
                                                </td>
                                                <td>
                                                    <?php
//                                                    if (count($get_vendor_files) == '6') {
                                                    ?>
                                                    <span>
                                                        <a href="#docs_<?php echo $vval['vendor_id']; ?>"
                                                           data-toggle="modal" title="View Documents" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View Documents</a>
                                                    </span>
                                                    <?php
//                                                    }
                                                    ?>
                                                </td>
												<td>
                                                    <?php
                                                        if (!empty($check_generate_status) && $check_generate_status[0]['cnt'] == '1') { 
                                                           ?>
                                                            <a class="tbl_icon"
                                                               href="<?php echo base_url('view_superadmin_vendor_documents/' . base64_encode($vval['vendor_id'])); ?>"
                                                               data-toggle="tooltip" title="Upload Vendor Documents" style="color: #09274B;"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
                                                                <?php
                                                            }
                                                    ?>
                                                </td>
                                                <td style="text-align: center;">

                                                    
                                                     <?php
                                                    if (!empty($get_vendor_files)) {
                                                        ?>
                                                        <a class="tbl_icon"
                                                           href="<?php echo base_url('sa_verify_vendor_documents/' . base64_encode($vval['vendor_id'])); ?>"
                                                           data-toggle="tooltip" title="Verify Vendor Documents "><i
                                                                class="fa fa-file-text-o" aria-hidden="true" style="color: #09274B;"></i>
                                                        </a>
                                                        <?php
                                                    }
                                                    ?>
                            <?php if($super_admin_email !='aurica@procuretechstaff.com') {?>
                                                    <a class="tbl_icon"
                                                       href="<?php echo base_url('edit-vendor-user/' . base64_encode($vval['vendor_id'])); ?>"
                                                       data-toggle="tooltip" title="Edit "><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true" style="color: #09274B;"></i></a>

                                                    

                                                    <?php
                                                    if ($vval['block_status'] == '0') {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Block"
                                                           onclick="changeBlockStatus('block', '<?php echo base64_encode($vval['vendor_id']); ?>');"><i
                                                                class="fa fa-lock" aria-hidden="true"></i></a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Unblock"
                                                           onclick="changeBlockStatus('unblock', '<?php echo base64_encode($vval['vendor_id']); ?>');"><i
                                                                class="fa fa-unlock" aria-hidden="true" style="color: green;"></i></a>
                                                            <?php
                                                        }
                                                        ?>
                                                        <?php
                                                        if ($vval['status'] == '1') {
                                                            ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Active"
                                                           onclick="changeStatus('activate', '<?php echo base64_encode($vval['vendor_id']); ?>');"><i
                                                                class="fa fa-check" aria-hidden="true"></i>
                                                        </a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip"
                                                           title="Deactive"
                                                           onclick="changeStatus('deactivate', '<?php echo base64_encode($vval['vendor_id']); ?>');"><i
                                                                class="fa fa-times"
                                                                aria-hidden="true"></i></a>
                                                            <?php
                                                        }
                                                        ?>

                                                    <a class="tbl_icon fancybox" href="<?php echo base_url('sa-view-vendor-profile/' . base64_encode($vval['vendor_id'])); ?>"
                                                       data-toggle="tooltip" title="View Vendor Profile">
                                                        <i class="fa fa-eye" aria-hidden="true" style="color: #09274B;"></i>
                                                    </a>
                                                    <a class="tbl_icon" href="javascript:void(0)" data-toggle="tooltip" title="Delete" onclick="deleteUser('<?php echo base64_encode($vval['vendor_id']); ?>');">
                                                        <i class="fa fa-trash-o" aria-hidden="true" style="color: red;"></i>
                                                    </a>
                            <?php } ?>                                    
                                                    
                                                    <!-- Documents Details -->
                                                    <div class="modal fade" id="docs_<?php echo $vval['vendor_id']; ?>"
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

                                                                            <div class="row">
                                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                                    <table class="table table-bordered">
                                                                                        <?php
                                                                                        if (!empty($get_vendor_files)) {
                                                                                            foreach ($get_vendor_files as $fkey => $fval) {
                                                                                                if ($fval['form_name'] == '') {
                                                                                                    if ($fval['form_no'] == '1') {
                                                                                                        $file_name = "ACH FORM";
                                                                                                    } else if ($fval['form_no'] == '2') {
                                                                                                        $file_name = "COMPANY SUBCONTRACTOR AGREEMENT";
                                                                                                    } else if ($fval['form_no'] == '3') {
                                                                                                        $file_name = "NON-DISCLOSURE AGREEMENT";
                                                                                                    } else if ($fval['form_no'] == '4') {
                                                                                                        $file_name = "SUBCONTRACTOR MANDATORY INSURANCE REQUIREMENTS";
                                                                                                    }
                                                                                                } else {
                                                                                                    $file_name = strtoupper($fval['form_name']);
                                                                                                }
                                                                                                ?>

                                                                                                <tr>
                                                                                                    <td align="left">
                                                                                                        <label><?php echo $file_name; ?></label>
                                                                                                        <br>
                                                                                                        <?php
                                                                                                        if ($fval['file'] != '') {
                                                                                                            ?>
                                                                                                            <a class="fancybox" style="color: #09274B;" href="<?php echo base_url(); ?>uploads/vendor_pdfs/<?php echo $fval['file']; ?>">View</a>
                                                                                                            <?php
                                                                                                        } else {
                                                                                                            ?>
                                                                                                            <a href="<?php echo base_url(); ?>sa_view_vendor_document/<?php echo base64_encode($fval['form_no']); ?>/<?php echo base64_encode($vval['vendor_id']); ?>"
                                                                                                               class="fancybox" style="color: #09274B;">View</a>
                                                                                                               <?php
                                                                                                           }
                                                                                                           ?>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php
                                                                                                        if ($fval['form_status'] != '0' && $fval['sa_form_status'] != '0') {
                                                                                                            ?>
                                                                                                            <span
                                                                                                                style="color: green;">Verified</span>
                                                                                                                <?php
                                                                                                            } else {
                                                                                                                ?>
                                                                                                            <span
                                                                                                                style="color: red;">Not Verified</span>
                                                                                                                <?php
                                                                                                            }
                                                                                                            ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                        } else {
                                                                                            ?>
                                                                                            <div>Not Uploaded Yet</div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
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

                                                    <!-- Employee Details -->
                                                    <div class="modal fade" id="employee_<?php echo $vval['vendor_id']; ?>"
                                                         role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Photo</th>
                                                                                                <th>Consultant Name</th>
                                                                                                <th>Consultant Email ID</th>
                                                                                                <th>Consultant Designation</th>
                                                                                                <th>Phone No</th>
                                                                                                <th>Date of Joining</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            if (count($employee_details) > 0) {
                                                                                                foreach ($employee_details as $eval) {
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td>
                                                                                                            <?php
                                                                                                            if ($eval['file'] != '') {
                                                                                                                ?>
                                                                                                                <img
                                                                                                                    class="profile-user-img img-responsive img-circle"
                                                                                                                    src="<?php echo base_url(); ?>uploads/<?php echo $eval['file']; ?>"
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
                                                                                                        </td>
                                                                                                        <td><?php echo $eval['first_name'] . " " . $eval['last_name']; ?></td>
                                                                                                        <td> <?php echo $eval['employee_email']; ?></td>
                                                                                                        <td><?php echo $eval['employee_designation']; ?></td>
                                                                                                        <td><?php echo ($eval['phone_no'] != '0') ? $eval['phone_no'] : ''; ?></td>
                                                                                                        <td><?php echo ($eval['date_of_joining']!= '0')?date("m-d-Y",  strtotime($eval['date_of_joining'])):""; ?></td>
                                                                                                    </tr>
                                                                                                    <?php
                                                                                                }
                                                                                            } else {
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td colspan="6">No Consultant(s) Found</td>
                                                                                                </tr>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
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
        $('#vendor_tbl').DataTable({
            scrollX: true,
            scrollCollapse: true,
        });
    });</script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script>

    function changeBlockStatus(type, id) {
        var bs_type = type;
        var vendor_id = id;
        if (bs_type == 'block') {
            var type = 'Unblock';
        } else if (bs_type == 'unblock') {
            var type = 'Block';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Vendor User?",
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
                    $.post("<?php echo site_url('change_vendor_block_status'); ?>", {
                        bs_type: bs_type,
                        vendor_id: vendor_id
                    }, function (data) {

                        //alert(data);
                        location.reload();
                    });
                }
            }
        });
    }

    function changeStatus(type, id) {
        var bs_type = type;
        var vendor_id = id;
        if (bs_type == 'activate') {
            var type = 'Deactivate';
        } else if (bs_type == 'deactivate') {
            var type = 'Activate';
        }

        bootbox.confirm({
            message: "Do You Want To " + type + " The Vendor User?",
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
                    $.post("<?php echo site_url('change_vendor_status'); ?>", {
                        bs_type: bs_type,
                        vendor_id: vendor_id
                    }, function (data) {
                        //alert(data);
                        location.reload();
                    });
                }
            }
        });
    }

    function deleteUser(id) {
        var vendor_id = id;

        bootbox.confirm({
            message: "Do You Want To Delete The Vendor User?",
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
                    $.post("<?php echo site_url('delete_vendor_user'); ?>", {vendor_id: vendor_id}, function (data) {
//                        alert(data);
//                        return false;
                        if (data == 1) {
                            var msg = 'Vendor Deleted Successfully';
                            $("#succ-msg").show();
                            $("#succ-msg").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 0)
                        {
                            var msg = 'OOPS !! Something went wrong!';
                            $("#succ-err").show();
                            $("#succ-err").html(msg);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (data == 2)
                        {
                            var msg = 'OOPS !! Vendor has consultant under him.';
                            $("#succ-err").show();
                            $("#succ-err").html(msg);
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
