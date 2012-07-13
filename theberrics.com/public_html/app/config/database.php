<?php

class DATABASE_CONFIG {
	
	public $default = array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => '10.183.200.12',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);

	public $master = array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => '10.183.200.8',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	public $sessions = array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => '10.183.64.37',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	public $traffic = array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => '10.183.65.132',//10.181.80.72
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_traffic',
		'prefix' => '',
	);
	/*
	public $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.66.238',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_dev',
		'prefix' => '',
	);
	
	public $master = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.66.238',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_dev',
		'prefix' => '',
	);
	
	*/
	public $legacy = array(
		'driver' => 'mysqli',
		'persistent' => true,
		'host' => '10.183.200.8',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_legacy',
		'prefix' => '',
	);
		
	public function __construct() {

		$uname = php_uname('n');

		if(preg_match('/(WEB2VM)/i',$uname)) {
			
			$this->sessions['host'] = $this->default['host'] = $this->master['host'] = '127.0.0.1';
		}	

	}


	function DATABASE_CONFIG() 
    { 
        $this->__construct(); 
    } 
	
}