<!DOCTYPE html>   
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/forgot.css" />
		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
			integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
			crossorigin="anonymous"
		/>
		<link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/favicon.ico/favicon.png" />
		<title><?php echo SITE_NAME; ?> Reset Password</title>
	</head>
	<body>
		<main class="main">
			<div class="container">
				<nav class="navbar">
					<a href="#" class="navbar__logo">
						<img
							src="<?php echo base_url(); ?>assets/images/logo-white.png"
							class="navbar__logo--image img-fluid"
							alt="PorosIQ"
						/>
					</a>
				</nav>
				<div class="hero">
					<section class="content">
						<div class="content__headingBox">
							<h1 class="content__heading">
								Welcome to <?php echo SITE_NAME; ?>&trade;<br />
								<?php echo PROJECT_TYPE; ?><br />
								<?php echo PROJECT_NAME; ?>
							</h1>
						</div>
						<div class="loginBox">
							<h5 class="loginBox__heading">Reset Password</h5>
							<!--p class="loginBox__forgotPassword">
								Please Enter the new password
							</p-->
							<?php if ($this->session->flashdata('succ_msg')) { ?>
                                <div class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error_msg')) { ?>
                                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
							<form action="<?php echo site_url('vendor_reset_password'); ?>" method="post" enctype="multipart/form-data" class="loginBox__formContainer">
								<div class="loginBox__userContainer">
									<p class="mb-1">New Password</p>
									<input
										class="loginBox__userid form-control"
										type="password"
										placeholder="Password"
										id="password"
										name="n_pwd"
										required
									/>
								</div>
								<div class="loginBox__userContainer">
									<p class="mb-1">Confirm New Password</p>
									<input
										class="loginBox__userid form-control"
										type="password"
										placeholder="Password"
										id="Confirm_password"
										name="cn_pwd"
										required
									/>
								</div>

								<div class="loginBox__login">
									<a class="loginBox__back" href="<?php echo site_url('vendor-otp-forgot-password'); ?>">Go Back</a>
								    <?php
                                        if (isset($email_otp) && $email_otp != '') {
                                            ?>
                                            <input type="hidden" name="email_otp" value="<?php echo $email_otp; ?>" />
                                            <input type="hidden" name="email" value="<?php echo $email; ?>" />
											<input
												type="submit"
												value="Reset Password"
												class="btn btn-light loginBox__loginbtn"
											/>
											<?php
                                        }
                                        else
                                        {
                                        	?>
                                            <span>You don't have rights to access this page.Please contact with administrator.</span>
                                            <?php
                                        }
                                        ?>
								</div>
							</form>
						</div>
					</section>

					<footer class="footer">
						<div class="footer__copyright">
							<?php echo COPYRIGHT_TEXT; ?>
						</div>
						<div class="footer__right">
							<div class="footer__links">
								<a
									class="footer__about"
									href="<?php echo site_url('about-us'); ?>"
									target="_blank"
									>About us</a
								>
								<a
									class="footer__contact"
									href="<?php echo site_url('contact-us'); ?>"
									target="_blank"
									>Contact us</a
								>
							</div>
							<a
								class="footer__cognatic"
								href="<?php echo COMPANY_LINK; ?>"
								target="_blank"
								>Click here to visit <?php echo COMPANY_NAME ?></a
							>
						</div>
					</footer>
				</div>
			</div>
		</main>
		<script
			src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
			crossorigin="anonymous"
		></script>
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
			crossorigin="anonymous"
		></script>
	</body>
</html>
