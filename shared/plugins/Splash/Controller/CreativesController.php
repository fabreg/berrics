<?php

class CreativesController extends SplashAppController {
	
	
	public $uses = array("SplashCreative");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function search() {
	
		if(count($this->request->data)>0) {
				
			$url = array(
	
					"action"=>"index",
					"search"=>true
			);
	
	
			foreach($this->request->data as $k=>$v) {
					
				foreach($v as $kk=>$vv) {
	
					$url[$k.".".$kk]=urlencode($vv);
	
				}
					
			}
	
			return $this->redirect($url);
	
		}
	
	}
	
	public function index() {
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['SplashCreative'] = array(
				
					"limit"=>50
				
				);
		
		if(isset($this->request->params['named']['search'])) {
			
			if(isset($this->request->params['named']['SplashCreative.page_title'])) {
				
				$this->Paginator->settings['SplashCreative']['conditions']['SplashCreative.page_title LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['SplashCreative.page_title'])."%";
				
				$this->request->data['SplashCreative']['page_title'] = $this->request->params['named']['SplashCreative.page_title'];
				
			}
			
		}
		
		$pages = $this->paginate("SplashCreative");
		
		$this->set(compact("pages"));
		
	}
	
	public function add() {
		
		if($this->request->is("post")) {
			
			$this->SplashCreative->create();
			
			$this->request->data['SplashCreative']['hash_key'] = md5(time().mt_rand(999,9999));
			
			$this->SplashCreative->save($this->request->data);
			
			$this->redirect(array("action"=>"edit",$this->SplashCreative->id));
			
		}
		
	}
	
	public function edit($id) {
		
		if($this->request->is("put")) {
			
			$this->SplashCreative->id = $this->request->data['SplashCreative']['id'];
			
			$this->SplashCreative->save($this->request->data);
			
			$this->Session->setFlash("Creative updated successfully");
			
			$this->redirect(array("action"=>"edit",$this->request->data['SplashCreative']['id']));
			
		} else {
			
			$this->request->data = $this->SplashCreative->findById($id);
			
		}
		
	}
	
	public function delete() {
		
		if($this->request->is("post")) {
			
			$this->SplashCreative->delete($this->request->data['SplashCreative']['id']);
			
			$this->Session->setFlash("Creative deleted");
			
			$this->redirect(array("action"=>"index"));
			
		}
		
		
	}


	public function copy($id) {
		


		$creative = $this->SplashCreative->find('first',array(
						"conditions"=>array('SplashCreative.id'=>$id),
						"contain"=>array()
					));

		$this->set(compact("creative"));

		if($this->request->is("post") || $this->request->is("put")) {
		
			$this->SplashCreative->create();

			unset($creative['SplashCreative']['created'],
				$creative['SplashCreative']['modified'],
				$creative['SplashCreative']['id']
				);
			$creative['SplashCreative']['page_title'] = $this->request->data['SplashCreative']['page_title'];
			$creative['SplashCreative']['hash_key'] = md5(time().mt_rand(999,99999));
			$this->SplashCreative->save($creative['SplashCreative']);

			$this->redirect(array("action"=>"edit",$this->SplashCreative->id));

		}

	}














	
}