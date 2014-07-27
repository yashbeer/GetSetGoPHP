<?php
require_once("includes/config.php");

/*------- Access control ------------------- */
$user->allowed();

/*------------declaration of variables----------*/
	//single valued attributes
	$userid = null;
	$username  = null;
	$designation = null;
	$admin_password = null;

/*--------------------- creating new user in the database --------------------*/
if(isset($_POST['submit'])) {
	// updating user
	$user = $user->find_by_username($_POST['username']); 
	if($user){
		$message .= prepare_message("Username already exists!", "info");
	}
	else {
		$user = new User();
		$user->username = $_POST['username'];
		$user->password = sha1($_POST['password']);
		$user->designation = $_POST['designation'];
		if($user->create()) {
			$session->message( prepare_message("User created successfully", "success") );
			redirect_to(BASE_URL."home.php");
		}
		else{
			$message .= prepare_message("User could not be created successfully!", "danger");
		}
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

    <title>GetSetGo | Create User</title>
	
    <link href="<?php echo BASE_URL?>css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap core CSS -->
    <link href="<?php echo BASE_URL?>css/custom.css" rel="stylesheet"><!-- Custom styles  -->
    <!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
	<?php menuactive("two"); require_once(SITE_ROOT.DS."layout".DS."header.php"); ?>
	<div class="container">
		<div class="row text-center">
			<?php echo $message; ?>
		</div>
	</div>
		
	<!-- Begin page content -->
    <div class="container">
		<div class="page-header">
			<h1>Create new user</h1>
		</div>
		<form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data"  name="createuser">
		
			<div class="form-group">
				<label for="username" class="col-sm-3 col-sm-offset-2 control-label">Username</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="username" placeholder="Username" name="username" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-3 col-sm-offset-2 control-label">Password</label>
				<div class="col-sm-4">
				  <input type="password" class="form-control" id="password" placeholder="Password" name="password" required="required">
				</div>
			</div>
			<div class="form-group">
				<label for="designation" class="col-sm-3 col-sm-offset-2 control-label">Designation</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="designation" placeholder="Designation" name="designation" required="required">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-3 col-sm-offset-6">
					<div class="col-sm-offset-8">
					<button type="submit" class="btn btn-default" id="place-order" name="submit">Done</button>
					</div>
				</div>
			</div>
		</form>
    </div>

<?php require_once(SITE_ROOT.DS."layout".DS."footer.php"); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo BASE_URL?>js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo BASE_URL?>js/bootstrap.min.js"></script>
</body>
</html>