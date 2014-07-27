<?php
/* Log class provides complete loggin functionality. It can be used to track user activities
 * or could help in loggin the intermediate errors in the file.
 *
 * Methods: open_file(), write(), read(), getlast_record(), close_file()
 */
class Log {
	public $filepath;
	public $filename;
	public $mode = 'a+';
	private $handle;
	
	private function open_file() {
		//default file path
		$this->filepath = SITE_ROOT.DS.'logs';
		//construct the full file path where logs will be stored
		$file = $this->filepath.DS.$this->filename.".txt";
		//open the file if it exits, create one if it doesn't
		$this->handle = fopen($file, $this->mode);
		if (!$this->handle) {
			die("File: {$this->filepath} could NOT be opened! ");
		}
	}
	
	public function write($message="") {
		$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$message}\n";
		
		$this->open_file();
		if($this->handle) {
			if( fwrite($this->handle,$content) ) {
				$this->close_file();
				return true;
			}
		}
	}
	
	public function getlast_record() {
		$cursor = -1;
		$char = "";
		$line = "";
		
		$this->open_file();
		if($this->handle) {
			//$this->handle = fopen($this->filepath, 'r');
			fseek($this->handle, $cursor, SEEK_END);
			$char = fgetc($this->handle);
			/**
			* Trim trailing newline chars of the file
			*/
			while ($char === "\n" || $char === "\r") {
				fseek($this->handle, $cursor--, SEEK_END);
				$char = fgetc($this->handle);
			}
			/**
			* Read until the start of file or first newline char
			*/
			while ($char !== false && $char !== "\n" && $char !== "\r") {
				$line = $char . $line;  //Prepend the new char
				fseek($this->handle, $cursor--, SEEK_END);
				$char = fgetc($this->handle);
			}
			return $line;
		}
		
	}
	
	public function read($nooflines="") {
		$lines = array();
		$this->open_file();
		
		if($this->handle) {
		
			if($nooflines == "all") {
				while(!feof($this->handle)) {
					$line = fgets($this->handle, 4096);
					array_push($lines, $line);
				}
				return array_filter($lines);
			}
			else {
				if( is_numeric($nooflines) ) {
					$nooflines = $nooflines;
				}
				else {
					$nooflines = 10; //default no of lines
				}
				while(!feof($this->handle)) {
					$line = fgets($this->handle, 4096);
					array_push($lines, $line);
					if( count($lines)>($nooflines+1) ) {
						array_shift($lines);
					}
				}
				
				return array_filter($lines);
			}
			
		}
	}
	
	private function close_file() {
		if(isset($this->handle)) {
			fclose($this->handle);
			unset($this->handle);
		}
	}

}
$log = new Log();
?>