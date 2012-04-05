<?php
class CanteenOrder extends AppModel {
	var $name = 'CanteenOrder';
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Currency' => array(
			'className' => 'Currency',
			'foreignKey' => 'currency_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'CanteenOrderItem' => array(
			'className' => 'CanteenOrderItem',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CanteenOrderNote' => array(
			'className' => 'CanteenOrderNote',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'CanteenShippingRecord' => array(
			'className' => 'CanteenShippingRecord',
			'foreignKey' => 'canteen_order_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'EmailMessage' => array(
			'className' => 'EmailMessage',
			'foreignKey' => 'canteen_order_id',
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


	var $hasAndBelongsToMany = array(
		'CanteenBatch' => array(
			'className' => 'CanteenBatch',
			'joinTable' => 'canteen_batches_canteen_orders',
			'foreignKey' => 'canteen_order_id',
			'associationForeignKey' => 'canteen_batch_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	/*
	 * 
	 * OVERLOAD
	 * 
	 */
	public function save($data = array()) {
		
		if(empty($this->id)) {
			
			$data['id'] = $this->genId();
			
		}
		
		return parent::save($data);
		
	}
	
	private function genId() {
		
		$id = mt_rand(111111,99999999);
		
		$chk = $this->find("count",array("conditions"=>array("CanteenOrder.id"=>$id)));
		
		if($chk>0) {
			
			return $this->genId();
			
		}
		
		return $id;
		
	}
}
