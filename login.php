<?php
require_once("includes/config.php");

if (isset($_POST['submit'])) { // Form has been submitted.
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// Check database to see if username/password exist.
	$user = $user->authenticate($username, $password);
	if ($user) {
		$session->login($user);
		
		//mention the filename of log
		$log->filename = $user->username;
		//get the last accessed log
		$lastlog = $log->getlast_record();
		//record the new log in the file
		$log->write("Login : {$user->username} logged in.");
		//put that log in the session message
		$session->message( prepare_message($lastlog, "info") );
		
		/*------- default redirection if logged in ---------- */
		if($session->designation) {
			redirect_to(BASE_URL."home.php");
		}
	}
	else {
		// username/password combo was not found in the database
		$message = prepare_message("Username / Password incorrect", "danger");
	}
  
} else { // Form has not been submitted.
  $username = "";
  $password = "";
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

    <title>GetSetGo | Login</title>
	
    <link href="<?php echo BASE_URL?>css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL?>css/custom.css" rel="stylesheet"><!-- Custom styles  -->
    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4" style="margin-top: 10%;">
			
				<?php echo $message; ?>
				
				<div class="panel panel-default">
					<div class="panel-heading"><h3 class="panel-title">Please sign in</h3></div>
					<div class="panel-body">
						<form accept-charset="UTF-8" action="" method="post">
						<fieldset>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Username" name="username" required="required">
							</div>
							<div class="form-group">
								<input type="password" class="form-control" placeholder="Password" name="password" value="">
							</div>
							<!--<div class="checkbox">
								<label><input name="remember" type="checkbox" value="Remember Me"> Remember Me</label>
							</div>-->
							<input class="btn btn-lg btn-success btn-block" type="submit" value="Login" name="submit">
						</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo BASE_URL?>js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo BASE_URL?>js/bootstrap.min.js"></script>
</html>