<?php

$engine = "Memcache";

$memcache_servers = array('10.177.5.233:11211');
	
	if(preg_match('/(WEB2VM)|(WEB1)|(admin)/i',php_uname('-n'))) {
		
		$memcache_servers = array('127.0.0.1:11211');	
		
	}
// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
	$duration = '+10 seconds';
}

Cache::config('default', array('engine' => $engine,"servers"=>$memcache_servers));
/**
 * Configure the cache used for general framework caching.  Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
		'engine' => $engine,
		'prefix' => APP_PREFIX . 'cake_core_',
		'path' => CACHE . 'persistent' . DS,
		'serialize' => ($engine === 'File'),
		'duration' => $duration,
		"servers"=>$memcache_servers
));

Cache::config('1min', array(
		'engine' => $engine, //[required]
		'duration'=> 60, //[optional]
		'probability'=> 100000, //[optional]
		'prefix' => APP_PREFIX . '_', //[optional]  prefix every cache file with this string
		'servers' => $memcache_servers,
		'path' => CACHE
));
Cache::config('5min', array(
		'engine' => $engine, //[required]
		'duration'=> "300", //[optional]
		'probability'=> 1000000, //[optional]
		'prefix' => APP_PREFIX . '_', //[optional]  prefix every cache file with this string
		'servers' => $memcache_servers,
		'persistent' => true, // [optional] set this to false for non-persistent connections
		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
));

Cache::config('1day', array(
		'engine' => $engine, //[required]
		'duration'=> "1 Day", //[optional]
		'probability'=> 1000000, //[optional]
		'prefix' => APP_PREFIX . '_', //[optional]  prefix every cache file with this string
		'servers' => $memcache_servers,
		'persistent' => true, // [optional] set this to false for non-persistent connections
		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
));

Cache::config('30sec', array(
		'engine' => $engine, //[required]
		'duration'=> 30, //[optional]
		'probability'=> 1000000, //[optional]
		'prefix' => APP_PREFIX . '_', //[optional]  prefix every cache file with this string
		'servers' => $memcache_servers,
		'persistent' => true, // [optional] set this to false for non-persistent connections
		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
));

Cache::config('max', array(
		'engine' => $engine, //[required]
		'duration'=> '29 Days', //[optional]
		'probability'=> 1000000, //[optional]
		'prefix' => APP_PREFIX . '_', //[optional]  prefix every cache file with this string
		'servers' => $memcache_servers,
		'persistent' => true, // [optional] set this to false for non-persistent connections
		'compress' => false, // [optional] compress data in Memcache (slower, but uses less memory)
));

/**
 * Configure the cache for model and datasource caches.  This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
		'engine' => $engine,
		'prefix' => APP_PREFIX . 'cake_model_',
		'path' => CACHE . 'models' . DS,
		'serialize' => ($engine === 'File'),
		'duration' => $duration,
		"servers"=>$memcache_servers
));

?>