<?php
class DailyopSectionsTag extends AppModel {
	var $name = 'DailyopSectionsTag';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Tag' => array(
			'className' => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'DailyopSection' => array(
			'className' => 'DailyopSection',
			'foreignKey' => 'dailyop_section_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}