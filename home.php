<?php
require_once("includes/config.php");

/*------- Access control ------------------- */
$user->allowed();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo BASE_URL?>images/favicon.ico">

    <title>GetSetGo | Homepage</title>
	
    <link href="<?php echo BASE_URL?>css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL?>css/custom.css" rel="stylesheet"><!-- Custom styles  -->
    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php menuactive("one"); require_once(SITE_ROOT.DS."layout".DS."header.php"); ?>
	<div class="container">
		<div class="row text-center">
			<?php echo $message; ?>
		</div>
	</div>
	
	<!-- Begin page content -->
	<div class="jumbotron">
	  <div class="container">
		<h1>Hey there..</h1>
		<p>Welcome to the home of simplicity. GetSetGo PHP framework is bundled with most common
		utilities a php developer needs when starting off with a project. <br /> Ready to go with Database connectivity and CRUD operations, Login and User access control, Session management, Log management, uploading script, Email script, etc.</p>
		<p>Object Oriented. Mysql based. PHP framework.</p>
		<p><a class="btn btn-primary btn-lg" role="button">Learn more &raquo;</a></p>
	  </div>
	</div>

<?php require_once(SITE_ROOT.DS."layout".DS."footer.php"); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo BASE_URL?>js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo BASE_URL?>js/bootstrap.min.js"></script>
</body>
</html>
