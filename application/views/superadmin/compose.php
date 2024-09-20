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

    .ui-autocomplete-input {
        width: 100% !important;
    }

    .subject {
        width: 100% !important;
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
                Communication
                <small>Management</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Communication</a></li>
                <li class="active">Compose</li>
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
                                <span class="glyphicon glyphicon-th"></span>
                                Compose
                            </h3>
                        </div>
                        
                        <?php if (US || LATAM) { ?>
                            <div class="alert alert-danger err" style="display: none;">Mail Not Sent Successfully</div>
                            <div class="alert alert-success succ" style="display: none;">Mail Sent Successfully</div>
                        <?php } if (INDIA) { ?>
                            <div class="alert alert-danger err" style="display: none;" id="err">Mail Not Sent Successfully</div>
                            <div class="alert alert-success succ" style="display: none;" id="succ">Mail Sent Successfully</div>
                        
                            <div class="alert alert-danger" style="display: none;" id="error_compose"></div>
                        <?php } ?>
                        
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

                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <input class="btn btn-success" type="button" name="submit" id="submit"
                                               value="Send">
                                        <input type="hidden" name="sender_id" id="sender_id"
                                               value="<?php echo $get_details[0]['sa_id']; ?>">
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
        if (LATAM) {
        $("#compose_form").validationEngine();
        }
        if (US) {
        $("#compose").validationEngine({promptPosition: 'inline'});
        }
        if (INDIA) {
            $("#compose_form").validationEngine({promptPosition: 'inline'});
        }
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
                    url: "<?php echo site_url('get_recipient_emails'); ?>",
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
            if (INDIA) {
                if (message == '') {
                // alert("message cannot be empty");
                $('#error_compose').text("message cannot be empty");
                $('#error_compose').show();
                $('#error_compose').delay(3000).fadeOut('slow');
                }
                else if (recipient_arr.length == 0) {
                    // alert("recipient cannot be empty");
                    $('#error_compose').text("recipient cannot be empty");
                    $('#error_compose').show();
                    $('#error_compose').delay(3000).fadeOut('slow');
                }
                else if (subject == '') {
                    // alert("subject cannot be empty");
                    $('#error_compose').text("subject cannot be empty");
                    $('#error_compose').show();
                    $('#error_compose').delay(3000).fadeOut('slow');
                }
                else if (message != '' || recipient_arr.length != 0) {
                    $.post("<?php echo site_url('send_mail'); ?>", {
                        recipient_arr: recipient_arr,
                        sender_id: sender_id,
                        subject: subject,
                        message: message
                    }, function (data) {
                        //                    alert(data);
                        //                    return false;
                        if (data == 1) {
                            $(".err").hide();
                            $(".succ").show();
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                        else {
                            $(".err").show();
                            $(".succ").hide();
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }

                    });
                }
            }
            if (US || LATAM) {
                if (message != '' || recipient_arr.length != 0) {
                    $.post("<?php echo site_url('send_mail'); ?>", {
                        recipient_arr: recipient_arr,
                        sender_id: sender_id,
                        subject: subject,
                        message: message
                    }, function (data) {
                        //                    alert(data);
                        //                    return false;
                        if (data == 1) {
                            $(".err").hide();
                            $(".succ").show();
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                        else {
                            $(".err").show();
                            $(".succ").hide();
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }

                    });
                }
            }
        });
    });

</script>