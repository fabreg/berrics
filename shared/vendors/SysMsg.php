<?php


class SysMsg {
	
	
	public static $_model = false;
	
	
	private function __construct() { }
	
	
	public static function getModel() {
		
		if(!self::$_model) self::$_model = ClassRegistry::init("SystemMessage");
		
		return self::$_model;
		
	}
	
	
	public static function add($data = array()) {
		
		$m = self::getModel();
		
		$m->create();
		
		$m->save($data);
		
	}
	
	
	
}