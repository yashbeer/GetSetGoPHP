<?php
/* MYSQLDatabase class deals with all basic methods of database.
 *
 * constructor: opens database connection and checks whether magic_quotes and real_escape_strings are active.

 * query($sql): takes sql query and executes it.

 * Database neutral methods: fetch_array($result_set), num_rows($result_set), affected_rows(), insert_id();

 * escape_value($value): escapes quotes to prevent sql injection. 
 */
class MySQLDatabase {
	private $connection;
	public $last_query;
	private $magic_quotes_active;
	private $real_escape_string_exists;
	
	function __construct() {
		$this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
	}
	
	public function open_connection() {
		$this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysql_error());
		}
		else {
			$db_select = mysql_select_db(DB_NAME, $this->connection);
			if (!$db_select) {
				die("Database selection failed: " . mysql_error());
			}
		}
	}
	
	public function close_connection() {
		if(isset($this->connection)) {
			mysql_close($this->connection);
			unset($this->connection);
		}
	}
	
	public function query($sql) {
		$this->last_query = $sql;
		$result = mysql_query($sql, $this->connection);
		if(!$result) {
			$output = "Database query failed: " . mysql_error() . "<br />";
			die( $output );
		}
		return $result;
	}
	
	/* -------   Database neutral methods ----------- */
	public function fetch_array($result_set) {
		return mysql_fetch_array($result_set);
	}
	
	public function num_rows($result_set) {
		return mysql_num_rows($result_set);
	}
	
	public function affected_rows() {
		return mysql_affected_rows($this->connection);
	}
	
	public function insert_id() {
		return mysql_insert_id($this->connection); // get the last id inserted over the current db connection
	}
	/*--------------------------------------------------*/
	
	public function escape_value( $value ) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysql_real_escape_string( $value );
		}
		else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}
	
}
$database = new MySQLDatabase();
?>