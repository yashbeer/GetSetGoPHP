<?php
/* User class handles logging of users in the system and access control.
 * So its Authentication and Authorization happening here.
 *
 * Methods: authenticate(), find_by_username()
 *
 * Access control methods: allowed(), notallowed()
 */
class User extends DatabaseObject {
	
	protected $table_name="user";
	protected $db_fields = array('id', 'username', 'password', 'designation');
	
	public $id;
	public $username;
	public $password;
	public $designation;

	public function authenticate($username="", $password="") {
		global $database;
		$username = $database->escape_value($username);
		$password = $database->escape_value(sha1($password)); //hash the password

		$sql  = "SELECT * FROM ".$this->table_name;
		$sql .= " WHERE username = '{$username}'";
		$sql .= " AND password = '{$password}'";
		$sql .= " LIMIT 1";
		$result_array = $this->find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function find_by_username($username) {
		global $database;
		$result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE username='".$database->escape_value($username)."' LIMIT 1");
		
		return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	/* -------- access control features implemented to user class ---------- */
	
	public function allowed($name = "") {
		global $session;
		//By default: allowed() function allows any user who is logged in.
		if( empty($name) ) {
			$session->is_logged() ? true : redirect_to(REDIRECT_URL);
		}
		else {
			($session->username == $name || $session->designation == $name) ? true : redirect_to(REDIRECT_URL);
		}
		
	}
	
	public function notallowed($names = "") {
		global $session;
		//if no names provided.. restrict access to all
		if( empty($names) ) {
			redirect_to(REDIRECT_URL);
		}
		else {
			//to remove all white spaces from the string
			$names = preg_replace('/\s+/','',$names);
			//convert the string to array
			$name_array = explode(',', $names);
			//check if the loggedin username or designation exists in given array.. and restrict access to it.
			if (in_array($session->username, $name_array) || in_array($session->designation, $name_array)) {
				redirect_to(REDIRECT_URL);
			}
			else {
				return true;
			}
		}
	}
	
	/* ----------- access control ends ---------------------------*/

}

$user = new User();

?>