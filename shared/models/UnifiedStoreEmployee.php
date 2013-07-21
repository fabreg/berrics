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

	public function returnAdminEmployee($id = false) {
		
		$data = $this->find("first",array(
					"conditions"=>array(
						"UnifiedStoreEmployee.id"=>$id
					),
					"contain"=>array(
						"UnifiedStore"
					)
				));

		return $data;

	}


	public function setEmployeeValidation($data) {

		$this->set($data);

		$this->validate = array(
			"name"=>array(
				"rule"=>"notEmpty",
				"message"=>"Name cannot be empty",
				"required"=>true
			),
			/*"title"=>array(
				"rule"=>"notEmpty",
				"message"=>"Title cannot be empty"
			), */
			"image_file"=>array(
				"rule"=>"validateImage",
				"message"=>"Invalid Image"
			)
		);

	}

	public function validateImage() {
		
		if(!empty($this->data['UnifiedStoreEmployee']['image_file'])) {

			$ext = pathinfo($this->data['UnifiedStoreEmployee']['image_file']['name'],PATHINFO_EXTENSION);

			switch(strtoupper($ext)) {

				case "JPEG":
				case "JPG":
				case "GIF":
				case "PNG":
					return true;
				break;
				default:
					return false;
				break;


			}

		}

		return true;

	}

	public function titles() {
		
		return array(
			"owner"=>"Owner",
			"manager"=>"Store Manager",
			"assistant-manager"=>"Assistant Manager",
			"employee"=>"Employee"
		);

	}

	public function uploadImage($file) {
		
		if(!isset($file['tmp_name'])) return '';

		//save to tmp
		$ext = pathinfo($file['name'],PATHINFO_EXTENSION);

		$name = md5(time().mt_rand(999,9999)).".".$ext;

		$tmp_path = TMP.$name;

		if(move_uploaded_file($file['tmp_name'],$tmp_path)) {

			App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));

			$img = ImgServer::instance();

			$img->upload_unified_employee($name,$tmp_path);

			unlink($tmp_path);

			return $name;

		}

		return '';


	}
}
