<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>About Us</title>
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

        p {
            font-size: 14px !important;
        }

        .header {
            background-color: #373737;
            padding: 10px 0;
        }

        .head_left {
            color: #fff;
            font-size: 16px;
        }

        .head_left span {
            color: #fff;
            font-size: 16px;
            padding: 0 30px;
        }

        .head_left span a {
            color: #fff;
            font-size: 16px;
            padding: 0 8px;
        }

        .head_left span a:hover {
            text-decoration: none;
            color: #CCC;
        }

        .headtop {
            /*padding: 20px 0;*/
        }

        .abt_top h2 {
            font-size: 45px;
            line-height: 63px;
            margin: 0 0 11px;
            color: #007095;
        }

        .abt_top p {
            font-size: 16px;
            font-weight: 300
        }

        .about {
            margin-bottom: 108px;
        }

        .add > span {
            font-size: 18px;
            display: block;
            padding: 7px 0;
        }

        .add h2 {
            font-size: 36px;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .add {
            margin-bottom: 50px;
        }

        hr {
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
        //transition: width .3s;
        }

        .aboutImageContainer{
            position:relative;
        }
        .aboutImageContainer__pic{
            width: 100%;
            object-fit: cover;
            height:400px;
        }
        
        .aboutImageContainer__text{
            text-align: center;
            width: 100%;
            position: absolute;
            left: 50%;
            top: 45%;
            color: white;
            transform: translate(-50%, -50%);
            font-size: 5rem;
            z-index:10;
        }
        .aboutImageContainer__opacity{
            background-color: rgba(0,0,0,0.5);
            width: 100%;
            height: 100%;
            position: absolute;
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
                                                             style="margin-top: 12px; margin-left:15px"></a>
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
    <div class="aboutImageContainer">
        <h1 class="aboutImageContainer__text"><?php echo PROJECT_TYPE . " " . PROJECT_NAME; ?></h1>
        <div class="aboutImageContainer__opacity"></div>
        <img src="<?php echo base_url(); ?>assets/images/management.jpg" alt="" class="aboutImageContainer__pic"/>
    </div>
</section>
<p>&nbsp;</p>
<section>
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="abt_top">
                        <h3 style="text-align:center; color: #007095; font-size: 36px; " data-aos="fade-right">About
                            <?php echo SITE_NAME; ?>&trade;</h3>
                        <hr/>
                        <p>&nbsp;</p>

                        <p>
                            <?php echo COMPANY_NAME; ?>, one of the top companies in the realm of Software Development Solutions,
                            presents <strong><?php echo SITE_NAME; ?>&trade;</strong>, the ultimatum of <strong><?php echo lcfirst(PROJECT_TYPE) . " " .PROJECT_NAME; ?></strong> imparting well-organized workflow, project
                            management and dashboard module with sheer excellence and simplicity leaving complex issues
                            far behind.</p>

                        <p>To achieve success in a global level a company must maintain a well-crafted, fully managed
                            systematic process in case of project management as well as vendor management or keeping
                            track on employees and consultants overseas and their activities regularly along with
                            invoice generation process.</p>

                        <p>In addition, with all these parameters you need a medium for effective communication among
                            everyone involved in a project. What if you a get a onetime solution to manage all these
                            matters simultaneously!</p>

                        <p>Well, we introduce <?php echo SITE_NAME; ?>&trade;, <span style="color: #007095;">a complete and compact software-based solution to carry out scalable project delivery timely across the globe along with total control by the administrative body of your company</span>.
                            Most important part is you don’t have to face as such complexities in the path of your
                            business growth internationally. Hence, we tagged <?php echo SITE_NAME; ?>&trade; as ‘Simplicity
                            Redefined’.</p>
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
                <div class="col-lg-8 col-md-8">
                    <div class="abt_top">
                        <h3 style="color: #007095;" data-aos="fade-right">Key Features of <?php echo SITE_NAME; ?>&trade;</h3>
                        <hr style="margin: 0px 0px 25px;width: 45%;border: 1px solid #078ec1;"/>
                        <ul style="line-height: 28px;" list-style-type="circle" data-aos="fade-up">
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Enabling Dashboard Module: </span>like
                                a control panel
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Super-Admin &amp; Admin Module: </span>for
                                administrative figures of a company
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Vendor Management Module: </span>enrollment/
                                approval and activities
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Document Module: </span>where
                                employee/consultant and vendor can upload
                                required documents to get enrolled
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Timesheet Module: </span>keep
                                track of time management by employees/consultant
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Invoice Module:  </span>for
                                Invoice generation details tracking
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Communication Module: </span>To
                                continue persuasive communication between admin/ super-admin, vendor, employee or
                                consultant through mail.
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Notification Module: </span>to
                                get notified about assigned projects, uploaded documents and all.
                            </li>
                            <li style="list-style-type: circle;"><span style="color: #007095; font-weight: bold;">Internal Files module:  </span>to
                                access and countersign internal files of company.
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="image"><img src="<?php echo base_url(); ?>assets/images/image1.jpg" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</section>
<p>&nbsp;</p>
<section>
    <div class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="abt_top">
                        <h3 style="color: #007095;" data-aos="fade-right">Benefits of Having <?php echo SITE_NAME; ?>&trade; for Your
                            Company</h3>
                        <hr style="margin: 0px 0px 25px;width: 50%;border: 1px solid #078ec1;"/>
                        <ul style="line-height: 28px;" list-style-type="circle" data-aos="fade-up">
                            <li style="list-style-type: circle;">Vendor management, invoice details generation become
                                way easier.
                            </li>
                            <li style="list-style-type: circle;">Keeping constant track of performance by employees or
                                keep an eye on time management by employees.
                            </li>
                            <li style="list-style-type: circle;">Assigning projects and preparing progress reports,
                                quality deliverables maintaining deadlines all look simple.
                            </li>
                            <li style="list-style-type: circle;">Scope of Background verification timely</li>
                            <li style="list-style-type: circle;">Effective Administrative access and supervising scope
                                by clicking on right menu only.
                            </li>
                        </ul>
                        <p>
                            Ultimately lead your company to achieve success and recognition globally through simplified
                            systematic software based support and solution called <?php echo SITE_NAME; ?>&trade;.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="conatcat-info">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="contact-info wow fadeInDown animated" data-wow-duration="1000ms" data-wow-delay="600ms"
                     style="height: 91px; visibility: visible; animation-duration: 1000ms; animation-delay: 600ms; animation-name: fadeInDown;">
                    <div class="pull-left"><i class="fa fa-phone"></i></div>
                    <div class="media-body">
                        <h2 style="margin-top: 0;">How can we help you?</h2>

                        <p>Do you need any online support? If you have any enquiry or need a service, feel free to call
                            us at <br/> <a href="tel:<?php echo TELEPHONE; ?>"> <?php echo TELEPHONE; ?></a>, or mail us at <a href="mailto:<?php echo HELPDESK_EMAIL; ?>"><?php echo HELPDESK_EMAIL; ?></a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4"><a href="<?php echo site_url('contact-us'); ?>" class="query_but btn">Contact Us</a></div>
        </div>
    </div>
    <!--/.container-->
</section>
<link href="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.css" rel="stylesheet">
<script src="https://cdn.rawgit.com/michalsnik/aos/2.1.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
</body>
</html>
