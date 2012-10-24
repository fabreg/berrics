<?php

class SlsEntry extends AppModel {
	
	public $belongsTo = array(
		"Dailyop"
	);
	
	public function returnEntries() {
		
		$token = "sls-all-entries";
		
		if(($entries = Cache::read($token,"1min")) === false) {
			
			
			$entries = $this->find("all",array(
				
				"contain"=>array(),
				"order"=>array(
					"SlsEntry.name"=>"ASC"
				)
			));
			
			foreach($entries as $k=>$v) {
				
				$post = $this->Dailyop->returnPost(array("Dailyop.id"=>$v['SlsEntry']['dailyop_id']),1);
				
				$entries[$k] = array_merge($entries[$k],$post);
				
			}
		
			
			Cache::write($token,$entries,"1min");
			
		}
		
		return $entries;
		
	}
	
}