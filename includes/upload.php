<?php
/* Upload class provides file uploading functionality
 * It overrides save() function from DatabaseObject class to handle uploading files
 *
 * Error checking in the files is also provided by this class.
 *
 * Methods: save(), destroy(), getpath(), geturl(), size_as_txt()
 */
class Upload extends DatabaseObject {
	/* These database table specific fields can be overwritten in derived class from this base class.
	*/
	protected  $table_name="uploads";
	protected  $db_fields=array('id', 'filename', 'type', 'size', 'caption');
	public $id;
	public $filename;
	public $type;
	public $size;
	public $caption;
	//
	public $upload_dir;
	private $temp_path;
	private $upload_url;
	
	public $errors=array();
	protected $upload_errors = array(
	// http://www.php.net/manual/en/features.file-upload.errors.php
	UPLOAD_ERR_OK			=> "No errors.",
	UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	UPLOAD_ERR_NO_FILE 		=> "No file.",
	UPLOAD_ERR_NO_TMP_DIR 	=> "No temporary directory.",
	UPLOAD_ERR_CANT_WRITE 	=> "Can't write to disk.",
	UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);
	
	function __construct() {
		//Default upload directory
		$this->upload_dir = SITE_ROOT.DS."uploads";
		$this->upload_url = BASE_URL."uploads/";
	}
	
	// Pass in $_FILE(['uploaded_file']) as an argument
	public function attach_file($file) {
		// Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)) {
			// error: nothing uploaded or wrong argument usage
			$this->errors[] = "No file was uploaded.";
			return false;
		}
		elseif($file['error'] != 0) {
			// error: report what PHP says went wrong
			$this->errors[] = $this->upload_errors[$file['error']];
			return false;
		}
		else {
			// Set object attributes to the form parameters.
			$this->temp_path  = $file['tmp_name'];
			$this->filename   = basename($file['name']);
			$this->type       = $file['type'];
			$this->size       = $file['size'];
			// The file has been attached and now is ready for saving.
			return true;
		}
		
	}
  
	public function save() {
		// A new record won't have an id yet.
		if(isset($this->id)) {
			// Really just to update the caption
			$this->update();
			return true;
		}
		else {
			// Make sure there are no errors

			// 1. Can't save if there are pre-existing errors
			if(!empty($this->errors)) { return false; }

			// 2. Make sure the caption is not too long for the DB
			if(strlen($this->caption) > 255) {
				$this->errors[] = "The caption can only be 255 characters long.";
				return false;
			}

			// 3. Can't save without filename and temp location
			if(empty($this->filename) || empty($this->temp_path)) {
				$this->errors[] = "The file location was not available.";
				return false;
			}

			// Determine the target_path
			$target_path = $this->upload_dir.DS.$this->filename;

			// 4. Make sure a file doesn't already exist in the target location
			if(file_exists($target_path)) {
				$this->errors[] = "The file {$this->filename} already exists.";
				return false;
			}

			// Attempt to move the file 
			if(move_uploaded_file($this->temp_path, $target_path)) {
				// Success
				// Save a corresponding entry to the database
				if($this->create()) {
					// We are done with temp_path, the file isn't there anymore
					unset($this->temp_path);
					return true;
				}
			}
			else {
				// File was not moved.
				$this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
				return false;
			}
		}
	}
	
	public function destroy() {
		// First remove the database entry
		if($this->delete()) {
			// then remove the file
		  // Note that even though the database entry is gone, this object 
			// is still around (which lets us use $this->image_path()).
			$target_path = $this->upload_dir.DS.$this->filename;
			return unlink($target_path) ? true : false;
		} else {
			// database delete failed
			return false;
		}
	}

	public function getpath() {
		return $this->upload_dir.DS.$this->filename;
	}
	
	public function geturl() {
	  return $this->upload_url.$this->filename;
	}
	
	public function size_as_text() {
		if($this->size < 1024) {
			return "{$this->size} bytes";
		} elseif($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}

}
$upload = new Upload();
?>