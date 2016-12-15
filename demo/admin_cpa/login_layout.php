<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=SITE_NAME?> - Admin Login</title>
<script type="text/javascript" src="js/jquery.js"></script>
<link href="css/bootstrap_v3.css" rel="stylesheet" type="text/css"  />
<script type="text/javascript" src="js/bootstrap.js"></script>
<style type="text/css">
body{
background:#ffffff;
font-family:Arial;
}




</style>
	<link type="text/css" href="assets/css/required/bootstrap/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.css" rel="stylesheet" />
	<link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.structure.min.css" rel="stylesheet" />
	<link type="text/css" href="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.theme.min.css" rel="stylesheet" />
	<link type="text/css" href="assets/css/required/mCustomScrollbar/jquery.mCustomScrollbar.min.css" rel="stylesheet" />
	<link type="text/css" href="assets/css/required/icheck/all.css" rel="stylesheet" />
	<link type="text/css" href="assets/fonts/metrize-icons/styles-metrize-icons.css" rel="stylesheet">

	<!-- Optional CSS Files -->
	<link type="text/css" href="assets/css/optional/bootstrapValidator.min.css" rel="stylesheet" />
	<!-- add CSS files here -->

	<!-- More Required CSS Files -->
	<link type="text/css" href="assets/css/styles-core.css" rel="stylesheet" />
	<link type="text/css" href="assets/css/styles-core-responsive.css" rel="stylesheet" />

	<!-- Demo CSS Files -->
	<link type="text/css" href="assets/css/demo-files/pages-signin-signup.css" rel="stylesheet" />

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="assets/js/required/misc/ie10-viewport-bug-workaround.js"></script>

	<!--[if IE 7]>
	<link type="text/css" href="assets/css/required/misc/style-ie7.css" rel="stylesheet">
	<script type="text/javascript" src="assets/fonts/lte-ie7.js"></script>
	<![endif]-->
	<!--[if IE 8]>
	<link type="text/css" href="assets/css/required/misc/style-ie8.css" rel="stylesheet">
	<![endif]-->
	<!--[if lte IE 8]>
	<script type="text/javascript" src="assets/css/required/misc/excanvas.min.js"></script>
	<![endif]-->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>



	<div class="container-fluid">
		<div id="body-container">
			<div class="standalone-page">
				<div class="standalone-page-logo">
					<a href="index.php">
						<img src="assets/images/required/logo-default.png" width="156" height="44" alt="Logo" />
					</a>
				</div>
				<div class="standalone-page-content" data-border-top="multi">
					<div class="standalone-page-block">
						<div class="row">
							<div class="col-xs-12">
								<h2 class="heading">
									<span aria-hidden="true" class="icon icon-key"></span>
									<span class="main-text">
										Administrator Login
									</span>
								</h2>
							</div>
						</div>
						<div class="row">
						<?php
if($msg)
{
    echo "<div class=\"alert alert-danger\" style=\"padding-left:5px\">$msg</div>";
}
?>
<form action="login.php" method="post" class="form">
							<div class="col-xs-12">
								<form role="form" class="login-form form-horizontal" method="post" action="index.html">
									<div class="form-group">
										<label for="inputEmail" class="col-sm-3 control-label">User</label>
										<div class="col-sm-9">
											<input type="text" name="adminuser" class="form-control">
										</div>
									</div>
									</div>
									<div class="col-xs-12"><br>
									<div class="form-group">
										<label for="inputPassword" class="col-sm-3 control-label">Password</label>
										<div class="col-sm-9">
											<input type="password" name="adminpassword"  class="form-control">
										</div>
									</div>
									<div class="form-group"><br><br>
										<div class="col-sm-offset-3 col-sm-9">
											<input type="submit" name="login" class="btn btn-success" value="Login" style="margin-top:5px" />
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div><!-- /.container -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!-- Required JS Files -->
	<script type="text/javascript" src="assets/js/required/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="assets/js/required/jquery-ui-1.11.0.custom/jquery-ui.min.js"></script>
	<script type="text/javascript" src="assets/js/required/bootstrap/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/required/jquery.easing.1.3-min.js"></script>
	<script type="text/javascript" src="assets/js/required/jquery.mCustomScrollbar.min.js"></script>
	<script type="text/javascript" src="assets/js/required/misc/jquery.mousewheel-3.0.6.min.js"></script>
	<script type="text/javascript" src="assets/js/required/misc/retina.min.js"></script>
	<script type="text/javascript" src="assets/js/required/icheck.min.js"></script>
	<script type="text/javascript" src="assets/js/required/misc/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="assets/js/required/circloid-functions.js"></script>

	<!-- Optional JS Files -->
	<script type="text/javascript" src="assets/js/optional/bootstrapValidator.min.js"></script>
	<!-- add optional JS plugin files here -->

	<!-- REQUIRED: User Editable JS Files -->
	<script type="text/javascript" src="assets/js/script.js"></script>
	<!-- add additional User Editable files here -->

	<!-- Demo JS Files -->
	<script type="text/javascript" src="assets/js/demo-files/pages-signin-1.js"></script>

</body>
</html>
