<?php
$this->load->view('vendor/includes/header');
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

    .alert-danger-d {
        color: #fff;
        background-color: #ff5c5c;
        border-color: #ff2d2d;
    }

    .alert-d {
        padding: 14px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-weight: bold;
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
    .navbar{display:block;}
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

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <?php if ($this->session->flashdata('error_msg')) { ?>
                        <div
                            class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                        <?php } ?>
                        <?php if ($this->session->flashdata('succ_msg')) { ?>
                        <div
                            class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                        <?php } ?>

                    <div class="box">

                        <div class="box-header">
                            <h3 class="box-title">Invoice</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                        <div class="panel-body">
                                <div class="row">

                                    <div style="margin-top:20px; font-size:1.5rem;" class="col-xs-12 col-sm-12 col-md-12">

                                        <form action="<?php echo site_url('invoice_submit'); ?>" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="po"> P.O.# </label>
                                                    <select name="purchase_order" id="po" required>
                                                        <option value="23">23</option>
                                                        <option value="24">24</option>
                                                        <option value="25">25</option>
                                                        <option value="26">26</option>
                                                        <option value="27">27</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                <label for="store">Store</label>
                                                    <select name="store" id="store" required>
                                                        <option value="Guanacaste">Guanacaste</option>
                                                        <option value="Alajuela">Alajuela</option>
                                                        <option value="Heredia">Heredia</option>
                                                        <option value="San Jose">San Jose</option>
                                                        <option value="Cartago">Cartago</option>
                                                        <option value="Limon">Limon</option>
                                                    </select>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <h4>Ship to</h4>
                                                    <p>Global Headquarter & Operation Center</p>
                                                    <p>1700 Parkstreet, Suite 212</p>
                                                    <p>Naperville, IL, 60563</p>
                                                </div>
                                               
                                                
                                            </div>
                                            <br>
                                            <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="invoice">Invoice Id#</label>
                                                    <input type="text" name="invoice" id="invoice" required>
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="date">Date</label>
                                                    <input type="date" name="date" id="date" required>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <h4>Bill to</h4>
                                                    <p>Global Headquarter & Operation Center</p>
                                                    <p>1700 Parkstreet, Suite 212</p>
                                                    <p>Naperville, IL, 60563</p>
                                                </div>
                                                
                                            </div>
                                            </br>
                                            <div class="row">
                                            <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="description">Description</label>
                                                    <input type="text" name="description" id="description" required>
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="unit_price">Unit Price</label>
                                                    <input type="number" name="unit_price" id="unit_price" onchange="sum()" required>
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="text" name="quantity" id="quantity" onchange="sum()" required>
                                                </div>
                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                    <label for="total">Total</label>
                                                    <input type="number" name="total" id="total" required>
                                                </div>
                                            </div>
                                            </br>
                                            </br>
                                            </br>
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                    <label for=""> Payment Method </label>
                                                    <input type="text" name="payment" id="payment" value="60 NET" readonly>
                                                </div>
                                                <div class="col-xs-4 col-sm-4 col-md-4">
                                                    <label for="attachment">Upload Attachment :</label>
                                                    <input type="file" name="attachment" id="attachment" class="form-control">
                                                </div>
                                            </div>
                                            <br>
                                            <input type="submit" value="Submit" class="btn btn-success text-center">
                                        </form>

                                        
                                    </div>
                                </div>
                            </div>
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
    $this->load->view('vendor/includes/common_footer');
    ?>
</div>
<!-- ./wrapper -->

<?php
$this->load->view('vendor/includes/footer');
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $(function () {
        $('#admin_tbl').DataTable();
        $('#sign_docs_tbl').DataTable();
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
<script>

function sum(){
  var val1 = document.getElementById('unit_price').value;
  var val2 = document.getElementById('quantity').value;
  var sum = Number(val1) * Number(val2);
  document.getElementById('total').value = sum;
}
</script>