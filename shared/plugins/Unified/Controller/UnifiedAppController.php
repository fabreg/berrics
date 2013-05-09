<?php

App::uses("LocalAppController","Controller");

class UnifiedAppController extends LocalAppController {


	public $featured_news_tag_id = 4574; //featured unified news
	public $shop_news_tag_id = 4575; //unified shop news
	public $featured_post_tag_id = 4607; //featured unified

	public function beforeFilter() {

		parent::beforeFilter();

		$this->helpers[] = "Unified.Unified";

	}

	private function ensureStoreOwnership($unified_store_id = false) {

		if(!$unified_store_id) throw new BadRequestException("UnifiedAppController::ensureStoreOwnership - No store ID specified as argument");

		//if you're an admin, it's alllllll gooooooooood
		if($this->isAdmin()) return true;

		$stores = $this->getUserUnifiedStores();

		$store_ids = Set::extract("/UserUnifiedStore/id",$stores);

		return in_array($store_ids,$unified_store_id);

	}

	private function getUserUnifiedStores() {

		$token = "user-unified-stores-".$this->Auth->user('id');

		$this->loadModel('UserUnifiedStore');

		$stores = $this->UserUnifiedStore->find('all',array(
			"fields"=>array(
				'UserUnifiedStore.unified_store_id'
			),
			'conditions'=>array(
				'UserUnifiedStore.user_id'=>$this->Auth->user('id')
			),
			'contain'=>array()

		));
		
		return $stores;

	}

}