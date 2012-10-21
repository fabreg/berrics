<?php

class GatewayFactory {
	
	
	public static function getGateway(/*POLYMORPHIC*/) {
		
		$args = func_get_args();
		
		if(isset($args[0]['GatewayAccount'])) {
			
			$acc = $args[0]['GatewayAccount'];

			$obj =  new $acc['provider']($args[0]);
			
			$obj->init();
			
			return $obj;
			
		} 
		
		throw new Exception("Gateway Factory Did Not Have Enough Account Info To Return An Object");

	}
	
	
}