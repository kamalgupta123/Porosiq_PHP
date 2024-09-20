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
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" />
		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
			integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
			crossorigin="anonymous"
		/>
		<link
			rel="stylesheet"
			href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"
		/>
		<link rel="icon" href="<?php echo base_url(); ?>assets/favicon.ico/favicon.png" type="image" sizes="16x16" />
		<script
			src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
			crossorigin="anonymous"
		></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
			crossorigin="anonymous"
		></script>
		<?php if (SHOW_1KOSMOS_QR_SADMIN) { ?>
			<style>
				.sh {
					box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .25);
				}
				.txt-font {
					font-family: 'Roboto Mono', monospace;
				}
			</style>
			<script type="text/javascript" src="<?php echo base_url(); ?>assets/BlockIdSDK/blockid.js"></script> 
			<script type="text/javascript">
				$(document).ready(function() {
					function createSession() {
						createNewSession("Fingerprint", "firstname,middlename,lastname,phone,mobile,email,streetaddress,locality,state,postalcode,country,dateofbirth,gender,ial,ppt,dl,aal,did", "qrcode",null 
						, function(result, error) {client_dataRecieved(result)}
						);
					}

					function client_dataRecieved(result) {
						let str = JSON.stringify(result, null, 4);
						var obj = JSON.parse(str);
						
						let userdata  = JSON.stringify(obj.user_data, null, 4);
						var ouserdata = JSON.parse(userdata);
						userID = ouserdata.userid;
						// alert(userID);
						if (ouserdata.ppt != null && ouserdata.ppt != "undefined" )
						{
							let pptdata  = JSON.stringify(ouserdata.ppt, null, 4);
							var opptdata = JSON.parse(pptdata); //data parsed for passport
							var firstName =  opptdata.firstName;
							console.log(firstName);
							var lastName = opptdata.lastName;
							console.log(lastName);
							var rdateofbirth = opptdata.dateOfBirth;
							console.log(dateOfBirth);
							var rcountrycode = opptdata.countryCode;
							console.log(countryCode);
							var rdateOfExpiry = opptdata.dateOfExpiry;
							console.log(dateOfExpiry);
							var rdocumentId = opptdata.documentId;
							console.log(documentId);
							var rdocumentType = opptdata.documentType;
							console.log(documentType);
							var rgender = opptdata.gender;
							console.log(gender);
						}
						if (ouserdata.dl != null && ouserdata.dl != "undefined" )
						{
							let dldata  = JSON.stringify(ouserdata.dl, null, 4);
							var odldata = JSON.parse(dldata);
							var ddateofbirth = odldata.dateOfBirth;
							console.log(ddateofbirth);
							var dcountrycode = odldata.country;
							console.log(dcountrycode);
							var deyeColor	= odldata.eyeColor;
							console.log(deyeColor);
							var dzipCode	= odldata.zipCode;
							console.log(dzipCode);
							var dheight		= odldata.height;
							console.log(dheight);
							var ddocumentId = odldata.documentId;
							console.log(ddocumentId);
							var ddateOfIssue= odldata.dateOfIssue;
							console.log(ddateOfIssue);
							var daddress	= odldata.address;
							console.log(daddress);
							var dstate		= odldata.state;
							console.log(dstate);
							var ddateOfExpiry= odldata.dateOfExpiry;
							console.log(ddateOfExpiry);
							var dcity		= odldata.city;
							console.log(dcity);
							var dsex		= odldata.sex;
							console.log(dsex);
						}
						// var email = 'anutosh.g@ptscservices.com';
						if (userID != undefined) {
							window.location.href = '<?php echo base_url(); ?>superadmin_qr_code/'+userID; //site_url use here
						}
					}

					createSession();
				});
			</script>
		<?php } ?>
		<title><?php echo SITE_NAME; ?> Login Page</title>
	</head>
	<body>
		<nav class="nav">
			<a href="<?php echo base_url(); ?>" class="nav__logo navbar-brand">
				<img src="<?php echo base_url(); ?>assets/images/logo-white.png" class="img-fluid" alt="PorosIQ" />
			</a>
		</nav>
		<main class="main">
			<section class="main__box">
				<div class="content">
					<div class="content__heading">
						<h2>Welcome to</h2>
						<h1><?php echo SITE_NAME; ?>&trade;</h1>
						<h3>
							<?php echo PROJECT_TYPE_LOGIN . " " . PROJECT_NAME; ?>
						</h3>
						<div class="content__icons">
							<a
								href="<?php echo site_url('about-us'); ?>"
								class="content__porosicon"
								target="_blank"
							>
								<div class="content__icons-poros"></div>
								<p>About Us</p>
							</a>
							<a
								href="<?php echo site_url('contact-us'); ?>"
								class="content__supporticon"
								target="_blank"
							>
								<i class="las la-life-ring"></i>
								<p>Support</p>
							</a>
							<?php if (SHOW_1KOSMOS_QR_SADMIN) { ?>
								<div id="qrcode" align="center"></div>
							<?php } ?>
						</div>
					</div>
					<div class="content__inputBox">
						<div class="loginBox">
							<?php if ($this->session->flashdata('succ_msg')) { ?>
                                <div class="alert alert-success"> <?php echo $this->session->flashdata('succ_msg'); ?> </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('error_msg')) { ?>
                                <div class="alert alert-danger"> <?php echo $this->session->flashdata('error_msg'); ?> </div>
                            <?php } ?>
							<form action="<?php echo site_url('valid_login'); ?>" method="post" enctype="multipart/form-data" class="loginBox__formContainer">
								<div class="loginBox__loginAs form-group">
									<label for="user">Login as</label>
									<select
										style="padding-left: 8px;"
										class="form-control loginBox__dropdown"
										name="user"
										id="user"
										onchange="location = this.options[this.selectedIndex].value;"
									>
										<?php echo get_login_user_types('sadmin', true); ?>
									</select>
								</div>

								<div class="loginBox__userContainer">
									<p class="mb-1">Email</p>
									<input
										class="loginBox__userid form-control"
										type="email"
										placeholder="Email"
										name="email"
										id="email"
										required
									/>
								</div>
								<div class="loginBox__passContainer">
									<p class="mb-1">Password</p>
									<input
										class="loginBox__userpass form-control"
										type="password"
										placeholder="Password"
										name="password"
										id="Password"
										required
									/>
								</div>
								<div class="loginBox__login">
									<div class="loginBox__checkbox">
										<input
											style="cursor: pointer;"
											type="checkbox"
											id="remember_me"
											name="remember_me"
										/>
										<label class="loginBox__checkbox--label" for="remember_me"
											>Remember Me</label
										>
									</div>
									<a class="loginBox__forgot" href="<?php echo site_url('forgot-password'); ?>">Forgot Password?</a>
								</div>
								<input
									type="submit"
									value="Sign In"
									class="btn loginBox__loginbtn"
								/>
							</form>
						</div>
					</div>
				</div>
			</section>
		</main>
		<footer class="footer">
			<p class="footer__copyright">
				<?php echo COPYRIGHT_TEXT; ?>
			</p>
			<a
				href="<?php echo COMPANY_LINK; ?>"
				target="_blank"
				class="footer__cognatic"
			>
				Click here to visit <?php echo COMPANY_NAME; ?>
			</a>
		</footer>

		<!-- <script
			src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
			integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
			crossorigin="anonymous"
		></script> -->
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
			crossorigin="anonymous"
		></script>
	</body>
</html>
