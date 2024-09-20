<?php
$this->load->view('vendor/includes/header');
?>
<style>
    .lbl-css{
        margin-bottom: 0px !important;
    }
    .input-group{
        margin-bottom: 10px;
        width: 75%;
    }
    label{
        font-weight: 600;
    }
</style>
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <?php
            $this->load->view('vendor/includes/upper_menu');
            ?>
        </nav>
    </header>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!--                <h1>-->
            <!--                    User Profile-->
            <!--                </h1>-->
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li class="active"><a href="">Add Consultant</a></li>
            </ol>
        </section>
        <br/>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <span class="glyphicon glyphicon-user"></span>
                                Add Consultant
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

                        <form id="add_employee_form"
                              action="<?php echo site_url('insert_vendor_employee'); ?>"
                              method="post" enctype="multipart/form-data">
                            <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <table class="table table-bordered table-striped" width="100%" border="1" cellspacing="2" cellpadding="2">
                                            <tbody>
                                                <tr>
                                                    <td width="25%">
                                                        <label for="email">Image</label>
                                                    </td>
                                                    <td width="25%">
                                                        <input class="" type="file" name="file" id="image-file">
                                                        <span style="color: #ff3e3e;">(Max File Size : 2MB)</span>
                                                    </td>
                                                    <td width="25%">
                                                        <label for="email">Consultant Code</label>
                                                    </td>
                                                    <td width="25%">
                                                        <label>
                                                            <?php
                                                            if (isset($employee_code)) {
                                                                echo $employee_code;
                                                            }
                                                            ?>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Prefix</label>
                                                    </td>
                                                    <td>
                                                        <input type="radio" id="name_prefix1" name="name_prefix" value="Mr."
                                                               checked> Mr.
                                                        <input type="radio" id="name_prefix2" name="name_prefix"
                                                               value="Mrs."> Mrs.
                                                        <input type="radio" id="name_prefix3" name="name_prefix"
                                                               value="Ms."> Ms.
                                                        <input type="radio" id="name_prefix4" name="name_prefix"
                                                               value="Dr."> Dr.
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Consultant First Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="first_name" name="first_name" placeholder="First Name"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Consultant Last Name<span
                                                                style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text"
                                                               id="last_name" name="last_name" placeholder="Last Name"
                                                               value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Consultant Designation<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyLetterSp]]" type="text" id="employee_designation" name="employee_designation" placeholder="Consultant Designation" value="">
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Consultant Classification<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="employee_classification" id="employee_classification" class="form-control validate[required]">
                                                            <?php echo show_classifications(); ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <label for="email">Consultant Category<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <select name="employee_category" id="employee_category" class="form-control validate[required]">
                                                            <?php echo show_categories(); ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email">Upload Resume<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="validate[required]" type="file" name="resume_file" id="resume_file">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Phone No. <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required,custom[onlyNumberSp],minSize[10],maxSize[10]]" type="text"
                                                               id="phone_no" name="phone_no" placeholder="Phone No."
                                                               value="">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Fax No.</label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text"
                                                               id="fax_no" name="fax_no" placeholder="Fax"
                                                               value="">
                                                    </td>
                                                    <td>
                                                        <label for="email" class="lbl-css">Address <span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <textarea name="address" id="address" class="form-control validate[required]" rows="5" cols="10" placeholder="Address" style="resize: none;"></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php /*
                                                      <td>
                                                      <label for="email">Bill Rate<span style="color: red;">*</span></label>
                                                      </td>
                                                      <td>
                                                      <input class="form-control validate[required,custom[onlyNumberSp]]" type="text" id="employee_bill_rate" name="employee_bill_rate" placeholder="Bill Rate" value="">
                                                      </td>
                                                     */ ?>
                                                    <td>
                                                        <label for="email">Pay Rate<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required]" type="text" id="v_employee_bill_rate" name="v_employee_bill_rate" placeholder="Pay Rate" value="">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label for="email" class="lbl-css">Date of Joining<span style="color: red;">*</span></label>
                                                    </td>
                                                    <td>
                                                        <input class="form-control validate[required] date" type="text" name="date_of_joining" id="date_of_joining">
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="submit" name="submit" value="Add Consultant User">
                                        <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-default">Back</a>
                                        <input type="hidden" name="employee_code" value="<?php echo $employee_code; ?>">
                                        <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
                                        <input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
                                        <input type="hidden" name="employee_type" value="C">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('vendor/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
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
        $("#add_employee_form").validationEngine({promptPosition: 'inline'});
    });
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'yyyy-mm-dd',
                    startDate: new Date(),
                    todayHighlight: true
                }
        );
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
    $('#resume_file').on('change', function () {
        var file_extension = ['pdf'];
        var file_size = (this.files[0].size / 1024 / 1024).toFixed(2);
        if (parseFloat(file_size) > 2.00) {
            $('#resume_file').val("");
            alert("File Size must be less than 2MB");
            return false;
        } else if ($.inArray($(this).val().split('.').pop().toLowerCase(), file_extension) == -1) {
            $('#resume_file').val("");
            alert("Only '.pdf' format are allowed.");
            return false;
        }
//       alert(file_size);
    });
</script>