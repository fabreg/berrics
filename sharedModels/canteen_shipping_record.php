<?php
class CanteenShippingRecord extends AppModel {
	var $name = 'CanteenShippingRecord';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Warehouse' => array(
			'className' => 'Warehouse',
			'foreignKey' => 'warehouse_id',
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
		"UserAddress"
	);

	var $hasMany = array(
		'CanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'canteen_shipping_record_id',
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
	
	public $shippingZones = array(
		
	);
	
	
	public function save($data = array()) {
		
		if(empty($this->id)) {
			
			if($data['CanteenShippingRecord']) {
				
				$data['CanteenShippingRecord']['id'] = $this->genId();
				
			} else {
				
				$data['id'] = $this->genId();
				
			}
			
			
		}
		
		return parent::save($data);
		
	}
	
	private function genId() {
		
		$id = mt_rand(10000000,99999999);
		
		$chk = $this->find("count",array("conditions"=>array("CanteenShippingRecord.id"=>$id)));
		
		if($chk>0) {
			
			return $this->genId();
			
		}
		
		return $id;
		
	}
	
	public static function shippingZones() {
		
		$z = array();
		
		//usa
		$z[] = array(
			"countries"=>array(
				"US"
			),
			"rates"=>array(
				0=>19.95,
				1=>5.00,
				2=>6.00,
				3=>7.00,
				4=>8.00,
				5=>9.00,
				6=>10.00
			)
		);
		
		//canada
		$z[] = array(
			"countries"=>array(
				"CA"
			),
			"rates"=>array(
				0=>19.95,
				1=>6.00,
				2=>7.00,
				3=>8.00,
				4=>9.00,
				5=>10.00,
				6=>11.00
			)
		);
		//aus
		
		//uk
		
		//europe
		
		//brasil
		
		//default
		$z['def'] = array(
			"countries"=>array(),
			"rates"=>array(
				0=>30.95,
				1=>50.00,
				2=>60.00,
				3=>70.00,
				4=>80.00,
				5=>90.00,
				6=>100.00
			)
		);
		
		return $z;
		
	}
	
	public static function returnShippingRate($weight=1.00,$country_code='US') {
		
		
		$weight = ceil($weight);
		
		
		
		$zones = self::shippingZones();
		
		$rates = $zones['def']['rates'];
		$rate = $rates[0];
		
		foreach($zones as $v) {
			
			if(in_array($country_code,$v['countries'])) {
				
				$rates = $v['rates'];
				
				$rate = $rates[0];
				
				if(isset($rates[$weight])) {
					
					$rate=$rates[$weight];
					
				}
				//die("should return");
				return $rate;
				
			}
			
		}
		
		if(array_key_exists($weight,$rates)) {
					
			$rate=$rates[$weight];
					
		}
		
		return $rate;
		
	}
	
	/**
	 * Estimate a carts shipping price with available data
	 * Make sure the $CanteenOrder has passed thru calculate cart totals
	 * @param CanteenOrder $CanteenOrder
	 * @return decimal
	 */
	public function estimateCartShipping($CanteenOrder) { 
		
		return 0.00;
		
	}
	
	public function createShipment($canteen_order_id,$commit = false) {
		
		$order = $this->CanteenOrder->returnAdminOrder($canteen_order_id);
		
		if(strtoupper($order['CanteenOrder']['order_status']) != "APPROVED" || 
			strtoupper($order['CanteenOrder']['shipping_status']) != "PENDING"
		) return false;
		
		//get the shipping address id
		
		$address = Set::extract("/UserAddress[address_type=shipping]",$order);
		
		if(!isset($address[0]['UserAdrress']['id'])) {
			
			//fuck
			
		}
		
		//let's get the warehouses in each order
		$items = array();
		
		foreach($order['CanteenOrderItem'] as $item) {
			
			foreach($item['ChildCanteenOrderItem'] as $child) {
				
				$items[$child['CanteenInventoryRecord']['Warehouse']['id']][] = $child['id'];
				
			}
			
		}
		
		//create the shipments and then attach the shipments to the line items
		foreach($items as $key=>$val) {
			
			$this->create();
			
			$this->save(array(
				"canteen_order_id"=>$order['CanteenOrder']['id'],
				"shipping_status"=>"PENDING",
				"warehouse_id"=>$key,
				"user_address_id"=>$address[0]['UserAddress']['id']
			));
			
			$ship_id = $this->id;
			
			foreach($val as $v) {
				
				$this->CanteenOrderItem->create();
				
				$this->CanteenOrderItem->id = $v;
				
				$this->CanteenOrderItem->save(array(
					"canteen_shipping_record_id"=>$ship_id
				));
				
			}
			
		}
		
	}
	
	public function returnAdminRecord($id) {
		
		
		$record = $this->find("first",array(
				"conditions"=>array("CanteenShippingRecord.id"=>$id),
				"contain"=>array(
					"CanteenOrderItem"=>array(
						"CanteenInventoryRecord"=>array("Warehouse")
					),
					"CanteenOrder",
					"UserAddress",
					"Warehouse"
				)
			));
			
		return $record;
		
	}
	
}
