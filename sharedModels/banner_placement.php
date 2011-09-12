<?php
class BannerPlacement extends AppModel {
	var $name = 'BannerPlacement';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'BannerType' => array(
			'className' => 'BannerType',
			'foreignKey' => 'banner_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'BannerImpression' => array(
			'className' => 'BannerImpression',
			'foreignKey' => 'banner_placement_id',
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
?>