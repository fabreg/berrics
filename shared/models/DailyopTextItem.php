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
	
	public static function placements() {
		
		$img_dir = array(
		
				"top"=>"TOP",
				"left"=>"LEFT",
				"right"=>"RIGHT",
				"bottom"=>"BOTTOM"
		);
		
		return $img_dir;
		
	}

	public static function headingStyles() {
	return array(
			"default"=>"default"
			);
	}

	public static function textContentStyles() {
		return array(
				"default"=>"default",
				"interview-one-col"=>"Interview One Column",
				"interview-two-col"=>"Interview Two Column",
				"interview-three-col"=>"Interview Three Column",
				"interview-full-image"=>"Interview Full Image"
			);
	}
	
}


?>