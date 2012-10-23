<?php

App::uses("LocalAppController","Controller");

class TagsController extends LocalAppController {
	
	public $uses = array("Tag","Dailyop");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->Auth->allow();
		
		$this->initPermissions();
		
	}
	
	public function index($seed = false) {
		
		
		
	}


	
	
	public function view() {
		
		if(empty($this->request->params['slug'])) throw new NotFoundException("Invalid link!");
		
		
		$tag = $this->Tag->find("first",array(
					"conditions"=>array("Tag.slug"=>$this->request->params['slug'])
				));
		
		$token = "tag-posts-".md5($this->request->params['slug']);
		
		if(($post_ids = Cache::read($token,"1min")) === false) {
			
			$posts = $this->Tag->find("first",array(
					"fields"=>array(
							"Tag.id"
					),
					"conditions"=>array(
							"Tag.slug"=>$this->request->params['slug']
					),
					"contain"=>array(
							"Dailyop"=>array(
									"fields"=>array(
											"Dailyop.id"
									),
									"conditions"=>array(
											"Dailyop.active"=>1,
											"Dailyop.publish_date < NOW()"
									)
							)
					)
			));
			
			$post_ids = Set::extract("/Dailyop/id",$posts);
			
			Cache::write($token,$post_ids,"1min");
			
		}
		
		$this->Paginator->settings = array();
		
		$this->Paginator->settings['Dailyop'] = array(
					"conditions"=>array(

						"Dailyop.id"=>$post_ids
							
					),
					"contain"=>array(
						"DailyopMediaItem"=>array(
								"MediaFile",
								"limit"=>1,
								"order"=>array(
										"DailyopMediaItem.display_weight"=>"ASC"
								)
						),
						"DailyopSection"
					),
					"limit"=>16,
					"order"=>array(
						"Dailyop.publish_date"=>"DESC"		
					)
				);
		
		$posts = $this->paginate("Dailyop");
		
		$this->set(compact("posts","tag"));
		
	}
	
	
	public function cloud() {
		
		$letter = $this->params['letter'];
		
		$tags = $this->Tag->tagIndexList($letter);
		
		$this->set(compact("tags"));
		
	}
	
	public function cloud_index() {
		
		
		
	}
	
	
	
}