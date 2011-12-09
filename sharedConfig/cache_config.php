<?php
	
	$memcache_server = array('10.181.65.185:11211');
	
	if(preg_match('/(WEB2VM.THEBERRICS)|(WEB1)/',php_uname('-n'))) {
		
		$memcache_server = array('127.0.0.1:11211');	
		
	}
	
 	Cache::config('1min', array(
 		'engine' => 'Memcache', //[required]
 		'duration'=> 60, //[optional]
 		'probability'=> 5000, //[optional]
  		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true, //[optional]
 	 	"servers"=>$memcache_server
 	));

  	 Cache::config('5min', array(
 		'engine' => 'Memcache', //[required]
  		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true, //[optional],
  	 	'duration'=> 300, //[optional]
  	 	"servers"=>$memcache_server
 	));
	
 	 Cache::config('30sec', array(
 		'engine' => 'Memcache', //[required]
 		'duration'=> 30, //[optional]
 		'probability'=> 15000, //[optional]
  		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true, //[optional]
 	 	"servers"=>$memcache_server
 	));
 	
 	 Cache::config('1day', array(
 		'engine' => 'Memcache', //[required]
  		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true, //[optional],
  	 	'duration'=> '1 Day', //[optional]
 	 	"servers"=>$memcache_server
 	));
 	
 	Cache::config('max', array(
 		'engine' => 'Memcache', //[required]
  		'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
  		'prefix' => 'cake_', //[optional]  prefix every cache file with this string
  		'lock' => false, //[optional]  use file locking
  		'serialize' => true, //[optional],
  	 	'duration'=> '29 Days', //[optional]
 	 	"servers"=>$memcache_server
 	));

 	Cache::config('_cake_core_', array(
 			   'engine' => 'Memcache',
               'duration'=> 3600,
               'probability'=> 10000,
			 	"servers"=>$memcache_server
 	 ));

	Cache::config('default', array(
		'engine' => 'Memcache',
		"servers"=>$memcache_server
	));

?>
