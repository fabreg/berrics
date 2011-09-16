<?php

class CanteenOrderItem extends AppModel {
	
	
	public $belongsTo = array(
		"CanteenProduct",
		"CanteenProductOption"=>array(
			"className"=>"CanteenProduct",
			"foreignKey"=>"canteen_product_option_id"
		)
	);
	
	
	public function returnToStock($id = false,$qty = false) {
		
		if(!$id || !$qty) throw new Exception("(CanteenOrderItem::returnToStock): You mush specify both a line item id and a qty!");
		
		//get the line item 
		
		$item = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrderItem.id"=>$id
			),
			"contain"=>array(
				"CanteenProduct",
				"CanteenProductOption"
			)
		));
		
		//what id are we going to use?
		
		$p_id = (!empty($item['CanteenProductOption']['id'])) ? $item['CanteenProductOption']['id']:$item['CanteenProduct']['id']; 
		
		
		if($this->CanteenProduct->query(
			"UPDATE canteen_products SET quantity = (quantity+{$qty}) where id = '{$p_id}' LIMIT 1"
		)) {
			
			
			$this->create();
			
			$this->id = $id;
			
			return $this->save(array(
				"process_inventory"=>0
			));
			
		}
		
		return false;
		
	}
	
	
}