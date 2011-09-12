<?php

class DimDmaCode extends Model {
	
	public $useDbConfig = "traffic";
	
	
	public function returnDmaCodeId($dma_code) {
		
		$res = $this->find("first",array(
			
			"fields"=>array("DimDmaCode.id"),
			"conditions"=>array(
				"DimDmaCode.dma_code"=>$dma_code
			)	
		
		));
		
		$id = NULL;
		
		if(!empty($res['DimDmaCode']['id'])) {
			
			
			$id = $res['DimDmaCode']['id'];
			
		}
		
		unset($res);
		
		return $id;
		
	}
	
}


?>