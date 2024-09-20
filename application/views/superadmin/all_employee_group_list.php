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
    label{
        font-weight: 600;
    }

    h2::before { /* add the new bullet point */
        display: inline-block;
        content: '';
        -webkit-border-radius: 0.375rem;
        border-radius: 1.375rem;
        height: 1.75rem;
        width: 1.75rem;
        margin-right: 0.5rem;
        background-color: #bdbdbd;
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
                Employee <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Employee</a></li>
                <li class="active">Employee Group List</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                All Employee of Group
                                <p style="float: right;font-size: 11px;"><span style="color:red;">*</span>Required Fields</p>
                            </h3>
                        </div>

                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input type="hidden" name="group_id" id="group_id" value="<?php echo $group_id; ?>">
                                        <h2 style="display: inline-block;" id="group_name"><?php echo ucfirst($current_group_name[0]->group_name); ?></h2>&nbsp;&nbsp;
                                        <input style="display: none;" type="text" name="edited_name" id="edited_name" value="<?php echo $current_group_name[0]->group_name; ?>">&nbsp;&nbsp;
                                        <button class="btn btn-default" style="position: absolute;top: 17px;" id="edit_group"><span class="glyphicon glyphicon-pencil"></span></button>
                                        <br><br><button class="btn btn-primary"style="display:none;position: absolute;top: 50px;left: 26px;" id="submit">Submit</button><br>
                                    </div>

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12 text-right">
                                        <a href="<?php echo base_url("superadmin-add-remove-employee-from-group/$group_id"); ?>"><button class="btn btn-primary">Assign Employee</button></a>
                                    </div>

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">
                                            <table id="group_employee_list" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th>Employee Name</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                
                                                    foreach ($get_all_employee_group_list as $employee) {
                                                
                                                    ?>
                                                        <tr>
                                                            <td><a href="http://"><?php echo $employee->first_name." ".$employee->last_name; ?></a><br><span><?php echo $employee->employee_email; ?></span></td>
                                                            <td>
                                                                <?php if ($employee->status == 1) { ?>
                                                                    <label style="color: green;font-size: 10px;">Active</label>
                                                                <?php } else { ?>
                                                                    <label style="color: red;font-size: 10px;">Deactivated</label>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                </div>
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
        $("#edit_employee_form").validationEngine({promptPosition: 'inline'});
        $('#group_employee_list').DataTable();

    });
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'mm/dd/yyyy'
                }
        );

        $(document).on('click', '#edit_group', function() {
            $('#group_name').hide();
            $('#edited_name').css("display", "inline-block");
            $('#edited_name').css("position", "absolute");
            $('#edited_name').css("top", "20px");
            $('#edit_group').css("left", "217px");
            $('#submit').show();
        });

        $(document).on('click', '#submit', function (e) {

            var edited_group_name = $('#edited_name').val();
            var group_id = $('#group_id').val();
            
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('superadmin-update_group_name'); ?>", 
                data: {edited_group_name: edited_group_name, group_id : group_id}, 
                cache:false,
                success: function(data){
                    console.log("test");
                    location.reload();
                    debugger;
                }
            });

        });
    });

</script>
<script type="text/javascript">
    $('#image-file').on('change', function () {
        var file_extension = ['jpeg', 'jpg', 'png'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#image-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#image-file').val("");
            alert("Only '.jpeg','.jpg', '.png' formats are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>
<script type="text/javascript">
    $('.resume-file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('.resume-file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('.resume-file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>
