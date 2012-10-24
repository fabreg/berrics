<?php

class PageView extends AppModel {
	
	public $useDbConfig = "master";
	
	public function getUniques() {
		
		$token = "realtime-uniques";
		
		$data = $this->query(
				"select count(distinct(session)) as `total` from page_views"
				);
		
		return $data;
		
	}
	
	public function getPageViews() {
		
		$token = "realtime-pageviews";
		
		$data = $this->query(
					"select count(*) as `total` from page_views"
				);
		
		return $data;
		
	}
	
	public function getTopPages($limit = 15) {
		
		$data = $this->query(
					"select count(*) as `total`,script_url,domain_name
					from page_views
					where script_url != '/dailyops/rss'
					group by domain_name,script_url
					order by total desc
				
					limit {$limit}
					"
				);

		return $data;
		
	}
	
}