<?php

class DimDomain extends Model {
	
	public $useDbConfig = "traffic";
	
	public function returnDomainId($domain = false) {
		
		$res = $this->find("first",array(
			
			"fields"=>array("DimDomain.id"),
			"conditions"=>array(
				"DimDomain.domain_name" => $domain
			)
		
		));
		
		$id = NULL;
		
		if(!empty($res['DimDomain']['id'])) {
			
			$id = $res['DimDomain']['id'];
			
		}
		
		unset($res);
		
		return $id;
		
	}
	
	public function selectList() {
		
		return $this->find("list",array(
					"fields"=>array("DimDomain.id","DimDomain.domain_name"),
					"order"=>array("DimDomain.domain_name"=>"ASC")	
				
				));
		
	}
	
	
}