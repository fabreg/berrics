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
			
			$c = $v['ChildCanteenOrderItem'];
			
			$v['sub_total'] = $v['quantity'] = $v['tax_total'] = 0;
			
			foreach($c as $key=>$val) {
				
				$child_product = $this->CanteenProduct->find("first",array(
					"conditions"=>array(
						"CanteenProduct.id"=>$val['canteen_product_id']
					),
					"contain"=>array(
						"ParentCanteenProduct"=>array(
							"Brand",
							"CanteenProductPrice"=>array(
								"conditions"=>array(
									"CanteenProductPrice.currency_id"=>$CanteenOrder['CanteenOrder']['currency_id']
								)
							),
							"CanteenProductImage"
						)
					)
				));
				
				//format the return like the admin order
				
				$cp = array(
					"CanteenProduct"=>$child_product['CanteenProduct']
				);

				$cp['CanteenProduct']['ParentCanteenProduct'] = $child_product['ParentCanteenProduct'];
				
				unset($child_product);
				
				$v['ChildCanteenOrderItem'][$key] =  array_merge($v['ChildCanteenOrderItem'][$key],$cp);
				
				$v['ChildCanteenOrderItem'][$key]['tax_total'] = ($taxRate/100)*$v['ChildCanteenOrderItem'][$key]['CanteenProduct']['ParentCanteenProduct']['CanteenProductPrice'][0]['price'];
				
				$v['ChildCanteenOrderItem'][$key]['sub_total'] = $v['ChildCanteenOrderItem'][$key]['CanteenProduct']['ParentCanteenProduct']['CanteenProductPrice'][0]['price'];
				
				$v['sub_total'] += $v['ChildCanteenOrderItem'][$key]['CanteenProduct']['ParentCanteenProduct']['CanteenProductPrice'][0]['price'];
				
				$v['quantity'] += $v['ChildCanteenOrderItem'][$key]['quantity'];
				
				$v['tax_total'] += $v['ChildCanteenOrderItem'][$key]['tax_total'];
				
			}
			
			
			$CanteenOrderItems[$k] = $v;
			
		}
		
		$CanteenOrder['CanteenOrderItem'] = $CanteenOrderItems;
		
		
		return $CanteenOrder;
		
		
	}

}
