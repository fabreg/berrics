<?php

class DimDate extends Model {
	
	public $useDbConfig = "traffic";
	
	
	public function returnDateId($date) {
		
		$year = date("Y",strtotime($date));
		
		$month = date("m",strtotime($date));
		
		$day = date("d",strtotime($date));
		
		$hour = date("H",strtotime($date));
		
		$res = $this->find("first",array(
			
			"fields"=>array("DimDate.id"),
			"conditions"=>array(
				"DimDate.report_year"=>$year,
				"DimDate.report_month"=>$month,
				"DimDate.report_day"=>$day,
				"DimDate.report_hour"=>$hour
			)
		
		));
		
		$id = NULL;
		
		if(!empty($res['DimDate']['id'])) {
			
			$id = $res['DimDate']['id'];
			
		}
		
		unset($res);
		
		return $id;
		
	}
	
	
	public function getMonth($month = false) {
		
		
		$data = $this->find("all",array(
			"conditions"=>array(
				"DimDate.report_month"=>$month
			)
		));
		
		//extract all the id's into an array
		
		$months = Set::extract("/DimDate/id",$data);
		
		return $months;
		
		
	}
	
	public function monthSelectList() {
		
		$data = $this->find("list",array(
		
			"fields"=>array("DISTINCT(DimDate.report_month)","DimDate.id")
		
		));
		
		return $data;
		
	}
	
	public function yearSelectList() {
		
		
		
	}
	
	
}

?>