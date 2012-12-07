<?php

App::import("Controller","Dailyops");


class ImageGalleryController extends DailyopsController {
	
	
	public $uses = array('Dailyop');
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
	
		
		
	}

	public function section() {
		
		parent::section();

		$this->view = "/Dailyops/section";

	}
	

	
	public function index() {
		
		
		
		
	}
	

	public function view() {
		
		//always pull up only active posts and posts which publish date has preceeded today
		/*$conditions = array(
		
			"Dailyop.active"=>1,
			"DATE(Dailyop.publish_date) < NOW()"
			
		);*/
		
		//determine the conditions we are going to use to pull up the gallery
		
		
		$this->theme = $this->request->params['section'];
		$conditions['DailyopSection.uri'] = $this->request->params['section'];
		$conditions['Dailyop.uri'] = $this->request->params['uri'];
	

		$post = $this->Dailyop->returnPost($conditions,$this->isAdmin());
		
		$title_for_layout = "The Berrics - ".$post['DailyopSection']['name'].' - '.$post['Dailyop']['sub_title'];
		

		//build rows of 4
		$items = array();
	
		$index = 0;
		
		$counter = 1;
		
		$view_row = 0;
		
		$view_id = '';
		
		$view_item = false;
		
		$view_item = '';
		
		if(isset($this->request->params['named']['view'])) {
			
			$view_id = $this->request->params['named']['view'];
			$view_item = Set::extract("/DailyopMediaItem/MediaFile[id={$view_id}]",$post);
		
		} else {
			
			$view_item = $post['DailyopMediaItem'][1];
			$view_id = $view_item['MediaFile']['id'];
			
		}
		
		$prev_item = false;
		$next_item = false;
		
		foreach($post['DailyopMediaItem'] as $key=>$item) {
			
			$items[$index][] = $item;
			
			///check for the current image being viewed
			
			if($view_id == $item['MediaFile']['id']) {
				
				$prev_key = $key - 1;
				$next_key = $key + 1;
				
				if(isset($post['DailyopMediaItem'][$prev_key])) {
					
					$prev_item = $post['DailyopMediaItem'][$prev_key];
					
				}
				
				if(isset($post['DailyopMediaItem'][$next_key])) {
					
					$next_item = $post['DailyopMediaItem'][$next_key];
					
				}
				
			}
			
			
			//is the image view want to view in this index?
			if(!empty($view_id) && $item['MediaFile']['id'] == $view_id) {
				
				$view_row = $index;
				$view_item = $item;
				
			} 
			
			$counter ++;
			
			if($counter > 4) {
				
				$counter = 1;
				$index++;
				
			}
			
		}
		
		$this->setFacebookMetaImg($post['DailyopMediaItem'][0]['MediaFile']);
		
		$this->set(compact("post","items","view_row","view_id","view_item","title_for_layout","prev_item","next_item"));
		
	}
	
	
	public function details() {
		
		
		
		
	}
	
	
	
	
}


?>