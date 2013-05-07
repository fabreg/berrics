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
		$featured_news = $this->Dailyop->returnUnifiedTaggedPosts($this->featured_news_tag_id);

		$this->set(compact("stores","featured_news"));

	}


	public function signup() {



	}

	


}
