<?php


App::import("Controller","Dailyops");

class TrajectoryController extends DailyopsController {
	
	public $uses = array("Dailyop");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		if($this->request->params['action'] == "section") {
			
			$this->request->params['action'] = "view";
			
		}
		
	}
	
	
	public function view() {
		
		//section 20
		$posts = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
				"Dailyop.dailyop_section_id"=>20,
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()",
				"Dailyop.title_episode"=>1
			),
			"contain"=>array(
				"DailyopSection",
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					)
				)
			),
			"order"=>array(
				
				"Dailyop.publish_date"=>"DESC"
			
			)
		
		));		
		
		if(isset($this->request->params['uri']) && !empty($this->request->params['uri'])) {
			
			$viewing = $this->Dailyop->returnPost(array(
			
				"Dailyop.uri"=>$this->request->params['uri'],
				"Dailyop.dailyop_section_id"=>20
			
			),$this->isAdmin());
			
		} else {
			
			$v_id = $posts[0]['Dailyop']['id'];
			
			$viewing = $this->Dailyop->returnPost(array(
			
				"Dailyop.id"=>$v_id
			
			),$this->isAdmin());
			
		}
		
		$related_id = $viewing['Dailyop']['id'];
		
		if(!empty($viewing['Dailyop']['parent_dailyop_id'])) {
			
			$related_id = $viewing['Dailyop']['parent_dailyop_id'];
			
		}
		
		//get the other posts in the series
		$episodes = $this->Dailyop->find("all",array(
		
			"conditions"=>array(
				"OR"=>array(
					"Dailyop.id"=>$related_id,
					"Dailyop.parent_dailyop_id"=>$related_id
				),
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()"
			),
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					)
				),
				"DailyopSection"
			)
		
		));
		
		
		$this->setFacebookMetaImg($viewing['DailyopMediaItem'][0]['MediaFile']);
		
		$this->set(compact("posts","viewing","episodes"));
		
		
	}
	
	
	public function section() {
		
		
		
		
	}
	
	
}