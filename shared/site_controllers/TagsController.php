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
					"conditions"=>array("Tag.slug"=>$this->request->params['slug']),
					"contain"=>array()
				));

		$this->loadModel('DailyopsTag');
		
		$token = "tag-posts-".md5($this->request->params['slug']);
		
		if(($post_ids = Cache::read($token,"1min")) === false) {
			
			$ids = $this->DailyopsTag->find("all",array(

				"conditions"=>array(
					"DailyopsTag.tag_id"=>$tag['Tag']['id']
				)

			));

			$ids = Set::extract("/DailyopsTag/dailyop_id",$ids);

			$post_ids = $this->Dailyop->find("all",array(
							"fields"=>array(
								"Dailyop.id"
							),
							"conditions"=>array(
								"Dailyop.active"=>1,
								"Dailyop.publish_date < NOW()",
								//"Dailyop.dailyop_section_id !="=>65,
								"Dailyop.id"=>$ids
							),
							"contain"=>array(),
						));
			
			$post_ids = Set::extract("/Dailyop/id",$post_ids);
			
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
						"DailyopTextItem"=>array(
							"MediaFile",
							"limit"=>1,
							"order"=>array(
								"DailyopTextItem.display_weight"=>"ASC"
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