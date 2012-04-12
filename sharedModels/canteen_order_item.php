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
	
	
	public function calculateCartItems($CanteenOrder = array()) {

		$CanteenOrderItems = $CanteenOrder['CanteenOrderItem'];
		
		$salesTax = false;
		
		$taxRate = 0.00;
		
		$address = Set::extract("/UserAddress[address_type=shipping]",$CanteenOrder);
		
		if(
			array_key_exists($address[0]['UserAddress']['country_code'],$this->CanteenOrder->taxZones) && 
			array_key_exists($address[0]['UserAddress']['state'],$this->CanteenOrder->taxZones[$address[0]['UserAddress']['country_code']])
		) {
			
			$taxRate = $this->CanteenOrder->taxZones[$address[0]['UserAddress']['country_code']][$address[0]['UserAddress']['state']];
			
		}
		
		foreach($CanteenOrderItems as $k=>$v) {
			
			
			$item = $this->parseLineItem($v,$CanteenOrder['CanteenOrder']['currency_id'],$taxRate);
			
			if($item) {
				
				$CanteenOrderItems[$k] = $item;
				
			}
			
		}
		
		$CanteenOrder['CanteenOrderItem'] = $CanteenOrderItems;
		
		return $CanteenOrder;
			
	}
	
	
	private function parseLineItem($CanteenOrderItem,$currency_id = "USD",$taxRate = 0.00) {
		
		$ChildItems = $CanteenOrderItem['ChildCanteenOrderItem'];

		if(!$ChildItems) {
			
			return false;
			
		} else {
			
			//clear the value of the line item
			$CanteenOrderItem['sub_total'] = $CanteenOrderItem['tax_total'] = 0;
			
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
				
				$CanteenOrderItem['tax_total'] += ($taxRate/100)*$CanteenOrderItem['sub_total'];
				
			}
			
		}
		
		$CanteenOrderItem['ChildCanteenOrderItem'] = $ChildItems;
		
		return $CanteenOrderItem;
		
	}
	
	
	private function parseCanteenProduct($Item,$currency_id,$taxRate) {
		
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
			
			
			$Item["CanteenProduct"]=array_merge($child_product['CanteenProduct'],$child_product['CanteenProductInventory']);
			

			$Item['CanteenProduct']['ParentCanteenProduct'] = $child_product['ParentCanteenProduct'];
			
			unset($child_product);

			//copy the title/subtitle and opt_label and opt_value
			$Item['title'] = $Item['CanteenProduct']['ParentCanteenProduct']['name'];
			
			$Item['title'] .= " - ".$Item['CanteenProduct']['ParentCanteenProduct']['sub_title'];
			
			$Item['sub_title'] = $Item['CanteenProduct']['opt_label'];
			
			$Item['sub_title'] .= ":".$Item['CanteenProduct']['opt_value'];
			
			$Item['weight'] = $Item['CanteenProduct']['ParentCanteenProduct']['shipping_weight'];
			
			//$Item['tax_total'] = ($taxRate/100)*$Item['CanteenProduct']['ParentCanteenProduct']['CanteenProductPrice'][0]['price'];
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

}
