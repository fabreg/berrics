<?php

App::import("Controller","AdminApp");

class SplashPagesController extends AdminAppController {
	
	
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
			$this->Session->setFlash(__('Invalid splash page', true));
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
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid splash page', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			
			//format the date
			
			$this->data['SplashPage']['publish_date'] = $this->data['SplashPage']['pub_date']." ".$this->data['SplashPage']['pub_time'].":00";
			
			if ($this->SplashPage->save($this->data)) {
				$this->Session->setFlash(__('The splash page has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The splash page could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->SplashPage->read(null, $id);
			
			$this->data['SplashPage']['pub_date'] = date("Y-m-d",strtotime($this->data['SplashPage']['publish_date']));
			
			$this->data['SplashPage']['pub_time'] = date("H:i",strtotime($this->data['SplashPage']['publish_date']));
			
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for splash page', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->SplashPage->delete($id)) {
			$this->Session->setFlash(__('Splash page deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Splash page was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	
public function splash_filter() {
//die(pr($this->data));
		$url = array(
		
			"action"=>"index",
		
		);
		
		foreach($this->data as $k=>$v) {
			
			foreach($v as $kk=>$vv) {
				
				$url[$k.".".$kk]=urlencode($vv);
				
			}
			
		}
				
		if($this->data['Search']['promo']==0) {
			
              $this->redirect(array('action' => 'index'));
				
			} else { 
					
				
			 $this->data['Search']['promo'] = $this->params['named']['splash_pages.promo'];
			  //$promofilter['splash_page.promo LIKE'] = "%".str_replace(" ","%",$this->params['named']['splash_page.promo'])."%";
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