<?php
class BannerImpression extends AppModel {
	var $name = 'BannerImpression';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Banner' => array(
			'className' => 'Banner',
			'foreignKey' => 'banner_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BannerType' => array(
			'className' => 'BannerType',
			'foreignKey' => 'banner_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'BannerPlacement' => array(
			'className' => 'BannerPlacement',
			'foreignKey' => 'banner_placement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>