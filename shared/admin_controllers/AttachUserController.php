<?php 

App::import("LocalAppController","Controller");

class AttachUserController extends LocalAppController {



	public $uses = array("User");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();


	}

	public function index($model = false,$field = false,$foreignKey = false) {
		

		if(!$model) throw new BadRequestException("There needs to be a model specified");
		if(!$field) throw new BadRequestException("There needs to be a field specified");
		if(!$foreignKey) throw new BadRequestException("There needs to be a foreign Key Passed");

		if($this->request->is("post")) {
		
			$m = ClassRegistry::init($model);
			
			foreach($this->request->data['AttachMedia']['id'] as $v) {

				$m->create();

				switch(strtoupper($model)) {

					case "DAILYOPMEDIAITEM":
						$m->save(array(
							$field=>$foreignKey,
							"display_weight"=>99,
							"media_file_id"=>$v
						));
					break;
					case "DAILYOPTEXTITEM":
						$m->id = $foreignKey;
						$m->save(array(
							"media_file_id"=>$v
						));
					break;
					case "UNIFIEDSTOREMEDIAITEM":
						$d = array(
							$field=>$foreignKey,
							"display_weight"=>99,
							"media_file_id"=>$v
						);
						if(isset($this->request->params['named']['category']))
							$d['category'] = $this->request->params['named']['category'];
						$m->save($d);

					break;

				}

			}

			$this->Session->setFlash("Media Files attached successfully");

			$tab = "media";

			if(isset($this->request->params['named']['tab'])) $tab = $this->request->params['named']['tab'];

			$this->redirect(base64_decode($this->request->params['named']['cb'])."?tab=".$tab);

		
		}


	}

	public function filter() {
		
	}



	public function browse() {
		
		$this->Paginator->settings = array();

		$this->Paginator->settings['User'] = array(
			"limit"=>50,
			"order"=>array(
				"User.created"=>"DESC"
			),
			"contain"=>array(
				"UserGroup"
			)
		);



		$users = $this->paginate("User");

		$this->set(compact("users"));

	}




}
