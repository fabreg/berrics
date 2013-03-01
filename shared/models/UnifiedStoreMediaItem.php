<?php
App::uses('AppModel', 'Model');
/**
 * UnifiedStoreMediaItem Model
 *
 * @property MediaFile $MediaFile
 * @property UnifiedStore $UnifiedStore
 */
class UnifiedStoreMediaItem extends AppModel {

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'master';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'MediaFile' => array(
			'className' => 'MediaFile',
			'foreignKey' => 'media_file_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'UnifiedStore' => array(
			'className' => 'UnifiedStore',
			'foreignKey' => 'unified_store_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public static function categories() {
		
		$a = array(
			"main"=>"Main (Will be uses as your main display media)",
			"store"=>"Store (Picutres and video depicting your store)",
			"team"=>"Team Media",
			"events"=>"Events"
		);

		return $a;

	}

	public function uploadImageFile() {



	}
}
