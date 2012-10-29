<?php

App::import("Vendor","SysMsg",array("file"=>"SysMsg.php"));

App::uses("Model","Model");

class AppModel extends Model {
	
	
	public $actsAs = array("Containable"=>array("recursive"=>true));
	
	public static $forceMaster = false;
	

	
	
}