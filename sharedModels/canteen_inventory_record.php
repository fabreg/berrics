<?php
class CanteenInventoryRecord extends AppModel {
	var $name = 'CanteenInventoryRecord';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Warehouse' => array(
			'className' => 'Warehouse',
			'foreignKey' => 'warehouse_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'CanteenProductInventory' => array(
			'className' => 'CanteenProductInventory',
			'foreignKey' => 'canteen_inventory_record_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function allocateInventory($canteen_inventory_record_id=false,$qty = 0) {
		
		if(!$canteen_inventory_record_id) return false;
		
		return $this->query(
			"UPDATE canteen_inventory_records SET allocated=(allocated+{$qty}),quantity=(quantity-{$qty}) WHERE id='$canteen_inventory_record_id'"
		);
		
		
	}
	
	public function returnAllocatedInventory($canteen_inventory_record_id = false,$qty=0) {
		
		
		
	}

}
