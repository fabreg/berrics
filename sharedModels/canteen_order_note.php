<?php

class CanteenOrderNote extends AppModel {
	
	
	public $belongsTo = array(
		"User",
		"CanteenOrder"
	);
	public $hasOne = array(
		"Answer"=>array(
			
			"className"=>"CanteenOrderNote",
			"foreignKey"=>"answer_canteen_order_note_id"
	
		)
	);
	
	
	public function beforeSave() {
		
		if(empty($this->id) && empty($this->data['user_id'])) {
			
			$this->data['user_id'] = "4e57d978-b37c-4f93-abdd-197b323849cf";
				
		}
		
		return parent::beforeSave();
		
	}
	
	
	
	
}