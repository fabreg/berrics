<?php

App::import("Vendor","BigQueryApi",array("file"=>"BigQueryApi.php"));

class BqReport extends AppModel {
	
	
	public $belongsTo = array(
			"User"
			);
	
	
	
	public function processReportRequest($data) {
		
		$data = $this->formatDates($data);
		
		$this->queueReport($data);
		
	}
	
	public function queueReport($data) {
		
		$data = $this->formatDates($data);
		
		$bq = new BigQueryApi();
		
		//start the the jobs
		
		$bq->processTemplate($data);
		
		
	}
	
	public function formatDates($data) {
		
		if(isset($data['start_date']) && !empty($data['start_date'])) {
			
			$data['ts_start'] = strtotime($data['start_date']." 00:00:00");
			
		}
		
		if(isset($data['end_date']) && !empty($data['end_date'])) {
			
			$data['ts_end'] = strtotime($data['end_date']." 23:59:59");
			
		}
		
		
		return $data;
		
	}
	
}