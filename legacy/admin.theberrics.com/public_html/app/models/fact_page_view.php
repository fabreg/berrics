<?php

class FactPageView extends Model {
	
	
	public $useDbConfig = "traffic";
	
	public function makeGoogCsv($date ='') {
		
		function array_keys_multi($array,&$vals=array())
		{
			foreach ($array as $key => $value) {
		
				if (is_array($value)) {
		
					array_keys_multi($value,$vals);
		
				}else{
		
					$vals[] = $value;
				}
			}
		
			return $vals;
		}
		
		$page = 1;
		
		while(true) {
			
			$sql = "SELECT
			PageView.session,DimRequest.request_uri,
			DimDate.report_hour,DimDate.report_day,DimDate.report_month,DimDate.report_year,
			DimLocation.country_code,
			DimLocation.region_name,
			PageView.mobile
			FROM fact_page_views `PageView`
			INNER JOIN dim_requests `DimRequest` on DimRequest.id = PageView.dim_request_id
			INNER JOIN dim_dates `DimDate` on DimDate.id = PageView.dim_date_id
			INNER JOIN dim_locations `DimLocation` on DimLocation.id = PageView.dim_location_id
			WHERE DimDate.report_date ='{$date}'
			ORDER BY PageView.id ASC
			LIMIT $page,5000";
			
			$data = $this->query($sql);
			
			if(count($data)>0) {
				
				foreach($data as $r) {
				
					$s = array_keys_multi($r);
				
					$s = implode(",",$s);
						
					file_put_contents("/tmp/$date.csv", $s."\n",FILE_APPEND);
					
					unset($s);
						
				}
				unset($data);
				$page++;
				
			} else {
				
				continue;
				
			}
			
			
		}
		
		
		
	}
	
	
}


?>