<?php

App::import("Vendor","SysMsg",array("file"=>"SysMsg.php"));

App::uses("Model","Model");

class AppModel extends Model {
	
	
	public $actsAs = array("Containable"=>array("recursive"=>true));
	
	public static $forceMaster = false;
	
	public function __construct($options = array()) {
		
		if(isset($_SERVER['FORCEMASTER'])) {
			
			$options['ds'] = "master";
			
		}
		
		parent::__construct($options);
		
	}
	
	public function find($conditions = null, $fields = array(), $order = null, $recursive = null) {

		if(isset($_SERVER['FORCEMASTER'])) {
			
			$this->useDbConfig = 'master';
			
		}
		
		if($this->table == "cake_sessions") $this->useDbConfig = "sessions";
		
		return parent::find($conditions, $fields, $order, $recursive);
		
	}
	
	public function field($name, $conditions = null, $order = null) {
		
		if(isset($_SERVER['FORCEMASTER'])) {
			
			$this->useDbConfig = 'master';
			
		}
		
		return parent::field($name,$conditions,$order);
		
	}
	
	public function save($data = null, $validate = true, $fieldList = array()) {
		
		if($this->table!='cake_sessions') $this->useDbConfig = 'master';
		
		$success = parent::save($data,$validate,$fieldList);
		
		if(!isset($_SERVER['FORCEMASTER']) && $this->table!='cake_sessions') {
			
			$this->useDbConfig = 'default';
			
		}
		
		return $success;
		
	}
	
	public function saveAll($data = null, $options = array()) {

		$this->useDbConfig = 'master';
		
		$status = parent::saveAll($data,$options);
		
		if(!isset($_SERVER['FORCEMASTER'])) {
			
			$this->useDbConfig = 'default';
			
		}
		
		return $status;
		
	}
	
	public function updateAll($fields, $conditions = true) {
		
		$this->useDbConfig = 'master';
		
		$status = parent::updateAll($fields,$conditions);
		
		
		if(!isset($_SERVER['FORCEMASTER'])) {
			
			$this->useDbConfig = 'default';
			
		}
		
		return $status;
		
	}
	
	public function delete($id = null, $cascade = true) {

		
		if($this->table!='cake_sessions') $this->useDbConfig = 'master';
		
		$status = parent::delete($id,$cascade);

		if(!isset($_SERVER['FORCEMASTER']) && $this->table!='cake_sessions') {
			
			$this->useDbConfig = 'default';
			
		}

		return $status;
		
	}
	
	public function query($query,$forceMaster = true) {
		
		if($forceMaster) $this->useDbConfig = "master";
		
		$status = parent::query($query);
		
		if(!isset($_SERVER['FORCEMASTER'])) {
			
			$this->useDbConfig = "default";
			
		}
		
		return $status;
		
	}
	
	function getLastQuery() {
		$dbo = $this->getDatasource();
		$logs = $dbo->getLog();
		$lastLog = end($logs['log']);
		return $lastLog['query'];
	}
	
	
	
}