<?php 

$token = $report['DfpReport']['id'];

if($csv) {
			
	if(($report_html = Cache::read($token,"30day")) === false) {
		
		$report_html = $this->element("dfp_reports/super-report",array(compact("csv","report")));
		
		Cache::write($token,$report_html,"30day");
		
	} 
	
	echo $report_html;
	
} else {
	
	echo "<div><a href=''>Report Not Ready - Click Here To Refresh</a></div>";
	
}

?>