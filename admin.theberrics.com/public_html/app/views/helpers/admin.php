<?php

class AdminHelper extends AppHelper {
	
	public $helpers = array("Html");
	
	
	public function attachMediaLink($model,$key,$val,$post_back) {
		
		return $this->Html->link("Attach Media",array("controller"=>"media_files","action"=>"attach_media",$model,$key,$val,base64_encode($post_back)));
		
		
	}
	
	public function monthlyReportLink($opt = array()) {
		
		$params = array();
		
		$date = $opt['date'];
		
		$data = $opt['data'];
		//check to see if we have a dim_domain_id 
		if(isset($data['Filters']['dim_domain_id'])) {
			
			$params['dim_domain_id'] = $data['Filters']['dim_domain_id'];
			
		}
		
		$params[] = $date;
		
		
		$link = array("controller"=>"traffic_reports","action"=>"day");
		
		//merge link and params
		
		$merge = array_merge($link,$params);
		
		return $this->Html->link($opt['label'],$merge);
		
		
	}
	
	
}



?>