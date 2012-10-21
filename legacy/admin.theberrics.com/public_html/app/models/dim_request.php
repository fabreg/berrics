<?php

class DimRequest extends Model {
	
	
	public $useDbConfig = "traffic";
	
	public function returnRequestId($request = NULL) {
		
		$res = $this->find("first",array(
		
			"fields"=>array(
				"DimRequest.id"
			),
			"conditions"=>array(
			
				"DimRequest.request_uri"=>$request
		
			)
		
		));
		
		$id = NULL;
		
		if(!empty($res['DimRequest']['id'])) {
			
			$id = $res['DimRequest']['id'];
	
		}
		
		unset($res);
		
		return $id;
		
		
	}
	
}

?>