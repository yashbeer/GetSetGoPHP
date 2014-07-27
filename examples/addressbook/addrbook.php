<?php
class Addrbook extends DatabaseObject {
	protected  $table_name="addrbook";
	protected  $db_fields=array('id', 'photo_id', 'name', 'email', 'mobile', 'address', 'comments');
	public $id;
	public $photo_id;
	public $name;
	public $email;
	public $mobile;
	public $address;
	public $comments;
}
$addrbook = new Addrbook();
?>