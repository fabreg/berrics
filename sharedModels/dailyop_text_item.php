<?php

class DailyopTextItem extends AppModel {
	
	

	public $belongsTo = array(
	
		"Dailyop",
		"MediaFile"
	
	);
	
	
	public function addNewTextBlock($dailyop_id = false) {
		
		$count = $this->find("count",array(
			"conditions"=>array("DailyopTextItem.dailyop_id"=>$dailyop_id)
		));
		$this->create();
		$this->save(array(
			"dailyop_id"=>$dailyop_id,
			"display_weight"=>($count++)
		));
		
	}
	
	public function removeMediaItem($id = false) {
		
		$this->id = $id;
		
		$this->save(array(
			"media_file_id"=>null
		));
		
	}
	
	
}


?>