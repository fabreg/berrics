<?php
class BannerType extends AppModel {
	var $name = 'BannerType';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'BannerImpression' => array(
			'className' => 'BannerImpression',
			'foreignKey' => 'banner_type_id',
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
		'BannerPlacement' => array(
			'className' => 'BannerPlacement',
			'foreignKey' => 'banner_type_id',
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
		'Banner' => array(
			'className' => 'Banner',
			'foreignKey' => 'banner_type_id',
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