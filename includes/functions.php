<?php
/*-----------------------------------------------------------
|					General functions 						|
-------------------------------------------------------------*/
function redirect_to( $location = NULL ) {
	if ($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

function prepare_message($message="", $status="info") {
	//using the bootstrap alert display css
	if (!empty($message)) { 
		return "<div class=\"alert alert-dismissible alert-{$status}\">
		<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>
		{$message}</div>";
	} else {
		return "";
	}
}

function strip_zeros_from_date( $marked_string="" ) {
	// first remove the marked zeros
	$no_zeros = str_replace('*0', '', $marked_string);
	// then remove any remaining marks
	$cleaned_string = str_replace('*', '', $no_zeros);
	return $cleaned_string;
}

function datetime_to_text($datetime="") {
	$unixdatetime = strtotime($datetime);
	return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function __autoload($class_name) {
	//This function tries to find the class name by default if developer by mistake forgets to include it.
	$class_name = strtolower($class_name);
	$path = INCLUDE_PATH.DS."{$class_name}.php";
	if(file_exists($path)) {
		require_once($path);
	} else {
		die("The file {$class_name}.php could not be found.");
	}
}

/*-----------------------------------------------------------
|					Layout related functions 				|
-------------------------------------------------------------*/
function menuactive($num) {
	global ${$num};
	${$num} = " active ";
}
?>