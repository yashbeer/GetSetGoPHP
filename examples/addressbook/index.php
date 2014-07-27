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
$photourl = null;

/* Fetch the address record from the database
*/
$addrbook = $addrbook->find_all();

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

    <title>GetSetGo | Example - Addressbook</title>
	
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
			<h1>Address Book</h1>
			<div class="row text-right">
			<a href="create.php" data-original-title="Create new address" type="button" class="btn btn-sm btn-info">Create New +</a>
			</div>
		</div>
		
		<?php
			if($addrbook) {
				foreach($addrbook as $addr) :
					$photourl = null;
					$upload = $upload->find_by_id($addr->photo_id);
					if($upload) {
						$photourl = $upload->geturl();
					}
					?>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" >
							<div class="panel panel-info">
								<div class="panel-heading">
									<h3 class="panel-title"><?php echo $addr->name; ?></h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-3 col-lg-3" align="center"> <img alt="User Pic" src="<?php echo $photourl; ?>" class="img-circle" width="120"></div>
										<div class=" col-md-9 col-lg-9">
											<table class="table table-user-information">
												<tbody>
												<tr>
												<td>Email<td>
												<td><?php echo $addr->email; ?></td>
												</tr>
												<tr>
												<td>Mobile<td>
												<td><?php echo $addr->mobile; ?></td>
												</tr>
												<tr>
												<td>Address<td>
												<td><?php echo $addr->address; ?></td>
												</tr>
												<tr>
												<td>Comments<td>
												<td><?php echo $addr->comments; ?></td>
												</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="panel-footer text-right">
									<a href="create.php?id=<?php echo $addr->id ?>" data-original-title="Edit this address" type="button" class="btn btn-sm btn-warning">Edit</a>
									<a href="delete.php?id=<?php echo $addr->id ?>" data-original-title="Remove this address" type="button" class="btn btn-sm btn-danger">Remove</a>
								</div>
							</div>	  
						</div>
				<?php endforeach;
			}

		?>
	</div>
	
<?php require_once(SITE_ROOT.DS."layout".DS."footer.php"); ?>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo BASE_URL?>js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo BASE_URL?>js/bootstrap.min.js"></script>
</body>
</html>
