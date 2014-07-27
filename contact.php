<?php
require_once("includes/config.php");

/*------- Access control ------------------- */
$user->allowed();

if( isset($_POST['submit']) ) {
	//Steps to configure:
	//Change Recipient Name and emailID
	//Change Sender Name and emailID
	//Change subject if needed.
	//Pass an array() having name of form fields to serialize_form() function
	$phpmail->to = "Recipient Name <getsetgo@yashbeer.com>";
	$phpmail->subject = "Contact Form";
	$phpmail->message = $phpmail->serialize_form(array('name','email','comments'));
	$phpmail->from = "Sender Name <sender@gmail.com>";
	$status = $phpmail->send();
	if($status == "Sent") {
		$message = prepare_message("Email has been successfully sent", "success");
	}
	else {
		$message = prepare_message("Email cannot be sent successfully!", "danger");
	}
}
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

    <title>GetSetGo | Contact</title>
	
    <link href="<?php echo BASE_URL?>css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL?>css/custom.css" rel="stylesheet"><!-- Custom styles  -->
    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <?php menuactive("three"); require_once(SITE_ROOT.DS."layout".DS."header.php"); ?>
	<div class="container">
		<div class="row text-center">
			<?php echo $message; ?>
		</div>
	</div>
    <!-- Begin page content -->
    <div class="container">
	
      <div class="page-header">
        <h1>Contact Us</h1>
      </div>
      <p class="lead">Say hello to us.. Drop an email using the form below </p>
	  <p>By default, email will be sent to: <code>getsetgo@yashbeer.com</code></p>
	  
	  <br />
	  <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data"  name="email">
			<div class="form-group">
				<label for="name" class="col-sm-3 col-sm-offset-2 control-label">Name</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="name" placeholder="Name" name="name" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="email" class="col-sm-3 col-sm-offset-2 control-label">Email</label>
				<div class="col-sm-4">
				  <input type="email" class="form-control" id="email" placeholder="Your Email ID" name="email" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="comments" class="col-sm-3 col-sm-offset-2 control-label">Comments</label>
				<div class="col-sm-4">
				  <textarea class="form-control" rows="7" placeholder="Enter Comments" name="comments"></textarea>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 col-sm-offset-8">
				<button type="submit" class="btn btn-default" id="place-order" name="submit">Send</button>
				</div>
			</div>
		</form>
	  
    </div>

<?php require_once(SITE_ROOT.DS."layout".DS."footer.php"); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
