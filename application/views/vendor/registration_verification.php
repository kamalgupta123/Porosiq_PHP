<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vendor Registration Verification</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.min.css">
    <!-- iCheck
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">-->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        .formError .formErrorContent {
            min-width: 150px !important;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">
        <div class="login-logo" style="font-size:180%;">
            <a href="<?php echo base_url('vendor'); ?>" style="color: #000;"><img
                    src="<?php echo base_url(); ?>assets/images/vms_logo.png" alt="PTS logo" style="width: 29%;"><br>
                <?php echo PROJECT_NAME; ?></a></div>

        <form action="<?php echo site_url('vendor_verify'); ?>" method="post" enctype="multipart/form-data"
              id="verification_form">

            <?php if ($this->session->flashdata('error_msg')) { ?>
                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
            <?php } ?>
            <?php if ($this->session->flashdata('succ_msg')) { ?>
                <div class="alert alert-danger"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
            <?php } ?>

            <div class="form-group has-feedback">
                <input type="text" class="form-control validate[required]" name="email_otp" placeholder="Email OTP">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <span class="help-block" style="color: #08afa7;">Check your email for the OTP.</span>
            </div>

            <div class="row">
                <div class="col-xs-8">&nbsp;</div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Submit</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<!--<script src="--><?php //echo base_url();?><!--assets/plugins/iCheck/icheck.min.js"></script>-->
<script>
    //    $(function () {
    //        $('input').iCheck({
    //            checkboxClass: 'icheckbox_square-blue',
    //            radioClass: 'iradio_square-blue',
    //            increaseArea: '20%' // optional
    //        });
    //    });
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
        $("#verification_form").validationEngine({promptPosition: 'inline'});
    });

    $(function(){
        $('.alert').delay(5000).fadeOut('slow');
    })
</script>
</body>
</html>
