<?php
class MediahuntEvent extends AppModel {
	var $name = 'MediahuntEvent';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'MediahuntTask' => array(
			'className' => 'MediahuntTask',
			'foreignKey' => 'mediahunt_event_id',
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

}
