<?php
class DailyopsTag extends AppModel {
	var $name = 'DailyopsTag';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Dailyop' => array(
			'className' => 'Dailyop',
			'foreignKey' => 'dailyop_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}