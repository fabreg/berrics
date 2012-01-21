<?php

class BerricsRecord extends AppModel {
	
	public $hasMany = array("BerricsRecordsItem");
	
	
	public function getRecords() {
		
		
		$token = "for-the-record-section";
		
		if(($records = Cache::read($token,"1min")) === false) {
			
		
			$records = $this->find("all",array(
				"conditions"=>array(
					"BerricsRecord.active"=>1,
					"BerricsRecord.publish_date<NOW()"
				),
				"contain"=>array(
					"BerricsRecordsItem"=>array(
						"order"=>array(
							"BerricsRecordsItem.current_record"=>"DESC"
						)
					)
				),
				"order"=>array(
					"BerricsRecord.publish_date"=>"ASC"
				)
			));
			
			//get all the record items/post/users for each record
			
			foreach($records as $k=>$v) {
				
				foreach($v['BerricsRecordsItem'] as $kk=>$vv) {
					                                                                                                   
					$post = $this->BerricsRecordsItem->Dailyop->returnPost(array(
						"Dailyop.id"=>$vv['dailyop_id']
					));
					
					$user = $this->BerricsRecordsItem->User->find("first",array(
						"conditions"=>array("User.id"=>$vv['user_id']),
						"contain"=>array()
					));
					
					$records[$k]['BerricsRecordsItem'][$kk]['User'] = $user['User'];
					$records[$k]['BerricsRecordsItem'][$kk]['Post'] = $post; 
					
				}
				
			}
			
			Cache::write($token,$records,"1min");
			
		}
		
		
		return $records;
		
		
	}
	
	
}