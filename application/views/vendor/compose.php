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
                <li><a href="#"><i class="fa fa-dashboard"></i> Communication</a></li>
                <li class="active"><a href="">Compose</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-lg-12 col-sm-12 col-md-12">

                    <div class="alert alert-danger err" style="display: none;">Mail Not Sent Successfully</div>
                    <div class="alert alert-success succ" style="display: none;">Mail Sent Successfully</div>
                    <div class="box">

                        <div class="box-body table-responsive">
                            <form id="compose" action="" method="post" enctype="multipart/form-data">
                                <div class="panel-body">
                                    <div class="row">

                                        <div style="margin-top:20px;" class="col-xs-12 col-sm-12 col-md-12">

                                            <div class="form-group">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control validate[required]" type="text"
                                                               id="recipient_to" placeholder="To" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="input-group">
                                                        <input class="form-control subject" type="text" id="subject"
                                                               name="subject" placeholder="Subject" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12 col-md-12">
                                                <textarea name="message" id="message"
                                                          class="form-control validate[required]" placeholder="Message"
                                                          style="resize: none;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-footer" style="background-color: #fff;">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <input class="btn btn-success" type="button" name="submit" id="submit"
                                                   value="Send">
                                            <input type="hidden" name="sender_id" id="sender_id"
                                                   value="<?php echo $get_details[0]['vendor_id']; ?>">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>


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
        $("#compose_form").validationEngine();
    });


</script>

<script src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/ckeditor/config.js" type="text/javascript" charset="utf-8"></script>
<script>
    CKEDITOR.replace('message');
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/normalize.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css" type="text/css"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.autocomplete.multiselect.js" type="text/javascript"
        charset="utf-8"></script>
<script type="text/javascript">

    $(function () {

        $("#recipient_to").autocomplete({
            minLength: 2,
            multiselect: true,
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo site_url('get_vendor_recipient_emails'); ?>",
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

<script type="text/javascript">

    $(function () {
        var recipient_arr = [];
        $("#submit").on("click", function () {
            $('.ui-autocomplete-multiselect-item').each(function () {
                recipient_arr.push($(this).text());
            });
            //alert(values);
            var subject = $("#subject").val();
            var message = CKEDITOR.instances.message.getData();
            var sender_id = $("#sender_id").val();
            if (message != '' || recipient_arr.length != 0) {
                $.post("<?php echo site_url('vendor_send_mail'); ?>", {
                    recipient_arr: recipient_arr,
                    sender_id: sender_id,
                    subject: subject,
                    message: message
                }, function (data) {
//                    alert(data);
//                    return false;
                    if (data == 1) {
                        location.reload();
                        $(".err").hide();
                        $(".succ").show();
                    }
                    else {
                        location.reload();
                        $(".err").show();
                        $(".succ").hide();
                    }

                });
            }
        });
    });

</script>