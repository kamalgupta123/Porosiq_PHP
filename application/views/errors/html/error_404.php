<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="<?php echo base_url(); ?>assets/errors/css/bootstrap.css" type="text/css" rel="stylesheet" />
<style>
.container_error {
    max-width: 1170px;
    margin: 0 auto 30px;
    text-align: inherit;
    min-height: 420px;
}
.container_error_lft {
    display: table-cell;
    float: none;
    height: 285px;
    text-align: center;
    vertical-align: middle;
    width: 1200px;
}
.container_error h2 {

    color: #09274b;
    font-size: 82px;
    text-transform: uppercase;
    font-family: "Ruluko-Regular";
    padding: 0;
    margin: 14px 0;

}
.container_error h2 span {
    color: #fff;
    font-size: 20px;
	vertical-align: bottom;
}
.container_error h3 {
    color: #fff;
    font-size: 22px;
    margin: 0;
    padding: 0 0 8px;
    text-transform: uppercase;
    font-family: "helveticaregular";
}
.container_error p {
    margin: 0;
	font-size:15px;
    padding: 0;
    font-family: "helveticaregular";
}
.container_error a {
    background: #09274b;
    border-radius: 4px;
    color: #fff;
    display: inline-block;
    font-size: 16px;
    margin: 12px 0 0;
    padding: 10px 62px;
    transition: all 0.95s ease;
    font-family: "helveticaregular";
    text-decoration: none;
}
.login-page {
    background:url(<?php echo base_url(); ?>assets/errors/images/bg2.jpg) no-repeat;
        background-size: auto auto;
    background-size: cover;
}
.container {
    width: 1170px;
	padding-right: 15px;
padding-left: 15px;
margin-right: auto;
margin-left: auto;

}
.logo img {
    width: 45%;
}
hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
        border-top-width: 0px;
        border-top-style: none;
        border-top-color: currentcolor;
    border-top: 1px solid #eee;
}
.link {

    text-align: center;
    color: #fff;
    font-size: 12px;
    line-height: 46px;

}
.link1 ul {
    list-style: none;
    float: right;
    margin: 0;
}
.link1 ul li {
    display: inline-block;
}
.link1 a {
    color: #fff;
    font-size: 15px;
    line-height: 25px;
    padding: 0 0 0 10px;
}
.pnc {
    float: right;
}
.pnc a {
    color: #fff;
}
</style>
</head>

<body class="login-page">
<div class="container">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="logo">
                    <img src="<?php echo base_url(); ?>assets/images/logo-white.png" alt="">
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 clearfix">
<!--                <a class="text" href="http://procuretechstaff.com/" target="_blank">Welcome to ProcureTechstaff</a>
                <a class="text" href="#" target="_blank">Welcome to PNCCAPITAL</a>-->
            </div>
        </div>
<div class="container_error">
				<div class="row">
					<div class="container_error_lft">
						<h2><img src="<?php echo base_url(); ?>assets/errors/images/logo.png" /><span>Error</span></h2>
							<h3>Sorry We Can't Find That Page!</h3>
								<p>Either something went wrong or the page doesn't exist anymore</p>
									<a href="<?php echo base_url(); ?>">Home</a>
					</div>
					
				</div>
				<div class="clear"></div>
	</div>
    <footer>

            <div class="container">
                <div class="row">
                    <hr>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="link">
                            <span><?php echo COPYRIGHT_TEXT; ?></span>
                        </div>    
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="link1 clearfix">
                            <ul>
                                <li><a href="<?php echo site_url('about-us'); ?>" target="_blank">About Us</a></li>
                                <li><a href="<?php echo site_url('contact-us'); ?>" target="_blank">Contact Us</a></li>
                            </ul>
                        </div>
                        <span class="pnc"><a href="<?php echo COMPANY_LINK; ?>" target="_blank">Click here to visit <?php echo COMPANY_NAME; ?></a></span>
                    </div>

                </div>
            </div>
        </footer>
</body>
</html>
