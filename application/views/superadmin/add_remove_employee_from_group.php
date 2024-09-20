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
                                Add or remove employee from group
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
                                        <h2><?php echo ucfirst($current_group_name[0]->group_name)." Group"; ?></h2>
                                        <br>
                                        <button style="float: right;" class="btn btn-success float-right" data-group-id="<?php echo $group_id; ?>" id="save">Save</button>
                                    </div>

                                    <div style="margin-top:20px;" class="col-xs-6 col-sm-6 col-md-6">
                                        <button class="btn btn-primary" id="add_all"><span class="glyphicon glyphicon-plus-sign">&nbsp;Add all</button>
                                    </div>

                                    <div style="margin-top:20px;" class="col-xs-6 col-sm-6 col-md-6">
                                        <button class="btn btn-primary" id="remove_all"><span class="glyphicon glyphicon-minus-sign">&nbsp;Remove all</button>
                                    </div>

                                    <div style="margin-top:20px;" class="col-xs-6 col-sm-6 col-md-6">
                                            <table id="not_members_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th>Not Members</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="not_members">
                                                    <?php
                                                
                                                    foreach ($not_members as $nm) {
                                                
                                                    ?>
                                                        <tr>
                                                            <td id="<?php echo $nm->employee_id; ?>"><?php echo $nm->first_name." ".$nm->last_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-plus-sign plus" style="float: right;"></span><br><span><?php echo $nm->employee_email; ?></span></td>
                                                        </tr>
                                                    <?php
                                                        } 
                                                    ?>
                                                </tbody>
                                            </table>
                                    </div>
                                    <div style="margin-top:20px;" class="col-xs-6 col-sm-6 col-md-6">
                                            <table id="members_table" class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                                <thead>
                                                    <tr>
                                                        <th>Members</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="members">
                                                    <?php
                                                    
                                                    foreach ($members as $m) {
                                                
                                                    ?>
                                                        <tr>
                                                            <td id="<?php echo $m->employee_id; ?>"><?php echo $m->first_name." ".$m->last_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-minus-sign minus" style="float: right;"></span><br><span><?php echo $m->employee_email; ?></span></td>
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
        $('#not_members_table').DataTable();
        $('#members_table').DataTable();

    });
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'mm/dd/yyyy'
                }
        );

        
        var addIds = [];
        $(document).on('click', '.plus', function(){
            var k = $(this).parent().clone();
            const index = removeIds.indexOf(k.attr('id'));
            if (index > -1) {
                removeIds.splice(index, 1);
            }
            var id = k.attr('id');
            if (typeof id !== "undefined") {
                addIds.push(k.attr('id'));
            }
            k.find('.plus').removeClass("glyphicon-plus-sign").addClass("glyphicon-minus-sign");
            k.find('.plus').removeClass('plus').addClass('minus');
            k = k.html();
            $(this).parent().remove();
            if (typeof id !== "undefined") {
                $('#members').append('<tr><td id="'+id+'">'+k+'</tr></td>');
            }
            console.log(addIds);
            $('#not_members_table').DataTable();
            $('#members_table').DataTable();
        });

        $(document).on('click', '#add_all', function(){
            $('#not_members > tr').not(this).each(function () {
                var k = $(this).find('td').clone();
                const index = removeIds.indexOf(k.attr('id'));
                if (index > -1) {
                    removeIds.splice(index, 1);
                }
                var id = k.attr('id');
                if (typeof id !== "undefined") {
                    addIds.push(k.attr('id'));
                }
                k.find('.plus').removeClass("glyphicon-plus-sign").addClass("glyphicon-minus-sign");
                k.find('.plus').removeClass('plus').addClass('minus');
                k = k.html();
                $(this).remove();
                if (typeof id !== "undefined") {
                    $('#members').append('<tr><td id="'+id+'">'+k+'</tr></td>');
                }
            });
            console.log(addIds);
            $('#not_members_table').DataTable();
            $('#members_table').DataTable();
        });

        var removeIds = [];
        $(document).on('click', '.minus', function(){
            var k = $(this).parent().clone();
            const index = addIds.indexOf(k.attr('id'));
            if (index > -1) {
                addIds.splice(index, 1);
            }
            var id = k.attr('id');
            if (typeof id !== "undefined") {
                removeIds.push(k.attr('id'));
            }
            k.find('.minus').removeClass("glyphicon-minus-sign").addClass("glyphicon-plus-sign");
            k.find('.minus').removeClass('minus').addClass('plus');
            k = k.html();
            $(this).parent().remove();
            if (typeof id !== "undefined") {
                $('#not_members').append('<tr><td id="'+id+'">'+k+'</tr></td>');
            }
            console.log(removeIds);
            $('#not_members_table').DataTable();
            $('#members_table').DataTable();
        });

        $(document).on('click', '#remove_all', function(){
            $('#members > tr').not(this).each(function () {
                var k = $(this).find('td').clone();
                const index = addIds.indexOf(k.attr('id'));
                if (index > -1) {
                    addIds.splice(index, 1);
                }
                var id = k.attr('id');
                if (typeof id !== "undefined") {
                    removeIds.push(k.attr('id'));
                }
                k.find('.minus').removeClass("glyphicon-minus-sign").addClass("glyphicon-plus-sign");
                k.find('.minus').removeClass('minus').addClass('plus');
                k = k.html();
                $(this).remove();
                if (typeof id !== "undefined") {
                    $('#not_members').append('<tr><td id="'+id+'">'+k+'</tr></td>');
                }
            });
            console.log(removeIds);
            $('#not_members_table').DataTable();
            $('#members_table').DataTable();
        });

        $(document).on('click', '#save', function(){
            var group_id = $(this).attr("data-group-id");
            console.log(group_id);
            $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('superadmin-save_members_not_members'); ?>", 
                    data: {group_id: group_id, addIds : addIds, removeIds: removeIds},
                    dataType: "json",  
                    cache:false,
                    success: function(data){
                        
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
