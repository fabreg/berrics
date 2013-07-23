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
								"Brand",
								"order"=>array("UnifiedStoreBrand.display_weight"=>"ASC")
							),
							"GeoLocation"
						)
					));


			//write to cache
			//Cache::write($token,$data,"1min");

		}

		//attach store hours and isOpen
		$data = $this->attachStoreOpenValues($data);

		

		return $data;

	}

	public function returnMapPins() {
		
		$token = "unified-map-pins";

		if(($store_pins = Cache::read($token,"1min")) === false) {

			$store_pins = array();

			$stores = $this->find("all", array(

				"conditions"=>array(

				),
				"contain"=>array(

					"UnifiedStoreHour",
					"GeoLocation"

				)

			));

			foreach($stores as $k=>$store) {

				$stores[$k] = $this->attachStoreOpenValues($store);

				//unset some of the stuff that we dont need to lean it up!
				unset($stores[$k]['UnifiedStoreHour']);

				$store_pins[$stores[$k]['UnifiedStore']['id']] = $stores[$k];

			}

			Cache::write($token, $store_pins, "1min");

		}

		return $store_pins;

	}

	/**
	 * Pass in UnifiedStore array model as Argument and return it with StoreOpen & StoreHoursToday array keys
	 * !!! Must have store hours attached if not then will throw invalid arguments exception
	 * 
	 */
	public function attachStoreOpenValues($UnifiedStore = false) {
		
		//check to make sure that we have "$UnifiedStore['UnifiedStoreHours']" attached, if not then lets throw an exception

		if(!isset($UnifiedStore['UnifiedStoreHour'])) {

			throw new BadRequestException("UnifiedStore::attachStoreOpenValues - No UnifiedStoreHour attached to $UnifiedStore argument");

		}

		if(empty($UnifiedStore['UnifiedStore']['timezone']))  { //store does not have timezone set, set it as closed and hours today as false

			$UnifiedStore['StoreHoursToday'] = $UnifiedStore['StoreOpen'] = false;

			return $UnifiedStore;

		} 

		$localTime = new DateTime();
		$localTime->setTimezone(new DateTimeZone($UnifiedStore['UnifiedStore']['timezone']));
		$dow = $localTime->format("D");

		$storeHoursToday = Set::extract("/UnifiedStoreHour[day_of_week=/{$dow}/i]", $UnifiedStore);

		$UnifiedStore['StoreHoursToday'] = $storeHoursToday;

		if(count($storeHoursToday)<=0 || $storeHoursToday[0]['UnifiedStoreHour']['open'] != 1) {

			 $UnifiedStore['StoreOpen'] = false;

		} else {

			$UnifiedStore['StoreOpen'] = $this->isStoreOpen($UnifiedStore['UnifiedStore']['timezone'], $storeHoursToday[0]['UnifiedStoreHour']['hours_open'], $storeHoursToday[0]['UnifiedStoreHour']['hours_close']);

		}

		return $UnifiedStore;

	}

	public function isStoreOpen($timezone,$hours_open,$hours_closed) {
		

		$storeTime = new DateTime();
		$storeTime->setTimezone(new DateTimeZone($timezone));
			

		$currentTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));

		//get the opening timestamp
		$openTime = explode(":", $hours_open);
		$storeTime->setTime($openTime[0],$openTime[1]);
		$openTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));

		//get the closing timestamp
		$closeTime = explode(":", $hours_closed);
		$storeTime->setTime($closeTime[0],$closeTime[1]);
		$closeTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));

		if($currentTimestamp > $openTimestamp && $currentTimestamp < $closeTimestamp) {

			return array(

				"hours_open"=>date("ga",$openTimestamp),
				"hours_close"=>date("ga",$closeTimestamp)

			);

		}

		return false;

	}	

	public function getStoreTagIds($store_id = false) {
		
		$tags = $this->Tag->find("all",array(
			"conditions"=>array(
				"Tag.unified_store_id"=>$store_id

			),
			"contain"=>array()
		));
		
		$tag_ids = Set::extract("/Tag/id",$tags);

		return $tag_ids;

	}

	public function getStoreNewsItems($store_id = false) {

		//get the tags associcated with a store

		$tags = $this->getStoreTagIds($store_id);

		$tags = $this->getStoreTagIds($store_id);

		//get all the post ids

		$Dailyop = ClassRegistry::init("Dailyop");

		$post_ids = $Dailyop->DailyopsTag->find("all",array(
						"fields"=>array("DailyopsTag.dailyop_id"),
						"conditions"=>array(
							"DailyopsTag.tag_id"=>$tags
						)
					));
		
		$posts = array();
		
		foreach($post_ids as $id) {

			$tmp = $Dailyop->returnPost(array(
						"Dailyop.id"=>$id['DailyopsTag']['dailyop_id'],
						"Dailyop.dailyop_section_id"=>65
					));

			if(isset($tmp['Dailyop']['id'])) $posts[] = $tmp;

		}

		return $posts;


	}


	public function getStorePosts($store_id = false) {

		$token = "unified-store-posts-{$store_id}";

		$tags = $this->getStoreTagIds($store_id);

		//get all the post ids

		$Dailyop = ClassRegistry::init("Dailyop");

		$post_ids = $Dailyop->DailyopsTag->find("all",array(
						"fields"=>array("DailyopsTag.dailyop_id"),
						"conditions"=>array(
							"DailyopsTag.tag_id"=>$tags
						)
					));
		
		$posts = array();
		
		foreach($post_ids as $id) {

			$tmp = $Dailyop->returnPost(array(
						"Dailyop.id"=>$id['DailyopsTag']['dailyop_id']
					));

			if(isset($tmp['Dailyop']['id'])) $posts[] = $tmp;

		}

		return $posts;

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
							"Brand",
							"order"=>array("UnifiedStoreBrand.display_weight"=>"ASC")
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