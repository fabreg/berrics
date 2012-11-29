<?php

/**
* 
*/
class SearchItem extends AppModel {
	

	public function insertItem($data) {
		
		//do a check to see if we insert or update
		$chk = $this->find("first",array(
			"conditions"=>array(
				"SearchItem.model"=>$data['model'],
				"SearchItem.foreign_key"=>$data['foreign_key']
			)
		));

		$this->create();

		if(isset($chk['SearchItem']['id'])) $this->id = $chk['SearchItem']['id'];

		$this->save($data);

		return $this->id;

	}


}