<?php

class LjgToolsShell extends Shell {
	
	
	public $uses = array("CanteenShippingRecord","CanteenInventoryRecord");
	
	
	public function export() {
		
		SysMsg::add(array(
			"title"=>"Start La Jolla Order Send",
			"category"=>"LjgOrderFile",
			"from"=>"LjgShell",
			"crontab"=>1
		));
		
		$file_id = $this->CanteenShippingRecord->ljg_process_pending();
		
		$this->CanteenShippingRecord->ljg_create_orders_file($file_id);
		
		$this->CanteenShippingRecord->ljg_ftp_file($file_id);
		
		SysMsg::add(array(
			"title"=>"End La Jolla Order Send",
			"category"=>"LjgOrderFile",
			"from"=>"LjgShell",
			"crontab"=>1
		));
	}

	public function update_inventory() {

		$this->CanteenInventoryRecord->import_ljg_inventory();

	}
	
}