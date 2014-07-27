<?php
/* Phpmail is wrapper around php mail function and provides convenient way
 * to handle contact forms specially using serialize_form() function.
 * 
 * Methods:
 * make_header() -> creates headers. cc and bcc are optional, If 'cc' and 'bcc' are fields are
 * present then included in the header else ignored.
 * serialize_form() -> takes the data of form fields passed into an array as parameters and
 * convert the data into email message.
 * send() -> wrapper function around mail() in php
 */
class Phpmail {
	public $to;
	public $subject;
	public $message;
	
	public $from;
	public $reply_to;
	public $cc;
	public $bcc;
	
	private $header;
	
	private function make_header() {
		$this->header = "From: {$this->from} \r\n";
		if( !empty($this->reply_to) ) {
			$this->header .= "Reply-To: {$this->reply_to} \r\n";
		} else {
			$this->header .= "Reply-To: {$this->from} \r\n";
		}
		if( !empty($this->cc) ) {
			$this->header .= "Cc: {$this->cc} \r\n";
		}
		if( !empty($this->bcc) ) {
			$this->header .= "Bcc: {$this->bcc} \r\n";
		}
		$this->header .= "X-Mailer: PHP/".phpversion()."\r\n";
		$this->header .= "MIME-Version: 1.0\r\n";
		$this->header .= "Content-Type: text/plain; charset=iso-8859-1";
	}
	
	public function serialize_form($fields) {
		global $database;
		$message = null;
		foreach ($fields as $index) { 
			if(array_key_exists($index, $_POST)) {
				$message .= ucfirst($index)." : ".$_POST[$index]."\r\n\r\n";
				//ucfirst() is php function to capitalize first letter of the word
			} 
		}
		return $message;
	}
	
	public function send() {
		$this->make_header();
		$result = mail($this->to, $this->subject, $this->message, $this->header);
		return $result ? 'Sent' : 'Error';
	}
}
$phpmail = new Phpmail();
?>