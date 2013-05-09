<?php

App::uses("UnifiedAppController","Unified.Controller");

class SiteController extends UnifiedAppController {

	public $uses = array("UnifiedStore","Dailyop");

	public function beforeFilter() {
		
		//enforce ssl for some shit

		if(in_array($this->request->params['action'],array("signup"))) {

			$this->enforceSSL();

		}

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {

		$this->set("body_element","layout/unified-body-element");

		//get all the stores

		$s = $this->UnifiedStore->find("all",array(
						"contains"=>array(
							"GeoLocation"
						),
						"order"=>array(
							"UnifiedStore.shop_name"=>"ASC"
						)
				));

		$stores = array();

		foreach($s as $v) $stores[$v['UnifiedStore']['id']] = $v;

		//get the posts
		$featured_news = $this->Dailyop->returnUnifiedTaggedPosts(array($this->featured_news_tag_id,$this->shop_news_tag_id),array("limit"=>10));

		//get all the field ops posts
		$featured_posts = $this->Dailyop->returnUnifiedTaggedPosts(array($this->featured_post_tag_id));

		$this->set(compact("stores","featured_news","featured_posts"));

	}


	public function signup() {



	}

	


}
