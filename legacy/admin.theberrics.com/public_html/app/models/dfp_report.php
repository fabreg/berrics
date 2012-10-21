<?php

class DfpReport extends AppModel {
	
	
	public function reportFileExists($report) {
		
		$file = TMP."dfp/".$report['DfpReport']['report_id'].".csv";
		
		return file_exists($file);
		
	}
	
}