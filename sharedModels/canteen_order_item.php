<?php

class CanteenOrderItem extends AppModel {
	
	
	public $belongsTo = array(
		"CanteenProduct",
		"CanteenProductOption"=>array(
			"className"=>"CanteenProduct",
			"foreignKey"=>"canteen_product_option_id"
		)
	);
	
	
	
}