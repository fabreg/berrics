<?php

App::import("Controller","LocalApp");

class SplashPagesController extends LocalAppController {
	
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	function index() {
		$this->SplashPage->recursive = 0;
		$this->set('splashPages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid splash page'));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('splashPage', $this->SplashPage->read(null, $id));
	}

	function add() {
		
		$date = date("Y-m-d",strtotime("+ 30 Days"));
		
		$this->SplashPage->save(array(
		
			"publish_date"=>$date,
			"page_title"=>"New Splash Page",
			"preview_hash"=>sha1(time())
		
		));
		
		return $this->flash("Splash Page Created","/splash_pages/edit/".$this->SplashPage->id);
		
	}

	function edit($id = null) {
		if (!$id && empty($this->request->data)) {
			$this->Session->setFlash(__('Invalid splash page'));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->request->data)) {
			
			
			//format the date
			
			$this->request->data['SplashPage']['publish_date'] = $this->request->data['SplashPage']['pub_date']." ".$this->request->data['SplashPage']['pub_time'].":00";
			
			if ($this->SplashPage->save($this->request->data)) {
				$this->Session->setFlash(__('The splash page has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The splash page could not be saved. Please, try again.'));
			}
		}
		if (empty($this->request->data)) {
			$this->request->data = $this->SplashPage->read(null, $id);
			
			$this->request->data['SplashPage']['pub_date'] = date("Y-m-d",strtotime($this->request->data['SplashPage']['publish_date']));
			
			$this->request->data['SplashPage']['pub_time'] = date("H:i",strtotime($this->request->data['SplashPage']['publish_date']));
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for splash page'));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SplashPage->delete($id)) {
			$this->Session->setFlash(__('Splash page deleted'));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Splash page was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	
public function splash_filter() {
//die(pr($this->request->data));
		$url = array(
		
			"action"=>"index",
		
		);
		
		foreach($this->request->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
				
		if($this->request->data['Search']['promo']==0) {
			
              $this->redirect(array('action' => 'index'));
				
			} else { 
					
				
			 $this->request->data['Search']['promo'] = $this->request->params['named']['splash_pages.promo'];
			  //$promofilter['splash_page.promo LIKE'] = "%".str_replace(" ","%",$this->request->params['named']['splash_page.promo'])."%";
			  $promofilter = $this->SplashPage->find("all",array("LIKE"=>array("splash_pages.promo"=>1)));
			  	$this->set($promofilter);
			  	$this->set($this->paginate());
			  		//	$this->paginate = array(
						
					//		"conditions"=>$promofilter,
					//		"limit"=>50
						
					//	);
			  
		
			}
		
    }
	
}


?>