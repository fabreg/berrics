<?php

class DATABASE_CONFIG {
	
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host'=>'berrics-slave.cjt8oyzjbmpj.us-west-2.rds.amazonaws.com',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);

	public $master = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		//'host'=>'10.176.129.133',
		'host'=>'berrics-master.cjt8oyzjbmpj.us-west-2.rds.amazonaws.com',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	public $sessions = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => '10.183.64.37',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);


		
	public function __construct() {

		$uname = php_uname('n');

		if(preg_match('/(WEB2VM)|(johncent)/',$uname)) {
			
			$this->sessions['host'] = $this->default['host'] = $this->master['host'] = '127.0.0.1';

			
		}	

	}


	function DATABASE_CONFIG() 
    { 
        $this->__construct(); 
    } 
	
}