<?php
class CanteenPromoCode extends AppModel {
	var $name = 'CanteenPromoCode';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	public $hasMany = array(
		"CanteenOrder"
	);
	
	public function applyPromoCode($CanteenOrder) {
		
		
		return $CanteenOrder;
		
	}
	
}
?>