<?php

//$_SERVER['DEVSERVER']=1;

class TrafficEtlShell extends Shell {
	
	public $uses = array("PageView","DimLocation","DimRequest","DimDmaCode","DimDate","DimDomain","FactPageView");
	
	public function main() {
		
		
		
	}
	
	public function build_facts($date = false,$hour = false) {
		
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
		
		$this->hr();
		
		SysMsg::add(array(
			"category"=>"TrafficReports",
			"from"=>"TrafficEtlShell",
			"title"=>"Processing ETL for: ".$date." ".$hour,
			"crontab"=>1
		));
		
		$this->out("Processing ETL for: ".$date." ".$hour);
		
		$this->hr();
		
		$this->build_dimensions($date,$hour);
		$this->out("Fact Page Views");
		$this->populateFactPageViews($date,$hour);
		$this->out("Completed ETL for: ".$date." ".$hour);
		SysMsg::add(array(
			"category"=>"TrafficReports",
			"from"=>"TrafficEtlShell",
			"title"=>"Completed ETL for: ".$date." ".$hour,
			"crontab"=>1
		));
	}
	
	private function build_dimensions($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		//populate the dimensions
		$this->out("Dim Domains");
		$this->populateDimDomains($date,$hour);
		$this->out("Dim Locations");
		$this->populateDimLocations($date,$hour);
		$this->out("Dim Dates");
		$this->populateDimDates($date);
		$this->out("Dim Requests");
		$this->populateDimRequests($date,$hour);

	}
	
	public function populateFactPageViews($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		ini_set('memory_limit', '512M');
		set_time_limit(0);
		
		//$this->run_etl();
		
		$loop = true;
		
		$_SERVER['FORCEMASTER'] = true;
		
		while($loop) {
			
			$pageViews = $this->PageView->find("all",array(
		
				"conditions"=>array(
				"PageView.created  < '{$date} {$hour}'"
				),
				"limit"=>5000,
				"order"=>array("PageView.created"=>"DESC")
			
			));
			
			if(count($pageViews)>0) {
				
				//lets process the rows
				foreach($pageViews as $p) {
					
					$row = array();
					
					//set some of the data
					$row['session'] = $p['PageView']['session'];
					
					//stuff a session id if one is not found
					if(empty($row['session'])) {
						
						$row['session'] = time();
						
					}
					
					$row['mobile'] = $p['PageView']['mobile'];
					
					$row['legacy_id'] = $p['PageView']['id'];
					
					//locate DimLocation
					$row['dim_location_id'] = $this->DimLocation->returnLocationId($p['PageView']['geo_country'],$p['PageView']['geo_region']);
					
					//locate Dim Request
					$row['dim_request_id'] 	= $this->DimRequest->returnRequestId($p['PageView']['domain_name'].$p['PageView']['script_url']);
					
					//Locate Dim Date
					$row['dim_date_id'] 	= $this->DimDate->returnDateId($p['PageView']['created']);
					
					//location domain id
					$row['dim_domain_id'] 	= $this->DimDomain->returnDomainId($p['PageView']['domain_name']);
					
					if(!empty($p['PageView']['geo_dma_code'])) {
								
						$row['dim_dma_code_id'] = $this->DimDmaCode->returnDmaCodeId($p['PageView']['geo_dma_code']);
						
					}
					
					$this->FactPageView->create();
					
					$this->FactPageView->save($row);
					
					$this->out(print_r($row));
				}
				
				$this->PageView->query(
					"DELETE FROM page_views WHERE created < '{$date} {$hour}' ORDER BY created DESC LIMIT 5000"
				);
				
				$this->mem();
				unset($pageViews);
				$this->mem();
			//	die("stop".memory_get_usage());
				
				
			} else {
				
				$loop = false;
				continue;
				
			}
			
				
		}
		
	}
	
	
	private function populateDimDomains($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		
		$this->mem();

		//get the distint domain names from the page views
		
		$domains = $this->PageView->query(
			"SELECT distinct(domain_name) FROM page_views WHERE created < '{$date} {$hour}'"
		);
		
		foreach($domains as $domain) {
			
			//check the table
			$check = $this->DimDomain->find("first",array(
				
				"conditions"=>array(
					"DimDomain.domain_name"=>$domain['page_views']['domain_name']
				)
			
			));
			
			if(empty($check['DimDomain']['id'])) {
				
				$this->DimDomain->create();
				$this->DimDomain->save(array(
				
					"domain_name"=>$domain['page_views']['domain_name']
					
				));
				
			}
			
			unset($check);
			
			
		}
		
		unset($domains);
		
	}
	
	
	private function populateDimLocations($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
		

		
		$locs = $this->PageView->query(
		
			"SELECT DISTINCT(geo_region),geo_country,geo_region_name FROM page_views WHERE created < '{$date} {$hour}'"
		
		);
		
		foreach($locs as $loc) {
			
			$check = $this->DimLocation->find("first",array(
			
				"conditions"=>array(
					"DimLocation.country_code"=>$loc['page_views']['geo_country'],
					"DimLocation.region_name"=>$loc['page_views']['geo_region_name'],
					"DimLocation.region_code"=>$loc['page_views']['geo_region']
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
	
	
	private function populateDimRequests($date = false,$hour = false) {
		
		if(!$date) {
			
			$date = date("Y-m-d");
			
		}
			$this->mem();
		

		
		$requests = $this->PageView->query(
			"select distinct(script_url),domain_name FROM page_views where created < '{$date} {$hour}'"
		);
		
		//die(pr($requests));
		
		foreach($requests as $req) {
			
			//do a row check
			
			$check = $this->DimRequest->find("first",array(
				"conditions"=>array(
					"DimRequest.request_uri"=>$req['page_views']['domain_name'].$req['page_views']['script_url']
				)
			));
			
			if(empty($check['DimRequest']['id'])) {
				
				
				$this->DimRequest->create();
				
				$this->DimRequest->save(array(
					"request_uri"=>$req['page_views']['domain_name'].$req['page_views']['script_url']
				));
				
				
			}
			
			
		}
		$this->mem();
		
		unset($requests);
		$this->mem();
		
	}
	
	private function mem() {
		
			$this->out(memory_get_usage());
			$this->hr();
		
	}
	
}


?>