<?php

class YounitedNationsEventEntry extends AppModel {
	
	public $belongsTo = array(
		"YounitedNationsPosse"=>array(
			"foreignKey"=>"younited_nations_posse_id"
		),
		"Dailyop"=>array(
			"foreignKey"=>"entry_dailyop_id"
		)
	);
	
	
	public function updateEntry($data=array()) {
		
		//lets check to see if an incoming YN Posse ID is incoming.
		//if not; then create a new posse
		if(!isset($data['YounitedNationPosse']['id'])) {
			
			$this->YounitedNationsPosse->create();
			$this->YounitedNationsPosse->save($data['YounitedNationsPosse']);
			$data['YounitedNationsPosse']['id'] = $this->YounitedNationsPosse->id;
			
		}
		
		//check to make sure we have posse id's
		foreach($data['YounitedNationsPosseMember'] as $k=>$v) {
			
			if(!isset($v['younited_nations_posse_id'])) 
				$data['YounitedNationsPosseMember'][$k]['younited_nations_posse_id'] = $data['YounitedNationsPosse']['id'];
			
		}
		
		//update posse members
		$this->YounitedNationsPosse->create();
		$this->YounitedNationsPosse->id = $data['YounitedNationsPosse']['id'];
		$this->YounitedNationsPosse->saveAll($data);
		
		//repopulate the members
		$mem = $this->YounitedNationsPosse->YounitedNationsPosseMember->find("all",array(
			"contain"=>array(),
			"conditions"=>array(
				"YounitedNationsPosseMember.younited_nations_posse_id"=>$data['YounitedNationsPosse']['id']
			)
		));
		$tmp = array();
		foreach($mem as $k=>$v) $tmp[] = $v['YounitedNationsPosseMember'];
		
		$data['YounitedNationsPosseMember'] = $tmp;
		
		
		//check to see if we have an incoming entry id;
		//if not then we need to create a new entry
		if(!isset($data['YounitedNationsEventEntry']['id'])) {
			
			//create the entry
			$this->create();
			$this->save(array(
				"younited_nations_posse_id"=>$data['YounitedNationsPosse']['id'],
				"younited_nations_event_id"=>$data['YounitedNationsEvent']['id'],
				"active"=>1
			));
			
			$data['YounitedNationsEventEntry']['id'] = $this->id;
			
		} else {
			
			$this->create();
			$this->id = $data['YounitedNationsEventEntry']['id'];
			$this->save(array(
				"younited_nations_posse_id"=>$data['YounitedNationsPosse']['id']
			));
			
		}
		$e = $this->read();
		$data['YounitedNationsEventEntry'] = $e['YounitedNationsEventEntry'];
		
		return $data;
		
	}
	
	public function returnEntry($cond = array()) {
		
		$entry = $this->find("first",array(
		
			"conditions"=>$cond
		
		));
		
		
	}
	
	
}