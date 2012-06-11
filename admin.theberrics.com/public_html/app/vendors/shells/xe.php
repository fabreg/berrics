<?php

class XeShell extends Shell {
	
	public $uses = array("Currency");
	
	public function update() {
		
		$this->Currency->save_xe_currency_file();
		
		$this->Currency->parse_xe_file();
		
	}
	
	
}