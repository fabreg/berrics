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
	
	public $ljg_inv_schema = array(
		'Company Number',
		'UPC Code',
		'ProductCode',
		'Color',
		'Size Type',
		'Size',
		'Quantity',
		'Available Date'
	);
	
	public function allocateInventory($canteen_inventory_record_id=false,$qty = 0) {
		
		if(!$canteen_inventory_record_id) return false;
		
		return $this->query(
			"UPDATE canteen_inventory_records SET allocated=(allocated+{$qty}),quantity=(quantity-{$qty}) WHERE id='$canteen_inventory_record_id'"
		);
		
		
	}
	
	public function returnAllocatedInventory($canteen_inventory_record_id = false,$qty=0) {
		
		if(!$canteen_inventory_record_id) return false;
		
		return $this->query(
			"UPDATE canteen_inventory_records SET allocated=(allocated-{$qty}),quantity=(quantity+{$qty}) WHERE id='$canteen_inventory_record_id'"
		);
		
		
	}
	
	public function import_ljg_inventory() {
		
		set_time_limit(0);
		
		//file
		$file = "/home/sites/lajolla/inventory.txt";
		
		//$file_str = file_get_contents($file);
		
		//$file_str = trim($file_str);
		
		$csv_rows = $file_str = file($file);
		
		//$csv_rows = explode("\n",$file_str);
		
		//die(pr(count($csv_rows)));
		
		$counter = 0;
		
		foreach($csv_rows as $v) {
				
			$str = trim($v);
			
			$cols = array_combine($this->ljg_inv_schema,explode("\t",$str));
			
			if(empty($cols['UPC Code'])) continue;
			
			$record = $this->findByForeignKey($cols['UPC Code']);
			
			if(!empty($record['CanteenInventoryRecord']['id'])) {
				
				$uq =$cols['Quantity']-$record['CanteenInventoryRecord']['allocated'];
				$s = "update canteen_inventory_records set
						quantity = $uq 
					WHERE id = {$record['CanteenInventoryRecord']['id']} LIMIT 1;";
				echo $s;
				echo "\n"; $counter++;
			}
			
		}
		
		die($counter." Records Updated");
	}

}
