<?php

$_SERVER['DEVSERVER']=1;

class MediaEtlShell extends Shell {
	
	
	public $uses = array("MediaFileView","DimLocation","DimRequest","DimDmaCode","DimDate","DimDomain","FactMediaView");
	
	
	public function main() {
		
		$this->out("=-=-=-=-=-=-=-=- TESTING =-=-=-=-=-=-=-=-=");
		
	}
	
	
	public function build_facts($date = false, $hour = false) {
		
		ini_set('memory_limit', '512M');
		
		set_time_limit(0);
		
		if(isset($this->params['date'])) {
			
			$date = $this->params['date'];
			
		} else {
			
			$date = date("Y-m-d");
			
		}
		
		if(isset($this->params['hour'])) {
			
			$hour = $this->params['hour'];
			
		} else {
			
			$hour = date('H',time());
			
		}
		
		$hour = $hour.":00:00";
		
		$this->out("Media View ETL: ".$date." ".$hour);
		
		//die("-stopped");
		
		$this->populateDimDates($date);
		$this->populateDimLocations($date,$hour);
		
		$loop = true;
		
		while($loop) {
			
			$views = $this->MediaFileView->find('all',array(
			
				"conditions"=>array(
					"MediaFileView.created < '{$date} {$hour}'"
				),
				"limit"=>5000,
				"order"=>array("MediaFileView.created"=>"DESC")
			
			));
			
			if(count($views)>0) {
				
				foreach($views as $v) {
				
					$row = array();
					
					$row['dim_location_id'] = $this->DimLocation->returnLocationId($v['MediaFileView']['geo_country'],$v['MediaFileView']['geo_region']);
					
					$row['dim_date_id'] = $this->DimDate->returnDateId($v['MediaFileView']['created']);
					
					
					
					$row['mobile'] = $v['MediaFileView']['mobile'];
					
					$row['media_file_id'] = $v['MediaFileView']['media_file_id'];
					
					$this->FactMediaView->create();
					
					$this->FactMediaView->save($row);
					
					$this->out(print_r($row));
					
					
				}
				
				$this->MediaFileView->query(
						"DELETE FROM media_file_views WHERE created < '{$date} {$hour}' ORDER BY created DESC LIMIT 5000"
				);
				unset($pageViews);
				
			} else {
				
				$loop = false;
				
				continue;
			}
			
			
			
		}
		
		
		
	}
	
	
	
	private function populateDimLocations($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		

		
		$locs = $this->MediaFileView->query(
		
			"SELECT DISTINCT(geo_region),geo_country,geo_region_name FROM media_file_views WHERE created < '{$date} {$hour}'"
		
		);
		
		foreach($locs as $loc) {
			
			$check = $this->DimLocation->find("first",array(
			
				"conditions"=>array(
					"DimLocation.country_code"=>$loc['media_file_views']['geo_country'],
					"DimLocation.region_name"=>$loc['media_file_views']['geo_region_name'],
					"DimLocation.region_code"=>$loc['media_file_views']['geo_region']
				)
			
			));
			
			if(empty($check['DimLocation']['id'])) {
				$this->DimLocation->create();
			
				$this->DimLocation->save(array(
			
					"country_code"=>$loc['page_views']['geo_country'],
					"region_name"=>$loc['page_views']['geo_region_name'],
					"region_code"=>$loc['page_views']['geo_region']
				
				));
					
			}
			
			unset($check);
			
		}
		$this->mem();
		unset($locs);
		$this->mem();	
	}
	private function populateDimDates($date = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		

		
		$hour = 0;
		
		for($hour = 0;$hour <= 23; $hour++) {
			
			
			$hrf = str_pad($hour, 2, 0, STR_PAD_LEFT);
			
			$day = date("d",strtotime($date));
			
			$month = date("m",strtotime($date));
			
			$year = date("Y",strtotime($date));
			
			$check = $this->DimDate->find('first',array(
				
				"conditions"=>array(
			
					"DimDate.report_hour"=>$hrf,
					"DimDate.report_month"=>$month,
					"DimDate.report_year"=>$year,
					"DimDate.report_day"=>$day		
			
				)
			
			));
			
			
			if(empty($check['DimDate']['id'])) {
				
				
				$this->DimDate->create();
				
				$this->DimDate->save(array(
				
					"report_date"=>$date,
					"report_hour"=>$hrf,
					"report_month"=>$month,
					"report_day"=>$day,
					"report_year"=>$year
				
				));
				
			}
			
			
			
		}
		
		
		
	}
	private function mem() {
		
			$this->out(memory_get_usage());
			$this->hr();
		
	}
	
}