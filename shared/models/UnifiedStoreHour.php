<?php


class UnifiedStoreHour extends AppModel {


	public static function daysOfWeek() {
		
		return array(
			"MON"=>"Monday",
			"TUE"=>"Tuesday",
			"WED"=>"Wednesday",
			"THU"=>"Thursday",
			"FRI"=>"Friday",
			"SAT"=>"Saturday",
			"SUN"=>"Sunday"
		);

	}

	public function setCustomLabelValidation($data = array()) {
		
		$this->set($data);

		$this->validate = array(
			"custom_label"=>array(
				"rule"=>"notEmpty",
				"message"=>"Custom label cannot be empty"
			)
		);

	}


}