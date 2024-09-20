<?php
$this->load->view('vendor/includes/header');
?>

<style>
    .dataTables_filter {
        display: none !important;
    }

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
                <li class="active"><a href="">Invoice Management</a></li>
            </ol>
        </section>

        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12">
<?php /*
                        <div class="box" style="margin-top: 30px;">

                            <div class="panel panel-default">
                                <div class="panel-heading"><strong>Search :</strong></div>
                                <div class="panel-body">
                                    <form id="search_form" action="<?php echo site_url('search_vendor_payment'); ?>"
                                          method="post"
                                          enctype="multipart/form-data">
                                        <table width="100%" class="table table-bordered table-striped"
                                               style="font-size: 10px;">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    <label>Employee Code</label>
                                                </td>
                                                <td>
                                                    <input type="text" name="search_by_emp_code" id="search_by_emp_code"
                                                           class="form-control"
                                                           placeholder="Search by Employee Code"
                                                           value="<?php if (isset($search_by_emp_code) && $search_by_emp_code != '') {
                                                               echo $search_by_emp_code;
                                                           } ?>">
                                                </td>
                                                <td>
                                                    <label>Payment Mode</label>
                                                </td>
                                                <td>
                                                    <select name="search_by_payment_mode" class="form-control"
                                                            onchange="showType(this.value);">
                                                        <option value="">Select</option>
                                                        <option
                                                            value="1" <?php if (isset($search_by_payment_mode) && $search_by_payment_mode == '1') { ?> selected <?php } ?>>
                                                            Weekly Payment
                                                        </option>
                                                        <option
                                                            value="2" <?php if (isset($search_by_payment_mode) && $search_by_payment_mode == '2') { ?> selected <?php } ?>>
                                                            Monthly Payment
                                                        </option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php
                                            if (isset($search_by_payment_mode) && $search_by_payment_mode == '1') {

                                                ?>
                                                <tr id="t_weekly">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date" id="start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo $search_by_start_date;
                                                               } ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo $search_by_end_date;
                                                               } ?>">
                                                    </td>
                                                </tr>

                                                <?php
                                            } else {
                                                ?>
                                                <tr id="t_weekly" style="display: none;">
                                                    <td>
                                                        <label>Start Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_start_date" id="start_date"
                                                               class="form-control date"
                                                               placeholder="Search by Start Date"
                                                               value="<?php if (isset($search_by_start_date) && $search_by_start_date != '') {
                                                                   echo $search_by_start_date;
                                                               } ?>">
                                                    </td>
                                                    <td>
                                                        <label>End Date</label>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="search_by_end_date" id="end_date"
                                                               class="form-control date"
                                                               placeholder="Search by End Date"
                                                               value="<?php if (isset($search_by_end_date) && $search_by_end_date != '') {
                                                                   echo $search_by_end_date;
                                                               } ?>">
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (isset($search_by_payment_mode) && $search_by_payment_mode == '2') {

                                                ?>
                                                <tr id="t_monthly">
                                                    <td>
                                                        <label>Month</label>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $month_arr = array(
                                                            "01" => "Jan",
                                                            "02" => "Feb",
                                                            "03" => "Mar",
                                                            "04" => "Apr",
                                                            "05" => "May",
                                                            "06" => "Jun",
                                                            "07" => "Jul",
                                                            "08" => "Aug",
                                                            "09" => "Sept",
                                                            "10" => "Oct",
                                                            "11" => "Nov",
                                                            "12" => "Dec",
                                                        );
                                                        ?>
                                                        <select name="search_by_month" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($month_arr as $mkey => $mval) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $mkey; ?>" <?php if (isset($search_by_month) && $mkey == $search_by_month) { ?> selected <?php } ?>><?php echo $mval; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><label>Year</label></td>
                                                    <td>
                                                        <select name="search_by_year" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            for ($j = 1990; $j <= 2200; $j++) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $j; ?>" <?php if (isset($search_by_year) && $j == $search_by_year) { ?> selected <?php } ?>><?php echo $j; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php
                                            } else {
                                                ?>
                                                <tr id="t_monthly" style="display: none;">
                                                    <td>
                                                        <label>Month</label>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $month_arr = array(
                                                            "01" => "Jan",
                                                            "02" => "Feb",
                                                            "03" => "Mar",
                                                            "04" => "Apr",
                                                            "05" => "May",
                                                            "06" => "Jun",
                                                            "07" => "Jul",
                                                            "08" => "Aug",
                                                            "09" => "Sept",
                                                            "10" => "Oct",
                                                            "11" => "Nov",
                                                            "12" => "Dec",
                                                        );
                                                        ?>
                                                        <select name="search_by_month" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            foreach ($month_arr as $mkey => $mval) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $mkey; ?>" <?php if (isset($search_by_month) && $mkey == $search_by_month) { ?> selected <?php } ?>><?php echo $mval; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                    <td><label>Year</label></td>
                                                    <td>
                                                        <select name="search_by_year" class="form-control">
                                                            <option value="">Select</option>
                                                            <?php
                                                            for ($j = 1990; $j <= 2200; $j++) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $j; ?>" <?php if (isset($search_by_year) && $j == $search_by_year) { ?> selected <?php } ?>><?php echo $j; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>

                                            <tr>
                                                <td colspan="6" align="right">

                                                    <input class="btn btn-success" type="submit" name="submit"
                                                           value="Search">
                                                    <a href="<?php echo site_url('vendor_employee_payment'); ?>"
                                                       class="btn btn-warning">Show All</a>
                                                </td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        */?>
                        <?php if ($this->session->flashdata('error_msg')) { ?>
                            <div
                                class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                            <div
                                class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                        <?php } ?>
                        <div class="col-lg-12 col-sm-12 col-md-12">

                        <div class="box" style="margin-top: 30px;">

                            <div class="panel panel-default">
                                <div class="panel-body" style="text-align: right">
                                    <a href="<?php echo base_url('invoice'); ?>" style="color: #09274B;"><i
                                            class="fa fa-plus" style="color: green;"></i> Add invoice</a>
                                </div>
                            </div>
                        </div>
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Invoice List</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body table-responsive">
                                <table id="admin_tbl" class="table table-bordered table-striped"
                                       style="font-size: 11px;">
                                    <thead>
                                    <tr>
                                        <th>Invoice No.</th>
                                        <th>Date</th>
                                        <th>P.O. No.</th>
                                        <th>Store</th>
                                        <th>Total</th>
                                        <!-- <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Working Days</th>
                                        <th>Standard Time</th>
                                        <th>Bill Rate</th>
                                        <th>Total Standard Pay</th>
                                        <th>Over Time</th>
                                        <th>Overtime Rate</th>
                                        <th>Total Overtime Pay</th> -->
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($get_invoice_list as $invoice_list) { ?>
                                        <tr>
                                            <td><?php echo $invoice_list['InvoiceNumber']; ?></td>
                                            <td><?php echo $invoice_list['Date']; ?></td>
                                            <td><?php echo $invoice_list['PONumber']; ?></td>
                                            <td><?php echo $invoice_list['Store']; ?></td>
                                            <td><?php echo $invoice_list['Total']; ?></td>
                                            <td><a href="<?php echo base_url($invoice_list['invoiceFilePath']); ?>" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <?php } ?>
                                            <!-- <td>01</td>
                                            <td>1</td>
                                            <td>20/10/2022</td>
                                            <td>23</td>
                                            <td>Guanacaste</td>
                                            <td>1000</td>
                                            <td><a href="<?php echo base_url(); ?>upload/1.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <tr>
                                            <td>02</td>
                                            <td>2</td>
                                            <td>20/10/2022</td>
                                            <td>24</td>
                                            <td>Alajuela</td>
                                            <td>800</td>
                                            <td><a href="<?php echo base_url(); ?>upload/2.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <tr>
                                            <td>03</td>
                                            <td>3</td>
                                            <td>22/10/2022</td>
                                            <td>25</td>
                                            <td>Heredia</td>
                                            <td>600</td>
                                            <td><a href="<?php echo base_url(); ?>upload/3.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <tr>
                                            <td>04</td>
                                            <td>4</td>
                                            <td>22/10/2022</td>
                                            <td>26</td>
                                            <td>San Jose</td>
                                            <td>500</td>
                                            <td><a href="<?php echo base_url(); ?>upload/1.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <tr>
                                            <td>05</td>
                                            <td>5</td>
                                            <td>23/10/2022</td>
                                            <td>27</td>
                                            <td>Cartago</td>
                                            <td>300</td>
                                            <td><a href="<?php echo base_url(); ?>upload/1.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr>
                                        <tr>
                                            <td>06</td>
                                            <td>6</td>
                                            <td>25/10/2022</td>
                                            <td>28</td>
                                            <td>Limon</td>
                                            <td>450</td>
                                            <td><a href="<?php echo base_url(); ?>upload/1.pdf" class="fancybox" style="color: #09274B;"><i class="fa fa-eye" aria-hidden="true"></i> View File</a></td>
                                        </tr> -->
                                    </tbody>
                                            
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
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
$this->load->view('vendor/includes/common_footer');
?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
?>

<script>

    $(function () {
        $('#admin_tbl').DataTable();
    });

    $(function () {
        $('#start_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
        $('#end_date').datepicker(
            {
                format: 'yyyy-mm-dd'
            }
        );
    });

    function showType(val) {
        var type = val;
        if (type == 1) {
            $("#t_weekly").show();
            $("#t_monthly").hide();
        }
        else if (type == 2) {
            $("#t_weekly").hide();
            $("#t_monthly").show();
        }
        else {
            $("#t_weekly").hide();
            $("#t_monthly").hide();
        }
    }


</script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    $(function () {
        $("#search_by_emp_code").autocomplete({
            minLength: 3,
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('search_by_emp_code'); ?>",
                    dataType: "json",
                    data: request,
                    success: function (data) {
                        if (data.response == 'true') {
                            response(data.message);
                        }
                    }
                });
            }
        });
    });

</script>