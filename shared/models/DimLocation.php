<?php

class DimLocation extends Model {
	
	public $useDbConfig = "traffic";
	
	
	public function returnLocationId($country,$region) {
		
		
		$res = $this->find("first",array(
		
			"fields"=>array("DimLocation.id"),
			"conditions"=>array(
				"DimLocation.country_code"=>$country,
				"DimLocation.region_code"=>$region
			)
		
		));
		$id = NULL;
		if(!empty($res['DimLocation']['id'])) {
			
			$id = $res['DimLocation']['id'];
			
		} 
		
		unset($res);
		
		return $id;
		
	}
	
}

?>