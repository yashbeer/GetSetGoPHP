<?php
require_once("../../includes/config.php");
require_once(SITE_ROOT.DS."examples".DS."addressbook".DS."addrbook.php");

/*------- Access control ------------------- */
$user->allowed();

/* To update the existing contact in the addressbook
*/
if( isset($_GET['id']) ) {
	$id = $_GET['id'];
	$addrbook = $addrbook->find_by_id($id);
	$upload = $upload->find_by_id($addrbook->photo_id);
	if($upload->destroy()) {
		$result = $addrbook->delete($id);
		if($result) {
			$session->message( prepare_message("Contact successfully deleted", "success") );
		}
		else {
			$session->message( prepare_message("Contact could NOT be successfully deleted", "danger") );
		}
		redirect_to("index.php");
	}
}
?>