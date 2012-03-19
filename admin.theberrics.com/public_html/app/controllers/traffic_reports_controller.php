<?php


App::import("Controller","LocalApp");

class TrafficReportsController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
		set_time_limit(0);
	}
	
	
	public function index() {
		
		
		
	}
	
	
	public function some_report() {
		
		
		
	}
	
	public function monthly() {
		
		$this->loadStuff();

		$sql_filter = '';
		$year = false;
		$month = false;
		$domain_id = false;
		$country_code = false;
		
		if(isset($this->data['Filters']['report_month']['month'])) {
			
			$month = $this->data['Filters']['report_month']['month'];
			
		}
		
		if(!$month && isset($this->params['named']['report_month'])) {
			
			$month = $this->data['Filters']['report_month']['month'] = $this->params['named']['report_month']['month'];
			
		}
		
		if(!$month) {
			
			$month = $this->data['Filters']['report_month']['month'] = date("m");
			
		}
			
		//now get the year
		
		if(Set::check($this->data,"Filters.report_year.year")) {
			
			$year = $this->data['Filters']['report_year']['year'];
			
		}
		
		if(!$year && Set::check($this->params,"named.report_year")) {
			
			
			$year = $this->data['Filters']['report_year']['year'] = $this->params['named']['report_year'];
			
		}
		
		if(!$year) {
			
			$year = $this->data['Filters']['report_year']['year'] = date("Y");
			
		}
		
		
		//get the domain id 
		
		if(Set::check($this->data,"Filters.dim_domain_id")) {
			
			$domain_id = $this->data['Filters']['dim_domain_id'];
			
		}
		
		if(!$domain_id && Set::check($this->params,"named.dim_domain_id")) {
			
			
			$domain_id = $this->data['Filters']['dim_domain_id'] = $this->params['named']['dim_domain_id'];
			
		}
		
		//get the country
		
		if(Set::check($this->data,"Filters.country_code")) {
			
			$country_code = $this->data['Filters']['country_code'];
			
		}
		
		if(!$country_code && Set::check($this->params,"named.country_code")) {
			
			$country_code = $this->params['named']['country_code'];
			
		}
		
		
		///build the SQL filters
		
		if($domain_id) {
			
			$sql_filter .= " AND FactPageView.dim_domain_id = ".$domain_id;
			
		}
		
		if($country_code) {
			
			$sql_filter .= " AND DimLocation.country_code = '{$country_code}'";
			
		}
	
		

		//get all the id's for the month
		
		$date_ids = $this->DimDate->getMonth($month);
		
		$query = "SELECT COUNT(*) AS `page_views`,DimDate.report_date
					FROM fact_page_views AS `FactPageView`
					INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
					INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
					WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}'
					{$sql_filter}
					GROUP BY DimDate.report_date
					";
		
		$report = $this->FactPageView->query($query);
		
		//calculate uniques
		$unq = $this->FactPageView->query(
			
				"select count(*) AS `total`,report_date from (
					SELECT distinct(FactPageView.session),DimDate.report_date AS `report_date` FROM fact_page_views `FactPageView`
					INNER JOIN dim_dates `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
					INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
					WHERE DimDate.report_month = '{$month}'
					AND DimDate.report_year = '{$year}' {$sql_filter}
				) AS Traffic
				GROUP BY report_date"
			
			);
			
		$unique = array();
		
		foreach($unq as $v) {
			
			$unique[date("Y-m-d",strtotime($v['Traffic']['report_date']))] = $v[0]['total'];
			
		}
		
		foreach($report as $k=>$v) {
			
			//get the date key
			
			$key = date("Y-m-d",strtotime($v['DimDate']['report_date']));
			
			$report[$k][0]['uniques'] = $unique[$key];
			
		}
		
		//get the berra uniques
		
		$berra = $this->FactPageView->query(
		
			"SELECT SUM(total_unq) AS `total`,report_date FROM (
				SELECT COUNT(*) AS `total_unq`,report_date,report_hour FROM 
					( SELECT DISTINCT(FactPageView.session),DimDate.report_date AS `report_date` , DimDate.report_hour AS `report_hour`
						FROM fact_page_views `FactPageView` 
						INNER JOIN dim_dates `DimDate` ON (DimDate.id = FactPageView.dim_date_id) 
						INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
						WHERE DimDate.report_month = '{$month}' 
						AND DimDate.report_year = '{$year}' {$sql_filter}
					) 
					AS Traffic 
				GROUP BY report_date,report_hour
			) AS Traffic
			GROUP BY report_date"
		
		);
		
		$unique = array();
		
		foreach($berra as $k=>$v) {
			
			$unique[date("Y-m-d",strtotime($v['Traffic']['report_date']))] = $v[0]['total'];
			
		}
		
		foreach($report as $k=>$v) {
			
			$key = date("Y-m-d",strtotime($v['DimDate']['report_date']));
			
			$report[$k][0]['berra_uniques'] = $unique[$key];
			
		}
		
		
		
		//build some select lists
		
		$domainList = $this->DimDomain->selectList();
		
		//$allMonths = $this->DimDate->monthSelectList();
		
		
		$allYears = array();
		
		$this->set(compact("report","unq","domainList","berra"));
	
	}
	
	
	public function day($date = false) {
		
		if(!$date) {
			
			return $this->invalidUrl("/traffic_reports/monthly");
			
		}
		
		$this->loadStuff();
		
		//we got the date
		if(!isset($this->data['Filters']['report_date'])) {
			
			$this->data['Filters']['report_date'] = $date;
			
		} else {
			
			$date = $this->data['Filters']['report_date'];
			
		}

		//check for a domain
		if(isset($this->params['named']['dim_domain_id'])) {
			
			$this->data['Filters']['dim_domain_id'] = $this->params['named']['dim_domain_id'];
			
		}
		
		
		//sql filters
		$sql_filter = '';
		
		if(isset($this->data['Filters']['dim_domain_id']) && !empty($this->data['Filters']['dim_domain_id'])) {
			
			$sql_filter = " AND FactPageView.dim_domain_id = '".$this->data['Filters']['dim_domain_id']."'";
			
		}
		
		
		
		//now let's get to the SQL fun !! :-D
		
		//get the hourly traffic stuff
		$hourly_pv = $this->FactPageView->query(
			"SELECT count(*) AS `total`,DimDate.report_hour
			FROM fact_page_views AS `FactPageView`
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
			WHERE DimDate.report_date = '{$date}' {$sql_filter}
			GROUP BY DimDate.report_hour
			ORDER BY report_hour ASC"
		);
		
		$hourly_uniques = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,report_hour FROM (
				SELECT distinct FactPageView.session,DimDate.report_hour AS `report_hour`
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_date = '{$date}' {$sql_filter}
			) AS Traffic
			GROUP BY report_hour
			ORDER BY report_hour ASC"
		);
		
		
		$unq = array();
		
		foreach($hourly_uniques as $v) {
			
			$unq[$v['Traffic']['report_hour']] = $v[0]['total'];
			
		}
		
		//format uniques
		
		foreach($hourly_pv as $k=>$v) {
			
			$hourly_pv[$k][0]['uniques'] = $unq[$v['DimDate']['report_hour']];
			
		}
		
		unset($hourly_unqiues);
		
		//get the country reports
		$country_pv = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,DimLocation.country_code
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_date = '{$date}' {$sql_filter} 
				GROUP BY DimLocation.country_code
			ORDER BY total DESC"
		);
		
		$country_unq = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,country_code FROM (
				SELECT DISTINCT FactPageView.session,DimLocation.country_code AS `country_code`
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_date = '{$date}' {$sql_filter}
			) AS Traffic
			GROUP BY country_code"
		);

		$country_berra = $this->FactPageView->query(	
			"SELECT SUM(total) AS `uniques`,country_code FROM (
				SELECT COUNT(*) AS `total`,report_date,report_hour,country_code
				FROM (
					SELECT DISTINCT(FactPageView.session),DimDate.report_date AS `report_date`,DimDate.report_hour AS `report_hour`,DimLocation.country_code AS `country_code`
						FROM fact_page_views AS `FactPageView`
						INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
						INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
						WHERE DimDate.report_date = '{$date}' {$sql_filter}
				) AS Traffic
				GROUP BY country_code,report_date,report_hour
			) AS Traffic
			GROUP BY country_code"
		);
		
		$unq = array();
		
		foreach($country_unq as $k=>$v) {
			
			
			$unq[$v['Traffic']['country_code']] = $v[0]['total'];
			
			
		}
		
		unset($country_unq);
		
		$berra_unq = array();
		
		foreach($country_berra as $v) {
			
			$berra_unq[$v['Traffic']['country_code']] = $v[0]['uniques'];
			
		}
		
		unset($country_berra);
		
		foreach($country_pv as $k=>$v) {
			
			$country_pv[$k][0]['uniques'] = $unq[$v['DimLocation']['country_code']];
			$country_pv[$k][0]['berra_uniques'] = $berra_unq[$v['DimLocation']['country_code']];
		}
		
		
		//get some select lists
		
		$domainList = $this->DimDomain->selectList();
		
		$this->set(compact("hourly_pv","country_pv","date","domainList"));
		
	}
	
	public function all_countries() {
		
		
		
	}
	
	public function country() {
		
		
		
		
	}
	
	public function country_month_index() {
		
		$this->loadStuff();
		
		if(isset($this->data['Filters']['report_month']['month'])) {
			
			$month = $this->data['Filters']['report_month']['month'];
			
		} else {
			
			$month = date("m");
			
		}
		
		if(isset($this->data['Filters']['report_year']['year'])) {
			
			$year = $this->data['Filters']['report_year']['year'];
			
		} else {
			
			$year = date("Y");
			
		}
		
		$this->data['Filters']['report_year']['year'] = $year;
		$this->data['Filters']['report_month']['month'] = $month;
		
		$domain_id = false;
		
		if(isset($this->data['Filters']['dim_domain_id'])) {
			
			$domain_id = $this->data['Filters']['dim_domain_id'];
			
		}
		
		if(isset($this->params['named']['dim_domain_id']) && !$domain_id) {
			
			$domain_id = $this->data['Filters']['dim_domain_id'] = $this->params['named']['dim_domain_id'];
			
		}
		
		//build sql filters
		$sql_filter = '';
		
		if($domain_id) {
			
			$sql_filter = " AND FactPageView.dim_domain_id = '{$domain_id}'";
			
		}
		
		
		
		
		//query up the country page views, we can attach the unquies and the berra uniques later
		$report = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,DimLocation.country_code
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
				GROUP BY DimLocation.country_code
				ORDER BY total DESC
			"
		);
		
		//let's get the uniques for the countries
		
		$uniques = $this->FactPageView->query(
			"SELECT COUNT(*) AS `uniques`,country_code
			FROM (
				SELECT DISTINCT(session),DimLocation.country_code
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
			) AS Uniques
			GROUP BY country_code
			"
		);
		
		$berra = $this->FactPageView->query(
			"SELECT SUM(uniques) AS `total`,country_code
			FROM(
				SELECT COUNT(*) AS `uniques`,country_code FROM (
					SELECT DISTINCT(session),DimLocation.country_code AS `country_code`,DimDate.report_day AS `report_day`,DimDate.report_hour AS `report_hour`
					FROM fact_page_views AS `FactPageView`
					INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
					INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
					WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
				) AS UniqueSessions GROUP BY country_code,report_day,report_hour
			) AS Uniques
			GROUP BY country_code
			"
		);
		
		$unq = array();
		
		foreach($uniques as $v) {
			
			$unq[$v['Uniques']['country_code']] = $v[0]['uniques'];
			
		}
		
		$b_unq = array();
		
		foreach($berra as $v) {
			
			$b_unq[$v['Uniques']['country_code']] = $v[0]['total'];
			
		}
		
		foreach($report as $k=>$v) {
			
			$report[$k][0]['uniques'] = $unq[$v['DimLocation']['country_code']];
			$report[$k][0]['berra'] = $b_unq[$v['DimLocation']['country_code']];
		}
		
		
		//select lists
		
		$domainList = $this->DimDomain->selectList();
		
		$this->set(compact("report","domainList"));
		
	}
	
	public function country_month_overview() {
		
		$this->loadStuff();
		
		$month = false;
		$year = false;
		$domain_id = false;
		$country_code = false;
		$sql_filter = '';
		
		if(isset($this->data['Filters']['report_month']['month'])) {
			
			$month = $this->data['Filters']['report_month']['month'];
			
		}
		
		if(!$month && isset($this->params['named']['report_month'])) {
			
			$month = $this->data['Filters']['report_month']['month'] =  $this->params['named']['report_month'];
			
		}
		
		//year
		
		if(isset($this->data['Filters']['report_year']['year'])) {
			
			$year = $this->data['Filters']['report_year']['year'];
			
		}
		
		if(!$year && isset($this->params['named']['report_year'])) {
			
			$year = $this->data['Filters']['report_year']['year'] = $this->params['named']['report_year'];
			
		}
		
		//domain id
		
		if(isset($this->data['Filters']['dim_domain_id'])) {
			
			$domain_id = $this->data['Filters']['dim_domain_id'];
			
		}
		
		if(!$domain_id && isset($this->params['named']['dim_domain_id'])) {
		
			$domain_id = $this->data['Filters']['dim_domain_id'] = $this->params['named']['dim_domain_id'];
			
		}
		
		if(isset($this->data['Filters']['country_code'])) {
			
			$country_code = $this->data['Filters']['country_code'];
			
		}
		
		if(!$country_code && isset($this->params['named']['country_code'])) {
			
			$country_code = $this->data['Filters']['country_code'] = $this->params['named']['country_code'];
			
		}
		
		
		//make the sql filters
		if($domain_id) {
			
			$sql_filter = " AND FactPageView.dim_domain_id = {$domain_id}";
			
		}
		
		
		//now lets do some queries
		
		$report = $this->FactPageView->query("
		
			SELECT COUNT(*) AS `total`,DimLocation.region_name,DimLocation.region_code
			FROM fact_page_views AS `FactPageView`
			INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
			WHERE DimDate.report_year = {$year} AND DimDate.report_month = {$month} 
			AND DimLocation.country_code = '{$country_code}'
			{$sql_filter}
			GROUP BY DimLocation.region_code
			ORDER BY total DESC
		");
			
			//get the uniques
			
		$uniques = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,region_name,region_code
			FROM (
				SELECT DISTINCT(session) AS `total`, DimLocation.region_code AS `region_code`, DimLocation.region_name AS `region_name`
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimLocation.country_code = '{$country_code}' AND DimDate.report_year = {$year}
				AND DimDate.report_month = {$month}
				{$sql_filter}
			) AS Traffic
			GROUP BY region_code
			"
		);
		
		$berra = $this->FactPageView->query(
			"SELECT SUM(total) AS `berra`,region_code,region_name
				FROM (
					SELECT COUNT(*) AS `total`,region_name,region_code
					FROM (
						SELECT DISTINCT(session) AS `total`, DimLocation.region_code AS `region_code`, DimLocation.region_name AS `region_name`,DimDate.report_day AS `report_day`, DimDate.report_hour AS `report_hour`
						FROM fact_page_views AS `FactPageView`
						INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
						INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
						WHERE DimLocation.country_code = '{$country_code}' AND DimDate.report_year = {$year}
						AND DimDate.report_month = {$month}
						{$sql_filter}
						) AS Traffic
						GROUP BY region_code,report_day,report_hour
				) AS Traffic
			GROUP BY region_code"
		);
	
		
		$unq = array();
		
		foreach($uniques as $v) {
			
			$unq[$v['Traffic']['region_code']] = $v[0]['total'];
			
		}
		
		$b_unq = array();
		
		foreach($berra as $v) {
			
			$b_unq[$v['Traffic']['region_code']] = $v[0]['berra'];
			
		}
		
		foreach($report as $k=>$v) {
			
			$report[$k][0]['uniques'] = $unq[$v['DimLocation']['region_code']];
			$report[$k][0]['berra'] = $b_unq[$v['DimLocation']['region_code']];
		}
		
		
		
		
		//select lists
		
		$domainList = $this->DimDomain->selectList();
		
		$this->set(compact("report","domainList"));
			
	}
	
	
	public function country_by_day($date = false,$country_code = false) {
		
		$this->loadStuff();
		
		if(!$date) {
			
			return $this->invalidUrl("/");
			
		}
		
		$dim_domain_id = false;
		$sql_filter = '';
		
		if(Set::check($this->data,"Filters.report_date")) {
			
			$date = $this->data['Filters']['report_date'];
			
		} else {
			
			$this->data['Filters']['report_date'] = $date;
			
		}
		
		//country code
		if(Set::check($this->data,"Filters.country_code")) {
			
			$country_code = $this->data['Filters']['country_code'];
			
		} else {
			
			$this->data['Filters']['country_code'] = $country_code;
			
		}
		
		
		//incoming domain?
		
		
		if(isset($this->data['Filters']['dim_domain_id'])) {
			
			$dim_domain_id = $this->data['Filters']['dim_domain_id'];
			
		}
		
		if(isset($this->params['named']['dim_domain_id']) && !$dim_domain_id) {
			
			$this->data['Filters']['dim_domain_id'] = $dim_domain_id = $this->params['named']['dim_domain_id'];
			
		}
		
		
		//build up some filters
		if($dim_domain_id) {
	
			$sql_filter = " AND FactPageView.dim_domain_id = '".$dim_domain_id."'";
			
		}
		
		//let's send out some queries!
		$report = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,DimLocation.region_code,DimLocation.region_name
			FROM fact_page_views AS `FactPageView`
			INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
			WHERE DimDate.report_date = '{$date}' AND DimLocation.country_code = '{$country_code}' {$sql_filter}
			GROUP BY DimLocation.region_code 
			ORDER BY total DESC"
		);
		
		$uniques = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,region_name,region_code
			FROM (
				SELECT DISTINCT(session) AS `uniques`,DimLocation.region_code AS `region_code`, DimLocation.region_name AS `region_name`
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				WHERE DimDate.report_date = '{$date}' AND DimLocation.country_code = '{$country_code}' {$sql_filter}
			) AS Traffic
			GROUP BY region_code
			"
		);
		
		$berra = $this->FactPageView->query(
		
			"SELECT SUM(uniques) AS `total`,region_name,region_code
			FROM (
				SELECT COUNT(*) AS `uniques`,region_name,region_code
				FROM (
					SELECT DISTINCT(session) AS `uniques`,DimDate.report_hour AS `report_hour`,DimDate.report_day AS `report_day`,DimLocation.region_name AS `region_name`, DimLocation.region_code AS `region_code`
					FROM fact_page_views AS `FactPageView`
					INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactPageView.dim_location_id)
					INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
					WHERE DimDate.report_date = '{$date}' AND DimLocation.country_code = '{$country_code}' {$sql_filter}
				) AS Traffic
				GROUP BY region_code,report_day,report_hour
			) AS Traffic
			GROUP BY region_code"
		
		);
		
		$unq = array();
		
		$b_unq = array();
		
		foreach($uniques as $v) {
			
			$unq[$v['Traffic']['region_code']] = $v[0]['total'];
 			
		}
		
		foreach($berra as $v) {
			
			$b_unq[$v['Traffic']['region_code']] = $v[0]['total'];
			
		}
		
		foreach($report as $k=>$v) {
			
			$report[$k][0]['uniques'] = $unq[$v['DimLocation']['region_code']];
			$report[$k][0]['berra'] = $b_unq[$v['DimLocation']['region_code']];
			
		}
		
		//get some select lists
		$domainList = $this->DimDomain->selectList();
		
		$this->set(compact("domainList","report"));
		
	}
	
	
	public function monthly_country() {
		
		
		
	}
	
	
	public function dma_codes() {
		
		$this->loadStuff();
		
		$month = false;
		$year = false;
		$domain_id = false;
		$sql_filter = '';
		
		if(Set::check($this->data,"Filters.report_month.month")) {
			
			$month = $this->data['Filters']['report_month']['month'];
			
		} else {
			
			$month = $this->data['Filters']['report_month']['month'] = date("m");
			
		}
		
		//get the year
		
		if(Set::check($this->data,"Filters.report_year.year")) {
			
			$year = $this->data['Filters']['report_year']['year'];
			
		} else {
			
			$year = $this->data['Filters']['report_year']['year'] = date("Y");
			
		}
		
		//get the domain id 
		
		if(Set::check($this->data,"Filters.dim_domain_id")) {
			
			$domain_id = $this->data['Filters']['dim_domain_id'];
			
		}
		
		//make the pv report
		$report = $this->FactPageView->query(
			"SELECT COUNT(*) AS `total`,DimDmaCode.dma_code,DimDmaCode.dma_location
			FROM fact_page_views AS `FactPageView` 
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
			INNER JOIN dim_domains AS `DimDomain` ON (DimDomain.id = FactPageView.dim_domain_id)
			INNER JOIN dim_dma_codes AS `DimDmaCode` ON (DimDmaCode.id = FactPageView.dim_dma_code_id)
			WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
			GROUP BY DimDmaCode.dma_code
			ORDER BY total DESC"
		);
		
		$uniques = $this->FactPageView->query(
		
			"SELECT COUNT(*) AS `total`,dma_code
			FROM (
				SELECT DISTINCT(session),DimDmaCode.dma_code AS `dma_code`
				FROM fact_page_views AS `FactPageView`
				INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
				INNER JOIN dim_domains AS `DimDomain` ON (DimDomain.id = FactPageView.dim_domain_id)
				INNER JOIN dim_dma_codes AS `DimDmaCode` ON (DimDmaCode.id = FactPageView.dim_dma_code_id)
				WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
			) AS Traffic
			GROUP BY dma_code"
		);
		
		$berra = $this->FactPageView->query(
			"SELECT SUM(uniques) AS `total`,dma_code
			FROM (
				SELECT COUNT(*) AS `uniques`,dma_code,report_hour,report_day
				FROM (
					SELECT DISTINCT(session),DimDmaCode.dma_code AS `dma_code`,DimDate.report_day AS `report_day`,DimDate.report_hour AS `report_hour`
					FROM fact_page_views AS `FactPageView`
					INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactPageView.dim_date_id)
					INNER JOIN dim_domains AS `DimDomain` ON (DimDomain.id = FactPageView.dim_domain_id)
					INNER JOIN dim_dma_codes AS `DimDmaCode` ON (DimDmaCode.id = FactPageView.dim_dma_code_id)
					WHERE DimDate.report_month = '{$month}' AND DimDate.report_year = '{$year}' {$sql_filter}
				) AS Traffic
				GROUP BY dma_code,report_day,report_hour
			) AS Traffic
			GROUP BY dma_code"
		);
		
		$unq = array();
		
		$b_unq = array();
		
		foreach($uniques as $v) {
			
			$unq[$v['Traffic']['dma_code']]  = $v[0]['total'];
			
		}
		
		foreach($berra as $v) {
			
			$b_unq[$v['Traffic']['dma_code']] = $v[0]['total'];
			
		}
		
		//fill in the report
		foreach($report as $k=>$v) {
			
			$report[$k][0]['uniques'] = $unq[$v['DimDmaCode']['dma_code']];
			$report[$k][0]['berra'] = $b_unq[$v['DimDmaCode']['dma_code']];
			
		}
		
		//get some select lists
		$domainList = $this->DimDomain->selectList();
		
		$this->set(compact("report","domainList"));
		
	}

	
	public function test() {
		
		$this->loadStuff();
		
		//test out us and ca

		
		
	}
	
	
	public function media_files() {
		
		
		if(count($this->data)>0) {
			
			$url = array(
				"action"=>"media_files"
			);
			
			
			foreach($this->data['FactMediaView'] as $k=>$v) {
				
				$url[$k] = urlencode($v); 
				
			}
			
			return $this->redirect($url);
			
		}
		
		$this->loadStuff();
		
		
		if(!isset($this->params['named']['date_start'])) {

			$this->params['named']['date_start'] = date("Y-m-d",strtotime("-10 Day"));
			
		}
		if(!isset($this->params['named']['date_end'])) {
			
			$this->params['named']['date_end'] = date("Y-m-d");
			
		} 
		if(!isset($this->params['named']['limit'])) {
			
			$this->params['named']['limit'] = 20;
			
		}
		
		$sql = '';
		
		if(isset($this->params['named']['media_file_id'])) {
			
			$sql .=" AND FactMediaView.media_file_id = '{$this->params['named']['media_file_id']}'";
			
		}
		
		
		$report = $this->FactMediaView->query("
			SELECT 
			count(*) as `total`,
			FactMediaView.media_file_id
			FROM fact_media_views as `FactMediaView`
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactMediaView.dim_date_id)
			WHERE DimDate.report_date between '{$this->params['named']['date_start']}' AND '{$this->params['named']['date_end']}' 
			{$sql}
			GROUP BY FactMediaView.media_file_id
			ORDER BY total DESC
			LIMIT {$this->params['named']['limit']}
		");
				
			
		//get all the media file ids

		$mediaIds = Set::extract("/FactMediaView/media_file_id",$report);
		
		
		$media_files = $this->MediaFile->find("all",array(
		
			"conditions"=>array(
				"MediaFile.id"=>$mediaIds
			),
			"contain"=>array()
		
		));
		
			
		$this->set(compact("report","media_files"));	
		
	}
	
	
	public function media_file_details() {
		
		if(count($this->data)>0) {
			
			$url = array(
				"action"=>"media_file_details"
			);
			
			
			foreach($this->data['FactMediaView'] as $k=>$v) {
				
				$url[$k] = urlencode($v); 
				
			}
			
			return $this->redirect($url);
			
		}
		
		
		if(!isset($this->params['named']['media_file_id'])) {
			
			
			die("Invalid Link!");
			
		}
		
		if(!isset($this->params['named']['date_start'])) {
			
			$this->params['named']['date_start'] = date("Y-m-d",strtotime("-10 Days"));
			
		}

		if(!isset($this->params['named']['date_end'])) {
			
			$this->params['named']['date_end'] = date("Y-m-d");
			
		}
		
		if(preg_match('/^(queue)/',$this->params['named']['media_file_id'])) {
			
			$videos = $this->Session->read("MediaFileReportQueue");
			
			$ids = '';
			
			foreach($videos as $v) {
				
				$ids .= "'{$v}',";
				
			}
			
			$ids = rtrim($ids,",");
			
			$sql = "AND FactMediaView.media_file_id IN ({$ids})";
			$cond = array(
				"MediaFile.id"=>$videos
			);	
			
		} else {
			
			$sql = "AND FactMediaView.media_file_id = '{$this->params['named']['media_file_id']}'";
			$cond = array(
				"MediaFile.id"=>$this->params['named']['media_file_id']
			);
		}
		
		
		$this->loadStuff();
		
		$report = $this->FactMediaView->query("
			SELECT 
			count(*) as `total`,
			FactMediaView.media_file_id,
			DimLocation.country_code
			FROM fact_media_views as `FactMediaView`
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactMediaView.dim_date_id)
			INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactMediaView.dim_location_id)
			WHERE DimDate.report_date between '{$this->params['named']['date_start']}' AND '{$this->params['named']['date_end']}' 
			{$sql}
			GROUP BY DimLocation.country_code
			ORDER BY total DESC
		");
		
		
		$media_file = $this->MediaFile->find("all",array(
		
			"conditions"=>$cond,
			"contain"=>array()
			
		));
		
		$this->set(compact("report","media_file"));
		
	}
	
	
	public function media_realtime() {
		
		$this->loadStuff();
		
		$realtime = $this->MediaFileView->find("all",array(
		
			"conditions"=>array(),
			"contain"=>array(
				"MediaFile"
			),
			"limit"=>100,
			"order"=>array("MediaFileView.id"=>"DESC")
		
		));
		
		$this->set(compact("realtime"));
		
	}
	
	public function media_monthly_overview() {
		
		
		if(isset($this->data['MediaViewFilters'])) {
			
			return $this->redirect($this->data['MediaViewFilters']);
			
		}
		
		$this->loadStuff();
		
		
		//get the date
		
		if(!isset($this->params['named']['date_start']) || !isset($this->params['named']['date_end'])) {
			
			$this->params['named']['date_start'] = date("Y-m-d",strtotime("-7 Days"));
			$this->params['named']['date_end'] = date("Y-m-d");
			
		}
		
		$report = $this->FactMediaView->query(
			"SELECT count(*) AS `total`,DimDate.report_date
			FROM fact_media_views AS `FactMediaView` 
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactMediaView.dim_date_id)
			WHERE DimDate.report_date between '{$this->params['named']['date_start']}' AND '{$this->params['named']['date_end']}'
			GROUP BY DimDate.report_date
			ORDER BY DimDate.report_date ASC
			"
		);
		
		$this->set(compact("report"));
		
	}
	
	public function media_daily($date_in = false) {
		
		if(isset($this->data['MediaReportDaily']['report_date'])) {
			
			return $this->redirect(array(0=>$this->data['MediaReportDaily']['report_date']));
			
		}
		
		$this->loadStuff();
		
		$country = $this->FactMediaView->query(
			"SELECT count(*) as `total`,DimLocation.country_code
			FROM fact_media_views AS `FactMediaView`
			INNER JOIN dim_locations AS `DimLocation` ON (DimLocation.id = FactMediaView.dim_location_id)
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactMediaView.dim_date_id)
			WHERE DimDate.report_date = '{$date_in}'
			GROUP BY DimLocation.country_code
			ORDER BY total DESC
			"
		);
		
		$hours = $this->FactMediaView->query("
		
			SELECT count(*) AS `total`,DimDate.report_hour
			FROM fact_media_views AS `FactMediaView`
			INNER JOIN dim_dates AS `DimDate` ON (DimDate.id = FactMediaView.dim_date_id)
			WHERE DimDate.report_date = '{$date_in}'
			GROUP BY DimDate.report_hour
			ORDER BY DimDate.report_hour ASC
		
		");
		
		$this->set(compact("country","hours"));
		
	}
	
	
	
	public function pages_realtime() {
		
		$this->loadStuff();
		
		
		
	}
	
	private function loadStuff() {
		
		$this->loadModel("FactPageView");
		$this->loadModel("DimDomain");
		$this->loadModel("DimLocation");
		$this->loadModel("DimDate");
		$this->loadModel("DimRequest");
		$this->loadModel("DimDmaCode");
		$this->loadModel("FactMediaView");
		$this->loadModel("MediaFile");
		$this->loadModel("MediaFileView");
		$this->loadModel("PageViews");
		
	}
	
	
	
}


?>