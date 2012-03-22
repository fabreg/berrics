<?php

App::import("Controller","LocalApp");

class SlsController extends LocalAppController {
	
	private $section_id = 75;
	
	public $uses = array("SlsEntry","SlsVote");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		
	}
	
	public function index() {
		
		$this->paginate['SlsEntry']['contain'][] = "Dailyop";
		
		$data = $this->paginate("SlsEntry");
		
		$this->set(compact("data"));
		
	}
	
	public function add_entry() {
		
		if(count($this->data)>0) {
			
			if($this->SlsEntry->save($this->data)) {
				
				$this->Session->setFlash("Street League Entry Added");
				
				return $this->redirect("/sls");
				
			}
			
		} 
		
	}
	
	public function edit_entry($id = false) {
		
		if(!$id) return $this->cakeError("error404");
		
		if(count($this->data)>0) {
			
			$this->SlsEntry->create();
			
			$this->SlsEntry->id = $this->data['SlsEntry']['id'];
			
			$this->SlsEntry->save($this->data);
			
			$this->Session->setFlash("Street League Entry Updated");
			
			return $this->redirect("/sls");
			
		} else {
			
			$this->data = $this->SlsEntry->find("first",array(
				"conditions"=>array(
					"SlsEntry.id"=>$id
				),
				"contain"=>array("Dailyop")
			));
			
		}
	
		$this->setSelects();
		
	}
	
	public function view_votes() {
		
		
		
	}
	
	public function setSelects() {
		
		$this->loadModel("Dailyop");
		
		$posts = $this->Dailyop->find("all",array(
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>$this->section_id
			),
			"contain"=>array()
		));
		
		$s = array();
		
		foreach($posts as $p) $s[$p['Dailyop']['id']] = $p['Dailyop']['name']." - ".$p['Dailyop']['sub_title'];
		
		$postSelect = $s;
		
		$this->set(compact("postSelect"));
		
	}
	
	
}