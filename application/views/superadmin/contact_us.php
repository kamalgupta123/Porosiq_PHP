<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Contact Us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/favicon.ico/favicon.png">
        <link rel="manifest" href="<?php echo base_url(); ?>assets/favicon.ico/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo base_url(); ?>assets/favicon.ico/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- Favicon -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
                background: #f9f9f9;
                font-family: 'Open Sans', sans-serif;
                color: #4e4e4e;
                font-size: 14px !important;
            /*    line-height: 22px;*/
            }
            p{
               font-size: 14px !important; 
            }
            .header{ background-color:#373737; padding:10px 0;}
            .head_left{color:#fff; font-size:16px; }
            .head_left span{ color:#fff; font-size:16px; padding:0 30px;}
            .head_left span a{ color:#fff; font-size:16px; padding:0 8px;}
            .head_left span a:hover{ text-decoration:none; color:#CCC;}
            


            .abt_top h2 {font-size: 45px;line-height: 63px; margin: 0 0 11px; color:#007095;}
            .abt_top p{ font-size:16px; font-weight:300}
            .about{ margin-bottom:108px;}


            .add > span {font-size: 18px;display: block;padding: 7px 0;}
            .add h2{ font-size:36px; font-weight:500; margin-bottom:20px;}
            .add {margin-bottom: 50px;}
            hr{
                border: 1px solid black;
                width: 15%;
            }
            
            #conatcat-info {
                background: #fff url(<?php echo base_url(); ?>assets/images/contact.png) no-repeat 90% 0;
                padding: 30px 0;
                border-top: 1px solid #d9d6d6;
                margin-bottom: 30px;
            }
            
            .query_but {
                background: #01b9d1 none repeat scroll 0 0;
                color: #fff !important;
                display: inline-block;
                font-size: 14px;
                margin: 26px 0 0;
                padding: 8px 20px;
                transition: all 0.95s ease 0s;
            }
            .pull-left {
                margin-right: 20px;
            }
                        .contact-info i {
                width: 60px;
                height: 60px;
                font-size: 40px;
                line-height: 60px;
                color: #fff;
                background: #000;
                text-align: center;
                border-radius: 10px;
            }

            .topnav {
                        float: right;
                        list-style: outside none none;
                        margin: 30px 0;
            }
            .nav-li {
            display: inline-block;
            color: #000 !important;
            text-decoration: none !important;
            }

            .nav-li::after {
            content: '';
            display: block;
            width: 0;
            height: 2px;
            background: #000;
            transition: width .3s;
            }

            .nav-li:hover::after {
            width: 100%;
            transition: width .3s;
            }
        </style>
    </head>

    <body>
        <header>
            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="head_left">
                                <span>Telephone: <a href="tel:<?php echo TELEPHONE; ?>"> <?php echo TELEPHONE ?></a></span>
                                <span>Email: <a href="mailto:<?php echo HELPDESK_EMAIL; ?>"> <?php echo HELPDESK_EMAIL; ?> </a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section class="headtop">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/images/1.png" alt=""
                                                                     style="margin-top: 12px; margin-left:15px;"></a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <ul class="topnav" id="menu">

                            <li><a href="<?php echo base_url(); ?>" class="nav-li">Client Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div>
                <img src="<?php echo base_url(); ?>assets/images/contact.jpg" alt="" style="width: 100%;"/>
            </div>
        </section>
        <p>&nbsp;</p>
        <section>
            <div class="about">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="abt_top">
                                <h3 style="text-align:center; color: #007095; font-size: 36px; " data-aos="fade-right">Get in Touch</h3>
                                <hr/>
                                <p>&nbsp;</p>
                                <p style="text-align:center;">
                                    We are here to provide you software based solution and support with the best experience. Our IT team and expert fulfill all your requirements with <?php echo SITE_NAME; ?>&trade; towards sheer excellence and growth.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="service">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="abt_top">
                                <h3 style="text-align:center; color: #007095; font-size: 36px; " data-aos="fade-right">Call or Write to Us</h3>
                                <hr/>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="text-center">
                                            <div class="panel-body">

                                                <div class="add">
                                                    <span><strong>Office Address: </strong> <?php echo OFFICE_ADDRESS; ?></span>
                                                    <span><strong>Telephone: </strong> <a href="tel:<?php echo TELEPHONE; ?>">  <?php  echo TELEPHONE; ?></a></span>
                                                    <span><strong>Fax: </strong>  <?php  echo FAX; ?></span>
                                                    <span><strong>Email:</strong> <a href="mailto:<?php echo HELPDESK_EMAIL; ?>"> <?php echo HELPDESK_EMAIL; ?></a></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
        <script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
        <script>
        AOS.init();
        </script>
    </body>
</html>
