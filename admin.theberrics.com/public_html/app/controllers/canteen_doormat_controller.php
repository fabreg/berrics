<?php 

App::import("Controller","LocalApp");

class CanteenDoormatController extends LocalAppController {
	
	
	public $uses = array("CanteenDoormat");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$this->paginate['CanteenDoormat'] = array(
			"contain"=>array(
				"MediaFile"
			)
		);
		
		$doormats = $this->paginate("CanteenDoormat");

		$this->set(compact("doormats"));
		
	}
	
	
	public function add() {
		
		$this->CanteenDoormat->create();
		
		$this->CanteenDoormat->save(array(
			"display_weight"=>99,
			"active"=>0
		));
		
		return $this->redirect(array("action"=>"edit",$this->CanteenDoormat->id));
		
	}
	
	public function edit($id = false,$cb = false) {
		
		if(count($this->data)>0) {
			
			$this->CanteenDoormat->save($this->data);
			
			return $this->redirect(base64_decode($cb));
			
		} else {
			
			$this->data = $this->CanteenDoormat->find("first",array(
				"conditions"=>array(
					"CanteenDoormat.id"=>$id
				),
				"contain"=>array(
					"MediaFile"
				)
			));
			
		}
		
		
	}
	
	public function delete() {
		
		
		
	}
	
	public function toggle_active($id) {
		
		
		
	}
	
}