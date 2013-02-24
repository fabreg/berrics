<?php

class UnifiedStore extends AppModel {

	public $displayField = 'shop_name';

	public $hasMany = array(
				"UnifiedStoreHour",
				"UserUnifiedStore",
				"UnifiedStoreEmployee",
				"UnifiedStoreMediaItem",
				"UnifiedStoreEvent"
			);

	public $belongsTo = array(

			);

		

	public function returnStore($store_id = false,$isAdmin = false,$cache = true) {

		if(!$store_id) throw new BadRequestException();

		//are we caching?

		$token = "return-un-store-{$isAdmin}-{$store_id}";

		if(($data = Cache::read($token,"1min")) === false || !$cache) {

			$cond = array(
				"UnifiedStore.id"=>$store_id
			);

			if(!$isAdmin) {

				$cond['UnifiedStore.active'] = 1;

			}

			$data = $this->find("first",array(
						"conditions"=>$cond,
						"contain"=>array(

						)
					));


			//write to cache
			Cache::write($token,$data,"1min");

		}

		return $data;

	}

	public function returnAdminStore($id = false) {

		if(!$id) throw new BadRequestException("Invalid Store Request");

		$store = $this->find("first",array(
					"conditions"=>array(
						"UnifiedStore.id"=>$id
					),
					"contain"=>array(
						"UnifiedStoreEmployee"=>array(

							"order"=>array("UnifiedStoreEmployee.display_weight"=>"ASC")

						),
						"UnifiedStoreMediaItem",
						"UnifiedStoreHour",
						"UnifiedStoreEvent"
					)
				));

		return $store;

	}

	public function setValidation($data) {
		
		$this->set($data);

		$this->validate = array(
			"shop_name"=>array(
				"rule"=>array("minLength",5),
				"message"=>"Shop name must be at least xx"
			)
		);



	}


}