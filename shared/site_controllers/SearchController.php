<?php

App::import("Controller","LocalApp");

class SearchController extends LocalAppController {
	
	public $uses = array("Tag");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
		
	}
	
	
	public function index() {
		

		$token = base64_encode($this->request->data['Search']['term']);

		//$this->redirect(array("action"=>"results",$token));
				
		$this->set(compact("token"));
	}
	
	public function results($token) {
		
		$this->loadModel('SearchItem');
		
		$this->loadModel("Dailyop");

		$search_label = base64_decode($token);

		$result = $this->SearchItem->run_search($search_label);

		$post_ids = Set::extract("/SearchItem[model=Dailyop]",$result);

		$post_ids = Set::extract("/SearchItem/foreign_key",$post_ids);

		$this->Paginator->settings = array();

		$this->Paginator->settings['Dailyop'] = array(
			"contain"=>array(
				"DailyopMediaItem"=>array(
					"MediaFile",
					"order"=>array(
						"DailyopMediaItem.display_weight"=>"ASC"
					),
					"limit"=>1
				),
				"DailyopSection",
				"DailyopTextItem"=>array(
					"order"=>array("DailyopTextItem.display_weight"=>"ASC"),
					"limit"=>1,
					"MediaFile"
				)
			),
			"conditions"=>array(
				'Dailyop.id'=>$post_ids,
				//"Dailyop.dailyop_section_id !="=>65,
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()",
				"Dailyop.promo !="=>1
			),
			"order"=>array(
				"Dailyop.publish_date"=>"DESC"
			)
		);

		$this->set("posts",$this->paginate("Dailyop"));

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
		
		$posts_data_total = $this->request->params['paging']['Dailyop']['count'];
		
		$this->set(compact("posts_data","posts_data_total","tag_id"));
		
		//die(print_r($this->request->params));
		
		if($this->request->params['isAjax']) {
			
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