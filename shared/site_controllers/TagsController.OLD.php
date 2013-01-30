<?php

App::import("Controller","LocalApp");

class TagsController extends LocalAppController {
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		$this->Auth->allow("*");
		
	}
	
	public function index($slug = false) {

	
		$slug = $this->request->params['slug'];
		
		$this->loadModel("MediaFilesTag");
		
		$this->loadModel("MediaFile");
		
		$tag = $this->Tag->find("first",array(
		
			"conditions"=>array(
				"Tag.slug"=>$slug
			),
			"contain"=>array()
		
		));

		//posts
		$this->paginate_posts($tag['Tag']['id']);	

		//images
		$this->paginate_images($tag['Tag']['id']);	
		
		$title_for_layout = "Tag: ".$tag['Tag']['name'];
		
		$this->set(compact("tag","title_for_layout"));
		
	}
	
	private function getMediaIdByTagId($id = false) {
		
		$token = "tag_ids_".$id;
		
		if(($ids=Cache::read($token,"1min")) === false) {
			
			$ids  = $this->MediaFilesTag->find("all",array(
		
				"conditions"=>Array(
					"MediaFilesTag.tag_id"=>$id
				)	
		
			));
			
			Cache::write($token,$ids,"1min");
				
		}
	
		$test = Set::extract("/MediaFilesTag/media_file_id",$ids);
		
		return $test;
		
	}
	
	//data methods
	
	public function paginate_posts($tag_id) {
		
		$this->loadModel("Dailyop");
		$this->Dailyop->recursive=2;
		$this->paginate['Dailyop'] = array(
		
			"conditions"=>array(
				"DailyopsTag.tag_id"=>$tag_id,
				"Dailyop.active"=>1,
				"Dailyop.publish_date < NOW()"
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
				"INNER JOIN dailyops_tags AS `DailyopsTag` ON (DailyopsTag.dailyop_id = Dailyop.id)"
			),
			"order"=>array("Dailyop.publish_date"=>"DESC"),
			"limit"=>16
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
	
	
	
	private function paginate_videos($tag_id) {
		

		$this->paginate['MediaFile'] = array(
		
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove",
				"MediaFilesTag.tag_id"=>$tag_id
			),
			"joins"=>array(
				"INNER JOIN media_files_tags AS `MediaFilesTag` ON (MediaFilesTag.media_file_id = MediaFile.id)"
			),
			"contain"=>array(
			),
			"order"=>array("MediaFile.created"=>"DESC"),
			"limit"=>16
		
		);
		
		$video_data = $this->paginate("MediaFile");
		
		$video_data_total = $this->request->params['paging']['MediaFile']['count'];

		$this->set(compact("video_data","video_data_total","tag_id"));
		

		
		
	}
	
	public function paginate_images($tag_id) {
		
		$this->paginate['MediaFile'] = array(
		
			"conditions"=>array(
				"MediaFile.media_type"=>array("img","pic","piclink"),
				"MediaFilesTag.tag_id"=>$tag_id
			),
			"joins"=>array(
				"INNER JOIN media_files_tags AS `MediaFilesTag` ON (MediaFilesTag.media_file_id = MediaFile.id)"
			),
			"contain"=>array(),
			"order"=>array("MediaFile.created"=>"DESC"),
			"limit"=>16
		
		);
		
		$image_data = $this->paginate("MediaFile");
		
		$image_date_total = $this->request->params['paging']['MediaFile']['count'];

		$this->set(compact("image_data","image_data_total"));
		
	}
	
	public function cloud() {
		
		$letter = $this->request->params['letter'];
		
		$tags = $this->Tag->tagIndexList($letter);
		
		$this->set(compact("tags"));
		
	}
	
	public function cloud_index() {
		
		
		
	}
	
	
	
	
}


?>