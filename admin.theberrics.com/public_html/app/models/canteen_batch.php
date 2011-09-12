<?php
class CanteenBatch extends AppModel {
	var $name = 'CanteenBatch';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'CanteenOrder' => array(
			'className' => 'CanteenOrder',
			'joinTable' => 'canteen_batches_canteen_orders',
			'foreignKey' => 'canteen_batch_id',
			'associationForeignKey' => 'canteen_order_id',
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

	public function getList($limit = false) {
		
		$list = $this->find('all',array(
			
			"contain"=>array("User"),
			"order"=>array("CanteenBatch.id"=>"DESC"),
			"limit"=>50
		
		));
		
		$a = array();
		
		foreach($list as $l) {
			
			$a[$l['CanteenBatch']['id']] = $l['User']['first_name']." ".$l['User']['last_name'].": ".$l['CanteenBatch']['name'];
			
		}
		
		return $a;
		
	}
	
	
}
?>