<?php
/* DatabaseObject class provides methods for instantiating class and performing CRUD operations.
 * 
 * find_by_id(), find_all() use generalized method find_by_sql() to retrieve a database record.
 *
 * instatiate(record) -> takes database record as parameter and returns object of that record.
 *
 * CRUD methods: save(), create(), update(), delete()
 */
class DatabaseObject {

	// Common Database Methods
	public function find_by_sql($sql="") {
		global $database;
		$result_set = $database->query($sql);
		$object_array = array();
		while ($row = $database->fetch_array($result_set)) {
		  $object_array[] = $this->instantiate($row);
		}
		return $object_array;
	}

	public function find_by_id($id=0) {
		global $database;
		$result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
		
		return !empty($result_array) ? array_shift($result_array) : false;
	}

	public function find_all() {
		return $this->find_by_sql("SELECT * FROM ".$this->table_name);
	}

	public function count_all() {
		global $database;
		$sql = "SELECT COUNT(*) FROM ".$this->table_name;
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		return array_shift($row);
	}

	private function instantiate($record) {
		//instantiating the class using this keyword
		$object = new $this;
		
		// Simple, long-form approach:
		// $object->id 			= $record['id'];
		// $object->username 	= $record['username'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
			//To check whether database column_name is present as attributes of this class
			if( array_key_exists($attribute, $this->attributes()) ) {
				$object->$attribute = $value;
			}
		}
		return $object;
	}

	protected function attributes() { 
		// return an array of attribute names and their sanitized values
		global $database;
		$attributes = array();
		foreach($this->db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $database->escape_value($this->$field);
			}
		}
		return $attributes;
	}

	public function save() {
	  // A new record won't have an id yet. If it has then update else create new record.
	  return isset($this->id) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		// SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->attributes();
		$sql = "INSERT INTO ".$this->table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		//echo "The create query:  ".$sql."<br><br>";
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		} else {
			return false;
		}
	}

	public function update() {
	  global $database;
		// SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".$this->table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
		//echo "The update query:  ".$sql."<br><br>";
		$database->query($sql);
		return ($database->affected_rows() >= 1) ? true : false;
	}

	public function delete() {
		global $database;
		// SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = "DELETE FROM ".$this->table_name;
		$sql .= " WHERE id=". $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		return ($database->affected_rows() == 1) ? true : false;
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful in displaying some info about deleted object, as in:
		// echo $user->first_name . " was deleted";
		// but we definitely can't call $user->update() 
		// after calling $user->delete().
	}
  
}
?>