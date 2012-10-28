<?php

class DATABASE_CONFIG {
	
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		'host'=>'10.176.164.233',
		//'host' => '10.183.200.12',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);

	public $master = array(
		'datasource' => 'Database/Mysql',
		'persistent' => true,
		//OLD MASTER//'host' => '10.183.200.8',
		//'host'=>'10.183.200.12',
		'host'=>'10.176.129.133',
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


		
	public function __construct() {

		$uname = php_uname('n');

		if($uname == 'WEB2VM') {
			
			//$this->sessions['host'] = $this->default['host'] = $this->master['host'] = '127.0.0.1';

			
		}	

	}


	function DATABASE_CONFIG() 
    { 
        $this->__construct(); 
    } 
	
}