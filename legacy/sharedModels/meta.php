<?php


class Meta extends AppModel {
	
	public $hasAndBelongsToMany = array(
	
		"Dailyop",
		"CanteenProduct"
	
	);
	
	
	public function addMeta($key,$val) {
		
		$id = false;
		
		//check to see if there is a key value match already in the database
		$check = $this->find("first",array(
		
			"conditions"=>array(
				"Meta.key"=>$key,
				"Meta.val"=>$val
			),
			"contain"=>array()
		
		));
		
		
		
		if(isset($check['Meta']['id'])) {
			
			$id = $check['Meta']['id'];
			
		} else {
			
			//insert a new meta tag
			
			$this->save(array(
			
				"key"=>$key,
				"val"=>$val
			
			));
			
			$id = $this->id;
			
		}
		
		return $id;
		
	}
	
	
	
}
?>