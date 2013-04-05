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


		$stores = $this->UnifiedStore->find("all",array(
						"contains"=>array(
							"GeoLocation"
						),
						"order"=>array(
							"UnifiedStore.shop_name"=>"ASC"
						)
				));

		$this->set(compact("stores"));


	}

	public function search_shops_geo() {
		

		if($this->request->is("post") || $this->request->is("put")) {
		
			$res = $this->GeoLocation->lat_long_search($this->request->data['GeoLocation']['lat'],$this->request->data['GeoLocation']['lng'],$this->request->data['GeoLocation']['distance']);
			
			die(print_r($res));

		}


	}



}