<?php

class Website extends AppModel {
	
	
	

	public function dropdown() {
		
		$data = $this->find("list",array("order"=>array("Website.name"=>"ASC")));

		return $data;

	}
	
	
}


?>