<?php
class BannerClick extends AppModel {
	var $name = 'BannerClick';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Banner' => array(
			'className' => 'Banner',
			'foreignKey' => 'banner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>