<?php

App::import("Controller","BerricsApp");

class SearchController extends BerricsAppController {
	
	public $uses = array("Tag");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		
	}
	
	
	public function index() {
		

		$token = base64_encode($this->data['Search']['Tag']);
		
	//	$this->redirect(array("action"=>"results",$token));
				
		$this->set(compact("token"));
	}
	
	public function results($token) {
		
		$this->loadModel("Tag");
		$this->loadModel("Dailyop");
		
		$page = 1;
		
		if(isset($this->params['paging']['Dailyop']['page'])) $page = $this->params['paging']['Dailyop']['page'];
		
			
		$slug = "search_".$token."_page-".$page;
		
	
		

		$tags = $this->Tag->find("all",array(
		
			"conditions"=>array(
				"Tag.name LIKE "=>"%".str_replace(" ","%",base64_decode($token))."%"
			),
			"contain"=>array()
		
		));
		
		//extract the tags
		
		$tag_data = Set::extract("/Tag/id",$tags);

		$this->paginate['Dailyop'] = array(
			"fields"=>array(
				"DISTINCT(Dailyop.id)",
				"Dailyop.*",
				"DailyopSection.*",
			),
			"conditions"=>array(
				"Dailyop.publish_date < NOW()",
				"Dailyop.active"=>1,
				"DailyopsTag.tag_id"=>$tag_data
			),
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					),
					"limit"=>1
				),
				"DailyopSection"
			),
			"joins"=>array(
				"INNER JOIN dailyops_tags as `DailyopsTag` ON (DailyopsTag.dailyop_id = Dailyop.id)"
			),
			"limit"=>24,
			"order"=>array('Dailyop.publish_date'=>'DESC')
		
		);
			
		$this->Dailyop->recursive = 2;
		
		$posts_data = $this->paginate("Dailyop");
		
		$posts_data_total = $this->params['paging']['Dailyop']['count'];
		
		$this->set(compact("posts_data","posts_data_total"));
		
	}
	
	
	public function paginate_posts($tag_id) {
		
		$this->loadModel("Dailyop");
		
		$this->paginate['Dailyop'] = array(
			"fields"=>array(
				"DISTINCT(Dailyop.id)",
				"Dailyop.*",
				"DailyopSection.*",
			),
			"conditions"=>array(
				"Dailyop.publish_date < NOW()",
				"Dailyop.active"=>1,
				"DailyopsTag.tag_id"=>$tag_data
			),
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					),
					"limit"=>1
				),
				"DailyopSection"
			),
			"joins"=>array(
				"INNER JOIN dailyops_tags as `DailyopsTag` ON (DailyopsTag.dailyop_id = Dailyop.id)"
			),
			"limit"=>24,
			"order"=>array('Dailyop.publish_date'=>'DESC')
		
		);
		$posts_data = $this->paginate("Dailyop");
		
		$posts_data_total = $this->params['paging']['Dailyop']['count'];
		
		$this->set(compact("posts_data","posts_data_total","tag_id"));
		
		//die(print_r($this->params));
		
		if($this->params['isAjax']) {
			
			$this->autoRender = false;
			return $this->render("/elements/results/posts-div");
			
		}
		
	}
	
	private function findTags() {
		
		die(print_r($posts));
		
	}
	
	public function ajax_auto_tag() {
		
		$key = $_GET['term'];
		
		$keys = $this->Tag->find("all",array(
			"fields"=>array("Distinct(Tag.name) AS `Tag.name`"),
			"conditions"=>array(
				"Tag.name LIKE"=>$key."%"
			),
			"contain"=>array()
		
		));
		//die(pr($keys));
		$labels = Set::extract('/Tag/Tag.name',$keys);
		
		die(json_encode($labels));
		
		
		
	}
	
	
	
}


?>