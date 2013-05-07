<?php


class MapController extends UnifiedAppController {


	public $uses = array("GeoLocation","UnifiedStore");

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}

	public function index() {

		$this->set("body_element","layout/v3/one-column");


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

		$this->set(compact("stores"));


	}

	public function search_shops_geo() {
		

		if($this->request->is("post") || $this->request->is("put")) {
		
			$res = $this->GeoLocation->lat_long_search($this->request->data['GeoLocation']['lat'],$this->request->data['GeoLocation']['lng'],$this->request->data['GeoLocation']['distance']);
			
			

			$this->set(compact("res"));

		}

		
	}

	public function pins_json() {
		
		$token = "unified-pins-json";


		if(($pins = Cache::read($token,"1min")) === false) {

			$pins = $this->UnifiedStore->find('all',array(
						"contain"=>array("GeoLocation")
					));
			//die(print_r($pins));

			$p = array();

			foreach($pins as $v) $p[$v['UnifiedStore']['id']] = $v;

			$pins = json_encode($p);

			Cache::write($token,$pins,"1min");

		}

		die($pins);


	}



}