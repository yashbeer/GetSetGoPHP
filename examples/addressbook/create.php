<?php
require_once("../../includes/config.php");
require_once(SITE_ROOT.DS."examples".DS."addressbook".DS."addrbook.php");

/*------- Access control ------------------- */
$user->allowed();

/* Declaration and Initialization of variables
*/
$name = null;
$email = null;
$mobile = null;
$address = null;
$comments = null;
$photo = null;

/* To update the existing contact in the addressbook
*/
if( isset($_GET['id']) ) {
	$id = $_GET['id'];
	$addrbook = $addrbook->find_by_id($id);
	if($addrbook) {
		$name = $addrbook->name;
		$email = $addrbook->email;
		$mobile = $addrbook->mobile;
		$address = $addrbook->address;
		$comments = $addrbook->comments;
		$upload = $upload->find_by_id($addrbook->photo_id);
		if($upload) {
			$photoid = $upload->id;
			$photourl = $upload->geturl();
		}
	}
	else {
		$message = prepare_message("The Address object couldn't be found!", "danger");
		$session->message($message);
		redirect_to("index.php");
	}

}

/* To create a new contact in the addressbook
*/
if( isset($_POST['submit']) ) {
	/*In case of editing the record - 
	 * If photo already exits, skip code for uploading photo
	 */
	if( !isset($photourl) ) {
		$upload->attach_file($_FILES['thumb']);
		$upload->caption = basename($_FILES['thumb']['name'])." photo"; //caption is optional
		$saved = $upload->save();
		if($saved) {
			$photoid = $upload->id;
		}
		else {
			$message .= prepare_message( join("<br />", $upload->errors) , "danger" );
		}
	}
	else {
		$saved = true;
	}
	
	if($saved) {
		$addrbook->photo_id = $photoid;
		$addrbook->name 	= $_POST['name'];
		$addrbook->email 	= $_POST['email'];
		$addrbook->mobile 	= $_POST['mobile'];
		$addrbook->address 	= $_POST['address'];
		$addrbook->comments = $_POST['comments'];
		$saved = $addrbook->save();
		if($saved)	{
			$session->message( prepare_message("Contact insertion Successful", "success") );
			redirect_to("index.php");
		}
		else {
			$message .= prepare_message("Contact insertion Failed!", "danger");
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

    <title>GetSetGo | Addressbook</title>
	
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
        <h1>Fill up the Address Book</h1>
      </div>
	  <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data"  name="contact">
		<div class="form-group">
			<label for="photo" class="col-sm-3 col-sm-offset-2 control-label">Photo</label>
			<div class="col-sm-4">
				<?php 
					if( isset($photourl) ) {
						echo "<img alt=\"User Pic\" src={$photourl} class=\"img-circle\" width=\"120\">";
					}
					else {
						echo "<input type=\"file\" name=\"thumb\" />";
					}
				?>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-3 col-sm-offset-2 control-label">Name</label>
			<div class="col-sm-4">
			  <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="<?php echo htmlentities($name);?>">
			</div>
		</div>
		  <div class="form-group">
			<label for="email" class="col-sm-3  col-sm-offset-2 control-label">E-mail Address</label>
			<div class="col-sm-4">
			  <input type="email" class="form-control" id="email" placeholder="E-mail Address" name="email" value="<?php echo htmlentities($email);?>" required="required">
			</div>
		  </div>
		  <div class="form-group">
			<label for="mobile" class="col-sm-3  col-sm-offset-2 control-label">Mobile Number</label>
			<div class="col-sm-4">
			  <input type="number" class="form-control" id="mobile" placeholder="Contact Number" maxLength="10" name="mobile" value="<?php echo htmlentities($mobile);?>">
			</div>
		  </div>
		  <div class="form-group">
			<label for="address" class="col-sm-3 col-sm-offset-2 control-label">Address</label>
			<div class="col-sm-4">
				<textarea class="form-control" rows="3" name="address"><?php echo htmlentities($address);?></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<label for="comments" class="col-sm-3 col-sm-offset-2 control-label">Comments</label>
			<div class="col-sm-4">
				<textarea class="form-control" rows="3" name="comments"><?php echo htmlentities($comments);?></textarea>
			</div>
		  </div>
		  <div class="form-group">
			<div class="col-sm-3 col-sm-offset-8">
			<input type="hidden" name="app-submit" value="submitted" />
			<button type="submit" class="btn btn-default" id="place-order" name="submit">Done</button>
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
