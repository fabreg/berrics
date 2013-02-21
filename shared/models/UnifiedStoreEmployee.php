<?php
App::uses('AppModel', 'Model');
/**
 * UnifiedStoreEmployee Model
 *
 * @property UnifiedStore $UnifiedStore
 */
class UnifiedStoreEmployee extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'UnifiedStore' => array(
			'className' => 'UnifiedStore',
			'foreignKey' => 'unified_store_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);


	public function addNew($data = array()) {
		


	}

	public function setNewValidation($data) {

		$this->set($data);

		$this->validate = array(
			"name"=>array(
				"rule"=>"notEmpty",
				"message"=>"Name cannot be empty",
				"required"=>true
			),
			"title"=>array(
				"rule"=>"notEmpty",
				"message"=>"Title cannot be empty"
			),
			"image_file"=>array(
				"rule"=>"validateImage",
				"message"=>"Invalid Image"
			)
		);

	}

	public function validateImage() {
		
		if(!empty($this->data['UnifiedStoreEmployee']['image_file'])) {

			switch($this->data['UnifiedStoreEmployee']['image_file']['type']) {

				case "image/jpg":
				case "image/jpeg":
				case "image/png":
				case "image/gif":
					return true;
				break;

				default:
					return false;
				break;


			}

		}

		return true;

	}
}
