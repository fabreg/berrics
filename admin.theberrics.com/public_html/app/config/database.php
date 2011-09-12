<?php
class DATABASE_CONFIG {
	
	public $default = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.66.225',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	); 
	
	public $master = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.91.233',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics',
		'prefix' => '',
	);
	
	
	public $traffic = array(
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.80.72',
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
		'driver' => 'mysql',
		'persistent' => false,
		'host' => '10.181.91.233',
		'login' => 'john',
		'password' => '19Berrics82',
		'database' => 'theberrics_legacy',
		'prefix' => '',
	);
	
	
}
