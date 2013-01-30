<?php
class CanteenOrderItem extends AppModel {
	var $name = 'CanteenOrderItem';
	
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'ParentCanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CanteenProduct' => array(
			'className' => 'CanteenProduct',
			'foreignKey' => 'canteen_product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CanteenShippingRecord' => array(
			'className' => 'CanteenShippingRecord',
			'foreignKey' => 'canteen_shipping_record_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CanteenOrder' => array(
			'className' => 'CanteenOrder',
			'foreignKey' => 'canteen_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		"CanteenInventoryRecord"
	);

	var $hasMany = array(
		'ChildCanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'parent_id',
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
	
	public function cancelOrderItem($id) {
		
		//get the lin
		
		$item = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrderItem.id"=>$id
			),
			"contain"=>array()
		));
		
		$this->CanteenInventoryRecord->returnAllocatedInventory($item['CanteenOrderItem']['canteen_inventory_record_id'],$item['CanteenOrderItem']['quantity']);
		
		$this->create();
		
		$this->id = $item['CanteenOrderItem']['id'];
		
		$this->save(array(
			"canteen_inventory_record"=>null,
			"canteen_shipping_record_id"=>null
		));
		
	}
	
	public function calculateCartItems($CanteenOrder = array()) {

		$CanteenOrderItems = $CanteenOrder['CanteenOrderItem'];
		
		$salesTax = false;
		
		
		
		foreach($CanteenOrderItems as $k=>$v) {
			
			
			$item = $this->parseLineItem($v,$CanteenOrder['CanteenOrder']['currency_id']);
			
			if($item) {
				
				$CanteenOrderItems[$k] = $item;
	
				$CanteenOrder['CanteenOrder']['taxable_total'] += $item['taxable_total'];
				
			}
			
		}
		
		$CanteenOrder['CanteenOrderItem'] = $CanteenOrderItems;
		
		return $CanteenOrder;
			
	}
	
	
	private function parseLineItem($CanteenOrderItem,$currency_id = "USD") {
		
		$ChildItems = $CanteenOrderItem['ChildCanteenOrderItem'];
		
		if(!$ChildItems) {
			
			return false;
			
		} else {
			
			//clear the value of the line item
			$CanteenOrderItem['sub_total'] = $CanteenOrderItem['tax_total'] =  $CanteenOrderItem['taxable_total'] = 0;
			
			//loop through the child rows
			foreach($ChildItems as $key=>$child) {
				
				if(isset($child['canteen_product_id']) && !empty($child['canteen_product_id'])) {
					
					$ChildItems[$key] = $this->parseCanteenProduct($child,$currency_id,$taxRate);
					
				} else {
					
					if($child['promo']) {
						
						$ChildItems[$key]['sub_total'] = $this->CanteenOrder->Currency->convertCurrency("USD",$currency_id,$ChildItems[$key]['sub_total']);
						
					}
					
				}
				
				$CanteenOrderItem['sub_total'] += $ChildItems[$key]['sub_total'];
				
			}

			//sales tax
			if(!$CanteenOrderItem['promo']) {
				
				$CanteenOrderItem['taxable_total'] += $CanteenOrderItem['sub_total'];
				
			}
			
		}
		
		$CanteenOrderItem['ChildCanteenOrderItem'] = $ChildItems;
		
		return $CanteenOrderItem;
		
	}
	
	
	private function parseCanteenProduct($Item,$currency_id) {
		
			$Item['sub_total'] = $Item['tax_total'] = 0;
		
			$child_product = $this->CanteenProduct->find("first",array(
				"conditions"=>array(
					"CanteenProduct.id"=>$Item['canteen_product_id']
				),
				"contain"=>array(
					"ParentCanteenProduct"=>array(
						"Brand",
						"CanteenProductPrice"=>array(
							"conditions"=>array(
								"CanteenProductPrice.currency_id"=>$currency_id
							)
						),
						"CanteenProductImage"
					),
					"CanteenProductInventory"=>array(
						"order"=>array("CanteenProductInventory.priority"=>"DESC"),
						"CanteenInventoryRecord"=>array("Warehouse")
					)
				)
			));
			
			//format the return like the admin order
			
			
			$Item["CanteenProduct"]=array_merge($child_product['CanteenProduct'],$child_product['CanteenProductInventory'][0]);
			

			$Item['CanteenProduct']['ParentCanteenProduct'] = $child_product['ParentCanteenProduct'];
			
			unset($child_product);
			
			//copy the title/subtitle and opt_label and opt_value
			$Item['title'] = $Item['CanteenProduct']['ParentCanteenProduct']['name'];
			
			$Item['title'] .= " - ".$Item['CanteenProduct']['ParentCanteenProduct']['sub_title'];
			
			if(isset($Item['CanteenProduct']['ParentCanteenProduct']['Brand']['name'])) $Item['brand_label'] = $Item['CanteenProduct']['ParentCanteenProduct']['Brand']['name'];
			
			$Item['sub_title'] = $Item['CanteenProduct']['opt_label'];
			
			$Item['sub_title'] .= ":".$Item['CanteenProduct']['opt_value'];
			
			$Item['weight'] = $Item['CanteenProduct']['ParentCanteenProduct']['shipping_weight'];
			
			if(empty($Item['sub_total']))
				$Item['sub_total'] = $Item['CanteenProduct']['ParentCanteenProduct']['CanteenProductPrice'][0]['price']*$Item['quantity'];
	
			return $Item;
		
	}
	
	public function validateCartItems($CanteenOrder) {
		
		
	}
	
	/**
	 * Remove a child item from an order and update it's parent with new sub_total
	 * 
	 * @param ChildCanteenOrderItem.id $item_id
	 * @return decimal
	 */
	public function returnOrderItem($item_id) {
		
		$item = $this->find("first",array("conditions"=>array("CanteenOrderItem.id"=>$item_id)));
		
		if($item) {
			
			$this->CanteenInventoryRecord->returnAllocatedInventory($item['CanteenOrderItem']['canteen_inventory_record_id'],$item['CanteenOrderItem']['quantity']);
			
		}
		
		//is there a parent line item to update?
		
		if(!empty($item['CanteenOrderItem']['parent_id'])) {
			
			//deduct the total from the parent row
			$this->query(
				"UPDATE canteen_order_items SET sub_total=(sub_total-{$item['CanteenOrderItem']['sub_total']}) WHERE id={$item['CanteenOrderItem']['parent_id']}"
			);
			
		}
		
		//now, commit suicide
		
		$this->delete($item['CanteenOrderItem']['id']);
		
		return $item['CanteenOrderItem']['sub_total'] + $item['CanteenOrderItem']['tax_total'];
		
	}
	
	public function processLineItemInventory($item_id) {
		
		//let's get the line item
		$item = $this->find("first",array(
			"conditions"=>array(
				"CanteenOrderItem.id"=>$item_id,
				"OR"=>array(
					"CanteenOrderItem.inventory_processed"=>0,
					"CanteenOrderItem.inventory_processed"=>NULL
				)
			),
			"contain"=>array(
				"CanteenInventoryRecord"
			)
		));
		
		$qty_on_order = $item['CanteenOrderItem']['quantity'];
		
		if(!empty($item['CanteenOrderItem']['canteen_inventory_record_id'])) {
			
			$this->query(
				"UPDATE canteen_inventory_records SET allocated = ((allocated+0)-{$qty_on_order}) WHERE id = '{$item['CanteenOrderItem']['canteen_inventory_record_id']}'"
			);
			
			$this->create();
			$this->id = $item['CanteenOrderItem']['id'];
			$this->save(array(
				"inventory_processed"=>1
			));
			
		}
		
		
		
	}

}
