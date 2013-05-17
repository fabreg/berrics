<?php

class UnifiedStore extends AppModel {

	public $displayField = 'shop_name';

	public $hasMany = array(
				"UnifiedStoreHour",
				"UserUnifiedStore",
				"UnifiedStoreEmployee",
				"UnifiedStoreMediaItem",
				"UnifiedStoreEvent",
				"UnifiedStoreBrand",
				"Tag"
			);

	public $hasOne = array(
				"GeoLocation"=>array(
					"conditions"=>array("GeoLocation.model"=>"UnifiedStore"),
					"foreignKey"=>"foreign_key"
				)
			);

	public static function storeStatus() {

		return array(
			"approved"=>"Approved",
			"pending"=>"Pending Approval",
			"suspended"=>"Suspended"
		);

	}

	public static function parkingSituation() {

		return array(
			"private"=>"Private Lot",
			"street-parking"=>"Street Parking"
		);

	}

	public function returnStore($store_id = false,$isAdmin = false,$cache = true) {

		if(!$store_id) throw new BadRequestException();

		//are we caching?

		$token = "return-un-store-{$isAdmin}-{$store_id}";

		$cond = array(
				"UnifiedStore.id"=>$store_id
		);


		//check if store_id = a url frag
		if(preg_match('/(\.html)/',$store_id)) {

			$cond = array(
				"UnifiedStore.uri"=>$store_id
			);

		}


		if(($data = Cache::read($token,"1min")) === false || !$cache) {

			if(!$isAdmin) {

				$cond['UnifiedStore.store_status'] = "approved";

			}

			$data = $this->find("first",array(
						"conditions"=>$cond,
						"contain"=>array(
							"UnifiedStoreEmployee"=>array(
								"order"=>array("UnifiedStoreEmployee.display_weight"=>"ASC")
							),
							"UnifiedStoreMediaItem"=>array(
								"MediaFile",
								"Dailyop"=>array(
									"DailyopMediaItem"=>array(
										"MediaFile",
										"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
										"limit"=>1
									),
									"Tag",
									"DailyopSection"
								)
							),
							"UnifiedStoreHour",
							"UnifiedStoreEvent",
							"UnifiedStoreBrand"=>array(
								"Brand"
							),
							"GeoLocation"
						)
					));


			//write to cache
			//Cache::write($token,$data,"1min");

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
						"UnifiedStoreMediaItem"=>array(
								"MediaFile",
								"Dailyop"=>array(
									"DailyopMediaItem"=>array(
										"MediaFile",
										"order"=>array("DailyopMediaItem.display_weight"=>"ASC"),
										"limit"=>1
									),
									"Tag",
									"DailyopSection"
								)
							),
						"UnifiedStoreHour",
						"UnifiedStoreEvent",
						"UnifiedStoreBrand"=>array(
							"Brand"
						),
						"GeoLocation",
						"Tag"
					)
				));

		return $store;

	}

	public function storeHoursTable($Hours) {
		
		

		$html = "<table cellspacing='0'>";

		$html .= "</table>";

	}

	public function formatStoreHrs($UnifiedStore) {
		
		$hrs = array();

		foreach($UnifiedStore['UnifiedStoreHour'] as $k=>$v) {

			if(empty($v['custom_label'])) $hrs[] = $v;

		}

		$f = array(); //formatted hours

		foreach($hrs as $v) {

			

		}

		die(pr($hrs));
		
	}

	public function addTags($store_id = false,$str = '') {
		
		if(!$store_id) throw new BadRequestException("UnifiedStore::addTags - invalid store_id argument");

		if(empty($str)) return;

		$tags = $this->Tag->parseTags($str);

		foreach($tags['Tag'] as $k=>$v) {

			$this->Tag->create();
			$this->Tag->id = $v;
			$this->Tag->save(array(
				"unified_store_id"=>$store_id
			));

		}


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