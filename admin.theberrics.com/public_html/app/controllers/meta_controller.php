<?php

App::import("Controller","AdminApp");

class MetaController extends AdminAppController {
	
	public $uses = array("Meta");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	public function index() {
		
		
	}
	
	
	public function ajax_auto_key() {
		
		
		$key = $_GET['term'];
		
		$keys = $this->Meta->find("all",array(
			"fields"=>array("Distinct(Meta.key) AS `Meta.key`"),
			"conditions"=>array(
				"Meta.key LIKE"=>$key."%"
			),
			"contain"=>array()
		
		));
		//die(pr($keys));
		$labels = Set::extract('/Meta/Meta.key',$keys);
		
		die(json_encode($labels));
		
		
	}
	
	public function ajax_auto_val() {
		
				
		$key = $_GET['term'];
		
		$keys = $this->Meta->find("all",array(
			"fields"=>array("Distinct(Meta.val) AS `Meta.val`"),
			"conditions"=>array(
				"Meta.val LIKE"=>$key."%"
			),
			"contain"=>array()
		
		));
		//die(pr($keys));
		$labels = Set::extract('/Meta/Meta.val',$keys);
		
		die(json_encode($labels));
		
	}
	
	
	
}

?>