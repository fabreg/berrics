<?php

class CardData extends AppModel {
	
	
	public function setCardValidation() {
		
		$this->validate = array(
			"number"=>"cc",
			"code"=>"notEmpty"
		);
		
	}
	
	
}