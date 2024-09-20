<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="preconnect" href="https://fonts.gstatic.com" />
		<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap"
			rel="stylesheet"
		/>
		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
			integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2"
			crossorigin="anonymous"
		/>
		<link rel="icon" href="../assets/favicon.ico/favicon.png" type="image" sizes="16x16" />
		<link href="../assets/css/error.css" rel="stylesheet" />
		<title>404 Error</title>
	</head>
	<body>
		<nav class="nav">
			<a href="#" class="nav__logo">
				<img
					src="../assets/images/logo-white.png"
					class="navbar__logo--image img-fluid"
					alt="PorosIQ"
				/>
			</a>
		</nav>
		<section class="main">
			<div class="main__heading">
				<img src="../assets/images/404logo.png" alt="404" />
				<h5>ERROR</h5>
			</div>
			<h3 class="main__subHeading">SORRY WE CAN'T FIND THAT PAGE!</h3>
			<h4 class="main__text">
				Either something went wrong or the page doesn't exist anymore
			</h4>
			<button class="btn main__btn" onclick="window.history.back();">
				Back
			</button>
		</section>
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
	</body>
</html>
