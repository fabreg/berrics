<?php

$report = Report::formatReportData($report);

if(count($report['Report']['data_formatted'])<=0) {
	
	
	echo $this->Html->div("alert alert-danger","Report Returned No Data");
	
	
} else {
	
	switch($report['Report']['report_type']) {
		
		case "url_report":
			$element = "date_overview";
		break;
		default:
			$element = $report['Report']['report_type'];
		break;
		
	}
	
	echo $this->element("reports/types/".$element,compact("report"));
	
}


?>