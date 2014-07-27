<?php
/* Session class helps working Sessions
 * First.. to manage logging users in and out.
 * Second.. to handle messages (user builtin messages/error/warnings), used for displaying
 * messages after redirection.
 * Third.. to store few values in session
 *
 * login and authenticate are two methods which are custom made for redirection purposes only.
 *
 * NOTE: When working with sessions, it is generally inadvisable to store DB-related objects in * sessions.
 */

class Session {
	public $username;
	public $designation; //This is optional. Required for User Access Control Feature.
	public $message;

	function __construct() {
		session_start();
		$this->check_message();
		$this->check_login();
	}

	private function check_message() {
		// Is there a message stored in the session?
		if(isset($_SESSION['message'])) {
			// Add it as an attribute and erase the stored version
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}
		else {
			$this->message = "";
		}
	}	
	
	private function check_login() {
		if(isset($_SESSION['username'])) {
			$this->username = $_SESSION['username'];
			$this->designation = $_SESSION['designation'];
		}
		else {
			unset($this->username);
			unset($this->designation);
		}
	}

	public function login($user) { // This function takes in array of user details
		if($user){
		  $this->username = $_SESSION['username'] = $user->username; //here user_id is 'id' from login table
		  $this->designation = $_SESSION['designation'] = $user->designation;
		}
	}
  
	public function logout() {
		unset($_SESSION['username']);
		unset($this->username);
		unset($_SESSION['designation']);
		unset($this->designation);
	}
	
	public function is_logged($name = "") {
		if( empty($name) ) {
			return !empty($this->username) ? true : false;
		}
		else {
			//if name to be tested matches with the logged in username, return true
			return $this->username == $name ? true : false;
		}
	}
	public function is_logged_as($designation) {
		//if designation to be tested matches with the logged designation, return true
		return $this->designation == $designation ? true : false;
	}

	public function message($msg="") {
	  if(!empty($msg)) {
	    // if parameter is passed, then this is "set message"
	    $_SESSION['message'] = $msg;
	  } else {
	    // if parameter is not passed, then this is "get message"
			return $this->message;
	  }
	}
	
}
$session = new Session();
$message = $session->message();
?>