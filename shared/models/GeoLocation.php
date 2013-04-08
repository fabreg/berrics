<?php
App::uses('AppModel', 'Model');
/**
 * GeoLocation Model
 *
 */
class GeoLocation extends AppModel {

	


	public function lat_long_search($lat = false, $lng = false, $distance = 10) {


		$sql = "SELECT *, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM geo_locations HAVING distance < $distance ORDER BY distance LIMIT 0 , 20";
		
		$res = $this->query($sql);

		if(count($res)) {

			$UnifiedStore = ClassRegistry::init("UnifiedStore");

			foreach($res as $k=>$v) {

				if($v['geo_locations']['model'] != 'UnifiedStore') {

					unset($res[$k]);

					continue;

				}

				$shop = $UnifiedStore->returnStore($v['geo_locations']['foreign_key'],1);
				
				$res[$k]['Store'] = $shop;

			}

		}

		return $res;

	}


}