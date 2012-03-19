<?php

App::import("Controller","LocalApp");

class GatewayReportsController extends LocalAppController {
	
	
	public $uses = array("GatewayAccount","GatewayTransaction");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		$gatewayAccounts = $this->GatewayAccount->find("list");
		
		$this->set(compact("gatewayAccounts"));
		
	}
	
	public function view() {
		
		if(
			empty($this->data['GatewayAccount']['id']) ||  
			empty($this->data['GatewayAccount']['date_start']) || 
			empty($this->data['GatewayAccount']['date_end'])
		) {
			
			return $this->cakeError("error404");
			
		}
		
		
		$account = $this->GatewayAccount->find("first",array(
			
			"conditions"=>array(
				"GatewayAccount.id"=>$this->data['GatewayAccount']['id']
			),
			"contain"=>array()
		
		));
		
		//build the super duper fucking query
		$report = $this->GatewayTransaction->query(
			"SELECT SUM(GatewayTransaction.amount) AS `total`,GatewayTransaction.method
				FROM gateway_transactions `GatewayTransaction` 
				WHERE GatewayTransaction.gateway_account_id='{$this->data['GatewayAccount']['id']}'
				AND GatewayTransaction.created BETWEEN '{$this->data['GatewayAccount']['date_start']}' 
				AND '{$this->data['GatewayAccount']['date_end']}'
				GROUP BY GatewayTransaction.method
				ORDER BY GatewayTransaction.method ASC"
		);
		
		$report_count = $this->GatewayTransaction->query(
			"SELECT COUNT(*) AS `total`,GatewayTransaction.method
				FROM gateway_transactions AS `GatewayTransaction`
				WHERE GatewayTransaction.gateway_account_id='{$this->data['GatewayAccount']['id']}'
				AND GatewayTransaction.created BETWEEN '{$this->data['GatewayAccount']['date_start']}'
				AND '{$this->data['GatewayAccount']['date_end']}'
				GROUP BY GatewayTransaction.method
				ORDER BY GatewayTransaction.method ASC
			"
		);
		
		//format report count into the report array so we can easily use it
		
		foreach($report as $k=>$v) {
			
			foreach($report_count as $kk=>$vv) {
				
				if($v['GatewayTransaction']['method'] == $vv['GatewayTransaction']['method']) {
				
					$report[$k][0]['count'] = $vv[0]['total'];
					
				}
				
			}
			
		}
		
		
		$this->set(compact("report","report_count","account"));
		
		
	}
	
	
}