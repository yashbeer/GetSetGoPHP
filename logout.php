<?php
require_once("includes/config.php");

/* Create a log entry while user logs out
*/
//mention the filename of log
$log->filename = $session->username;
//record the new log in the file
$log->write("Logout : {$session->username} logged out.");

/* calling logout method of Session Class
*/
$session->logout();
$session->message( prepare_message("Logout Successful.", "info") );
redirect_to(BASE_URL."login.php");
?>