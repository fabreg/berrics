<?php

	foreach($this->data['CanteenProductPrice'] as $k=>$price) {
		
		echo $this->Form->input("CanteenProductPrice.{$k}.price",array("label"=>$price['Currency']['name']));
		echo $this->Form->input("CanteenProductPrice.{$k}.id");
	}
	echo $this->Form->submit("Update Pricing");
?>	
