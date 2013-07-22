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

		//check if opened or closed

		if(empty($data['UnifiedStore']['timezibe'])) $data['UnifiedStore']['timezone'] = "America/Los_Angeles";

		$localTime = new DateTime();
		$localTime->setTimezone(new DateTimeZone($data['UnifiedStore']['timezone']));
		$dow = $localTime->format("D");

		$storeHoursToday = Set::extract("/UnifiedStoreHour[day_of_week=/{$dow}/i]", $data);

		$data['StoreHoursToday'] = $storeHoursToday;

		if(count($storeHoursToday)<=0 || $storeHoursToday[0]['UnifiedStoreHour']['open'] != 1) {

			 $data['StoreOpen'] = false;

		} else {

			$data['StoreOpen'] = $this->isStoreOpen($data['UnifiedStore']['timezone'], $storeHoursToday[0]['UnifiedStoreHour']['hours_open'], $storeHoursToday[0]['UnifiedStoreHour']['hours_close']);

		}

		return $data;

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

		if($currentTimestamp > $openTimestamp && $currentTimestamp < $closeTimestamp) return true;

		return false;

	}	

	public function isStoreOpen__($store_id = false) {

		$dow = date("D");

		$store = $this->find("first",array(
					"contain"=>array(
						"UnifiedStoreHour"=>array(
							"conditions"=>array(
								"UnifiedStoreHour.unified_store_id"=>$store_id,
								"UnifiedStoreHour.day_of_week"=>$dow
							)
						)
					),
					"conditions"=>array("UnifiedStore.id"=>$store_id)
					
				));
		
		$hours = $store['UnifiedStoreHour'][0];

		if(!isset($hours['id'])) return false;


		$storeTime = new DateTime();
		$storeTime->setTimezone(new DateTimeZone($store['UnifiedStore']['timezone']));
			

		$currentTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));

		//get the opening timestamp
		$openTime = explode(":", $hours['hours_open']);
		$storeTime->setTime($openTime[0],$openTime[1]);
		$openTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));

		//get the closing timestamp
		$closeTime = explode(":", $hours['hours_close']);
		$storeTime->setTime($closeTime[0],$closeTime[1]);
		$closeTimestamp = strtotime($storeTime->format("Y-m-d H:i:s"));
		
		/* DEBUG
		echo "Now Time:".$currentTimestamp;
		echo "<br />";
		echo "Open Time:".$openTimestamp;
		echo "<br />";
		echo "Close Time:".$closeTimestamp;


		die();
		*/

		if($currentTimestamp > $openTimestamp && $currentTimestamp < $closeTimestamp) return true;

		return false;


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