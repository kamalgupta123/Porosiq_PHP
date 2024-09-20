<html>
<head>
	<title>View Work Order</title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/favicon.ico/favicon.png" />
</head>
<body>
	<embed src="<?php echo $wo_pdf_link; ?>" type="application/pdf" width="100%" height="95%" />
	<center>
		<a href="<?php echo $dashboard_link; ?>" class="btn btn-success" id="return_btn">Return to Dashboard</a>
	</center>
</body>
</html>