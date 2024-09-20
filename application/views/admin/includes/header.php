<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>
            <?php
            if (isset($meta_title)) {
                echo ucwords(strtolower($meta_title)) . " | " . PROJECT_NAME;
            }
            ?>
        </title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/favicon.ico/favicon.png" />
        
        <link rel="manifest" href="<?php echo base_url(); ?>assets/favicon.ico/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicon.ico/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Favicon -->

        <style>
            #profileImage {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: -9px 0;
                padding: 9px;
            }
            #profileImage3 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: -9px 0;
                padding: 9px;
            }
            #profileImage4 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: -9px 0;
                padding: 9px;
            }
            #profileImage5 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: -9px 0;
                padding: 9px;
            }
            #profileImage6 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: -9px 0;
                padding: 9px;
            }
            #profileImage1 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: 0 auto;
                width: 100px;
                height: 100px;
                line-height: 100px;
            }
            #profileImage2 {
                background: #512da8 none repeat scroll 0 0;
                border-radius: 50%;
                color: #fff;
                font-size: 22px;
                margin: 0 auto;
                width: 50px;
                height: 50px;
                line-height: 50px;
                text-align: center;
            }

            .select2-selection__choice{
                color: #000 !important;
            }
            .select2-container .select2-selection--single .select2-selection__rendered {
                display: block;
                padding-left: 0px !important;
                padding-right: 20px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                line-height: 20px;
            }
            .select2{
                width:200px !important;
            }
            /*--------------Table Style-------------------------------*/

            .table-bordered > thead > tr > th{
                border-bottom-width: 2px;
                color: #fff;
                background: #09274b;
                /*border-bottom: 4px solid #9ea7af;*/
                border-right: 1px solid #343a45;
                /*font-size: 23px;*/
                /*font-weight: 100;*/
                /*padding: 24px;*/
                /*text-align: left;*/
                text-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
                vertical-align: middle;

            }

            /*--------------Table Style-------------------------------*/

            /*---------------------------User Settings---------------*/
            .menu-css a
            {
                display: block;
                background: #fff;
                /*width: 240px;*/
                height: 40px;
                padding: 0 0 0 10px;
                font: bold 13px Helvetica, sans-serif;
                text-transform: uppercase;
                text-decoration: none;
                color: #000000;
                line-height: 40px;
                box-shadow: 0 1px 1px rgba( 0, 0, 0, 0.2 );
                font-size: 11px;
            }

            .menu-css a:nth-child( 2 )
            {
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
            }

            .menu-css a:last-child
            {
                border-bottom-left-radius: 3px;
                border-bottom-right-radius: 3px;
            }

            .menu-css a:hover { color: #555555; }

            .menu-css a:hover > .octicon { color: #555555; }

            .icon
            {
                float: right;
                margin-top: 10px;
                font-size: 20px;
                color: #000000;
                color: rgba( 0, 0, 0, 0.4 );
                opacity: 0.8;
            }

            .octicon-person { margin-right: 16px; }
            .octicon-graph { margin-right: 11px; }
            .octicon-cloud-upload { margin-right: 11px; }
            .octicon-pencil { margin-right: 13px; }

            .arrow
            {
                width: 0;
                height: 0;
                margin-left: 15px;
                border-left: 7px solid transparent;
                border-right: 7px solid transparent;
                border-bottom: 9px solid #F8F8F8;
            }
            .navbar-nav > .user-menu > .dropdown-menu > li.user-header {
                height: 115px;
                padding: 10px;
                text-align: center;
            }
            /*---------------------------User Settings---------------*/
            @media (max-width:767px) {
                .skin-blue .main-header .navbar .dropdown-menu li.divider {
                    background-color:rgba(255, 255, 255, 0.1)
                }
                .skin-blue .main-header .navbar .dropdown-menu li a {
                    color:#000;
                }
                .skin-blue .main-header .navbar .dropdown-menu li a:hover {
                    background:#367fa9
                }
            }

            /*---------------- Google Language Translator ----------------*/
            .goog-te-gadget-icon {
                display: none !important;
            }


            /* Tooltip container */
            .tooltiptext {
                display: none;
            }

            /* Tooltip text */
            .tooltip-demo:hover .tooltiptext {
                display: block;
                background-color: black;
                color: #fff;
                text-align: center;
                padding: 5px 0;
                border-radius: 6px;
                
                /* Position the tooltip text - see examples below! */
                position: absolute;
                z-index: 9999;
                width:320px;
                word-wrap:break-word;
            }

            .glyphicon-loader-animate {
                -animation: spin .7s infinite linear;
                -webkit-animation: spin2 .7s infinite linear;
            }

            @-webkit-keyframes spin2 {
                from { -webkit-transform: rotate(0deg);}
                to { -webkit-transform: rotate(360deg);}
            }

            @keyframes spin {
                from { transform: scale(1) rotate(0deg);}
                to { transform: scale(1) rotate(360deg);}
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">