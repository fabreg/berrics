<?php


class UnifiedStoreHour extends AppModel {


	public static function daysOfWeek() {
		
		return array(
			"SUN"=>"Sunday",
			"MON"=>"Monday",
			"TUE"=>"Tuesday",
			"WED"=>"Wednesday",
			"THU"=>"Thursday",
			"FRI"=>"Friday",
			"SAT"=>"Saturday",
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


	public function storeHoursTable($Hours) {
			
		$seed = date("Y-m-d");

		$days = self::daysOfWeek();

		$html = "<table cellspaing='0'>";

		$html .= "<tr>";
		foreach($Hours as $k=>$v) {

			$html .= "<th>{$v['day_of_week']}</th>";

		}
		$html .= "</tr>";
		
		$html .= "<tr>";
		foreach($Hours as $k=>$V) {

			$open = date("ga",strtotime($seed." ".$v['hours_open']));
			$close = date("ga",strtotime($seed." ".$v['hours_close']));

			$label = $open."<br />".$close;

			$html .= "<td width='14%'>{$label}</td>";

		}
		$html .= "</tr>";


		$html .= "</table>";

		return $html;

	}


}