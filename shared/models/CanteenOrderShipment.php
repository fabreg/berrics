<?php
class CanteenOrderShipment extends AppModel {
	var $name = 'CanteenOrderShipment';
	var $useDbConfig = 'master';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'CanteenOrder' => array(
			'className' => 'CanteenOrder',
			'foreignKey' => 'canteen_order_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
