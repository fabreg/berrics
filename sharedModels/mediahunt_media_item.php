<?php
class MediahuntMediaItem extends AppModel {
	var $name = 'MediahuntMediaItem';
	var $displayField = 'title';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'MediahuntTask' => array(
			'className' => 'MediahuntTask',
			'foreignKey' => 'mediahunt_task_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
