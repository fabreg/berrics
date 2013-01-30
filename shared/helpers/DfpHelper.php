<?php

class DfpHelper extends AppHelper {
	
	public $helpers = array("Html");
	
	
	public function formatCsvReport($csv = false, $filters = false) {
		
		if(!$csv || !$filters) {
			
			return false;
			
		}
		
		App::import("Vendor","DfpApi",array("file"=>"DfpApi.php"));
		$orders = unserialize($filters);
		foreach($orders['order'] as $k=>$v) $orders[$k] = json_decode($v);
		$rows = explode("\n",$csv);
		$header = str_getcsv($rows[0]);
		$data = array();
		$totals = array();
		
		array_shift($rows);
		
		foreach($rows as $k=>$r) {
			
			$r = str_getcsv($r);
			$comp = array();
			foreach($header as $kk=>$vv) $comp[$vv] = $r[$kk];
			$r['named'] = $comp;
			
			if(!array_key_exists($r[3],$orders)) continue;
			
			try{ 
				
				$cr = DFPAPI::instance()->getCreative($r['named']['Creative ID']);
				
			}
			
			catch(Exception $e) {
				
				
			}
			
			switch($cr['CreativeType']) {
				
				case 'ImageCreative':
					
					$opt = array();
					
					if($cr['size']['width'] == 728) {
						
						$opt['width'] = 364;
						$opt['height'] = 45;
						
					} else if($cr['size']['height'] == 600) {
						
						$opt['width'] = 80;
						$opt['height'] = 300;
					} 
					
					$cell = $this->Html->image($cr['imageUrl'],$opt);
					
				break;
				
				case 'FlashCreative':
					
					$cell = $this->Html->tag("iframe","",array(
						
						"width"=>$cr['size']['width'],
						"height"=>$cr['size']['height'],
						"src"=>$cr['previewUrl'],
						"frameborder"=>"0",
						"scrolling"=>"0"
						
					));
					//pr($cr);
				break;
				default:
					$cr = array(
						"CreativeType"=>"VideoCommercial"
					);
				break;
			}
			
			$r['Creative'] = $cr;
			

			
			//print_r($cr);
			$totals[$r['Creative']['CreativeType']]['impressions'] +=  str_replace(",","",$r['named']['Impressions']);
			$totals[$r['Creative']['CreativeType']]['ctr'] +=  str_replace(",","",$r['named']['CTR']);
			$totals[$r['Creative']['CreativeType']]['clicks'] +=  str_replace(",","",$r['named']['Clicks']);
			$data[] = $r;
		}
		
		
		
		$data['Totals'] = $totals;
		
		return $data;
		
	}
	
}