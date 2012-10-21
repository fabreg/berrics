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
	

	
	
	
	
}