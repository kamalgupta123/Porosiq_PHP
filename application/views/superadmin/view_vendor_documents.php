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
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Vendor</a></li>
                <li class="active"> Vendor Document Lists</li>
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
                            <div class="" style="text-align: left; padding: 0px 0px 0px 10px;">
                                <?php
                                if (!empty($get_vendor_details)) {
                                    $vendor_id = $get_vendor_details[0]['vendor_id'];
									$vendor_name = $get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name'];
                                    $vendor_name_prefix = $get_vendor_details[0]['name_prefix'];
                                    $vendor_company_name = $get_vendor_details[0]['vendor_company_name'];
                                    
                                }
                                ?>
                                <h3 class="box-title">Vendor Document Lists for <?php echo $vendor_company_name; ?></h3>
                            </div>
                        </div>
                    </div>
                    <form id="timesheet_table" action="<?php echo site_url('sa_approve_disapprove_vendor_documents'); ?>" method="post" enctype="multipart/form-data">
                        <div class="box">
                            <div class="box-header">

                                <div style="float: left;">
                                    <input type="submit" name="ad" value="Approved" class="btn btn-success approve"
                                           style="font-size: 12px;">
                                    <input type="submit" name="ad" value="Disapproved" class="btn btn-danger disapprove"
                                           style="font-size: 12px;">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="" class="table table-bordered table-striped tbl-checked" style="font-size: 11px;">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>SL No.</th>
                                            <th>Vendor-Point of Contact Name</th>
                                            <th>Vendor-Point of Contact Designation</th>
                                            <th>Document Name</th>
                                            <th>Upload Documents</th>
                                            <th>File</th>
                                            <th>Status</th>
                                            <th>Admin Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        if (count($get_documents_details) > 0) {

                                            foreach ($get_documents_details as $aval) {
                                                $doc_status = "";
                                                $admin_doc_status = "";
                                                $get_uploaded_vendor_documents = $this->vendor_model->getUploadedDocs($aval['id'], $get_vendor_details[0]['vendor_id']);
//                                                echo "<pre>";
//                                                print_r($get_uploaded_vendor_documents);
                                                ?>
                                                <tr>
                                                    <?php
                                                    if (!empty($get_uploaded_vendor_documents)) {
                                                        $doc_status = $get_uploaded_vendor_documents[0]['sa_form_status'];
                                                        $admin_doc_status = $get_uploaded_vendor_documents[0]['form_status'];
                                                        ?>
                                                        <td>
                                                            <input type="checkbox" name="check[]" class="chk" value="<?php echo $aval['id']; ?>" <?php if ($doc_status == '1') { ?> checked="checked" <?php } ?>>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td>&nbsp;</td>
                                                    <?php } ?>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo stripslashes($get_vendor_details[0]['first_name'] . " " . $get_vendor_details[0]['last_name']); ?></td>
                                                    <td><?php echo stripslashes($get_vendor_details[0]['vendor_designation']); ?></td>
                                                    <td><?php echo stripslashes($aval['document_name']); ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url(); ?>uploads-sadmin-vendor-documents/<?php echo base64_encode($aval['id']) . '/' . base64_encode($vendor_id); ?>" style="color: #09274B;"><i class="fa fa-upload" aria-hidden="true"></i> Upload Document</a>    
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_uploaded_vendor_documents)) { 
														//print_r("in IF ".$get_uploaded_vendor_documents[0]['file']);
                                                            if ($get_uploaded_vendor_documents[0]['file'] != '') {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>uploads/vendor_pdfs/<?php echo $get_uploaded_vendor_documents[0]['file']; ?>"
                                                                   class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                   <?php
                                                               } else {
                                                                   ?>
                                                                <a href="<?php echo base_url(); ?>sa_view_vendor_document/<?php 
																//print_r("in else".($get_uploaded_vendor_documents[0]['form_no']));
																echo base64_encode($get_uploaded_vendor_documents[0]['form_no']) . "/" . base64_encode($get_uploaded_vendor_documents[0]['vendor_id']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if (!empty($get_uploaded_vendor_documents)) {
                                                            if ($doc_status == '0') {
                                                                ?>
                                                                <label style="color: #f39c12;">Pending Approval</label>
                                                                <?php
                                                            } elseif ($doc_status == '1') {
                                                                ?>
                                                                <label style="color: green;">Approved</label>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                       if (!empty($get_uploaded_vendor_documents)) {
                                                            if ($admin_doc_status == '0') {
                                                                ?>
                                                                <label style="color:#f39c12;">Pending Approval</label>
                                                                <?php
                                                            } else if ($admin_doc_status == '1') {
                                                                ?>
                                                                <label style="color:green;">Approved</label>
                                                                <?php
                                                            }
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
                        <input type="hidden" name="vendor_id" value="<?php echo $get_vendor_details[0]['vendor_id']; ?>">
                    </form>

                </div>
            </div>
            <!-- /.row (main row) -->
            <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
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
        $("#upload_document").validationEngine({promptPosition: 'inline'});
    });


</script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
        $('select').select2('destroy');
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
    });
</script>

<script>
    $('#docs_tbl .hideme').hide();
    $('#docs_tbl .hideme_fst').hide();
    $('#docs_tbl .hideme_sec').hide();
    $('#docs_tbl .hideme_thrd').hide();
    $('#docs_tbl .hideme_frth').hide();
    $('#docs_tbl .hideme_btn').hide();


    $(function () {

        $("#list_a_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_b_name = $("#list_b_name");
            var list_c_name = $("#list_c_name");
            if ($(this).val()) {
                list_b_name.attr('disabled', 'disabled');
                list_c_name.attr('disabled', 'disabled');
//                list_b_name.rules('remove', 'required');
//                list_c_name.rules('remove', 'required');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').show();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').show();
                if (($(this).val()) == 5) {
                    list_b_name.attr('disabled', 'disabled');
                    list_c_name.attr('disabled', 'disabled');
//                    list_b_name.rules('remove', 'required');
//                    list_c_name.rules('remove', 'required');
                    $('#docs_tbl .hideme').show();
                    $('#docs_tbl .hideme_fst').show();
                    $('#docs_tbl .hideme_sec').show();
                    $('#docs_tbl .hideme_thrd').hide();
                    $('#docs_tbl .hideme_frth').hide();
                    $('#docs_tbl .hideme_btn').show();
                }
            } else {
                list_b_name.removeAttr('disabled');
                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').hide();
            }
        });

        $("#list_b_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_a_name = $("#list_a_name");
            var list_c_name = $("#list_c_name");
            if ($(this).val()) {
                list_a_name.attr('disabled', 'disabled');
//                list_c_name.attr('disabled', 'disabled');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').show();
                if (list_c_name.val()) {
                    $('#docs_tbl .hideme_frth').show();
                    $('#docs_tbl .hideme_btn').show();
                } else {
                    $('#docs_tbl .hideme_frth').hide();
                    $('#docs_tbl .hideme_btn').hide();
                }
            } else {
                list_a_name.removeAttr('disabled');
//                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                $('#docs_tbl .hideme_thrd').hide();
                if (list_c_name.val()) {
                    $('#docs_tbl .hideme_frth').show();
                    list_a_name.attr('disabled', 'disabled');
                } else {
                    $('#docs_tbl .hideme_frth').hide();
                    list_a_name.removeAttr('disabled');
                }
                $('#docs_tbl .hideme_btn').hide();
            }
        });

        $("#list_c_name").change(function () {

            $("#sadmin_approval").removeAttr("onchange");

            var list_a_name = $("#list_a_name");
            var list_b_name = $("#list_b_name");
            if ($(this).val()) {
                list_a_name.attr('disabled', 'disabled');
//                list_c_name.attr('disabled', 'disabled');
                $('#docs_tbl .hideme').show();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                if (list_b_name.val()) {
                    $('#docs_tbl .hideme_thrd').show();
                    $('#docs_tbl .hideme_btn').show();
                } else {
                    $('#docs_tbl .hideme_thrd').hide();
                    $('#docs_tbl .hideme_btn').hide();
                }
                $('#docs_tbl .hideme_frth').show();
            } else {
                list_a_name.removeAttr('disabled');
//                list_c_name.removeAttr('disabled');
                $('#docs_tbl .hideme').hide();
                $('#docs_tbl .hideme_fst').hide();
                $('#docs_tbl .hideme_sec').hide();
                if (list_b_name.val()) {
                    $('#docs_tbl .hideme_thrd').show();
                    list_a_name.attr('disabled', 'disabled');
                } else {
                    $('#docs_tbl .hideme_thrd').hide();
                    list_a_name.removeAttr('disabled');
                }
                $('#docs_tbl .hideme_frth').hide();
                $('#docs_tbl .hideme_btn').hide();
            }
        });
    });
</script>

<script type="text/javascript">
    $('#image-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file1').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file1').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file1').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file2').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file2').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file2').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });

    $('#image-file3').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file3').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file3').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>

