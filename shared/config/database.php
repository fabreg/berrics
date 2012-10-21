<?php

class DATABASE_CONFIG {
	
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host' => '10.183.200.12',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);

	public $master = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host' => '10.183.200.8',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	public $sessions = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host' => '10.183.64.37',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	public $traffic = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host' => '10.183.65.132',//10.181.80.72
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_traffic',
		'prefix' => '',
	);

		
	public function __construct() {

		$uname = php_uname('n');

		if($uname == 'WEB2VM') {
			
			$this->sessions['host'] = $this->default['host'] = $this->master['host'] = '127.0.0.1';
			
			$this->traffic['host'] = '50.57.129.17';
			
		}	

	}


	function DATABASE_CONFIG() 
    { 
        $this->__construct(); 
    } 
	
}