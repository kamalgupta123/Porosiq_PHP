<?php
$this->load->view('admin/includes/header');
//echo "<pre>";
//print_r($get_admin_data);
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

    .html2canvas-container { width: 3000px !important; height: 3000px !important; }
</style>
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>admin_dashboard" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo base_url(); ?>assets/images/2.png" alt=""></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <?php
            $this->load->view('admin/includes/upper_menu');
            ?>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <?php
            $this->load->view('admin/includes/user_panel');
            $this->load->view('admin/includes/sidebar');
            ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Manage Purchase Order<small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Manage Purchase Order</a></li>
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
                                Manage Purchase Order
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

                                    <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                        <form id="add_purchase_order" action="<?php echo site_url('insert_purchase_order'); ?>" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="vendor">Select Vendor : </label>
                                                    <select name="vendor" id="vendor" class="form-control">
                                                        <?php foreach ($vendors as $v) { ?>
                                                            <option value="<?php echo $v['vendor_id']; ?>"><?php echo $v['vendor_company_name'];?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="store">Select Store : </label>
                                                    <select name="store" id="store" class="form-control">
                                                        <option value="guanacaste">Guanacaste</option>
                                                        <option value="alajuela">Alajuela</option>
                                                        <option value="heredia">Heredia</option>
                                                        <option value="san_jose">San Jose</option>
                                                        <option value="cartago">Cartago</option>
                                                        <option value="limon">Limon</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="purchase_order_number">Purchase Order Number</label>
                                                    <input type="text" name="purchase_order_number" id="purchase_order_number" class="form-control">
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" id="date" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row" id="row_to_add">
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="description">Description</label>
                                                    <input type="text" name="description" id="description" class="form-control">
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="unit_price">Unit Price</label>
                                                    <input type="text" name="unit_price" id="unit_price" class="form-control" onchange="sum()">
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="text" name="quantity" id="quantity" class="form-control" onchange="sum()">
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="total">Total</label>
                                                    <input type="text" name="total" id="total" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-3 pull-left">
                                                    <button class="btn btn-primary" id="add_new_row">+ Add new row</button>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="attachment">Attachment :</label>
                                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <input type="submit" value="Create Purchase Order" class="btn btn-primary">
                                        </form>

                                        
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php
    $this->load->view('admin/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('admin/includes/footer');
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

        $(document).on('click', '#add_new_row', function(e) {
            $("<div class='row'><div class='col-xs-3 col-sm-3 col-md-3'><label for='description_new'>Description</label><input type='text' name='description_new' id='description_new' class='form-control'></div><div class='col-xs-3 col-sm-3 col-md-3'><label for='unit_price_new'>Unit Price</label><input type='text' name='unit_price_new' id='unit_price_new' class='form-control'></div><div class='col-xs-3 col-sm-3 col-md-3'><label for='quantity_new'>Quantity</label><input type='text' name='quantity_new' id='quantity_new' class='form-control'></div><div class='col-xs-3 col-sm-3 col-md-3'><label for='total_new'>Total</label><input type='text' name='total_new' id='total_new' class='form-control'></div></div>").insertAfter("#row_to_add");
            e.preventDefault();
        });
    });

        // $('#payroll_table').DataTable();
    $(function () {
        $('#date_of_joining').datepicker(
                {
                    format: 'mm/dd/yyyy'
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
<script>

function sum(){
  var val1 = document.getElementById('unit_price').value;
  var val2 = document.getElementById('quantity').value;
  var sum = Number(val1) * Number(val2);
  document.getElementById('total').value = sum;
}
</script>
