<?php

App::import("Vendor","InstagramBase",array("file"=>"instagram/Instagram.php"));


class InstagramApi {
	
	
	public static $conf = array(
        'client_id' => '6043dfac97d04a55a4f7b400994c302d',
        'client_secret' => '928a9fc2a9af4e579eb00a33a1370b2c',
        'grant_type' => 'authorization_code',
        'redirect_uri' => 'http://theberrics.com/identity/login/handle_instagram_callback'
     );
     
     public static $berrics_access_token = '5828832.6043dfa.02175a8a5986444eb0ca3d3e2d0652d5';
     									
     										
     public static $berrics_id = '5828832';
     
     public static $access_token = false;
     
     public static $instance = false;
     
     public  $instagram = false;
     
     private function __construct() {
     	     	
     	//self::$conf['redirect_uri'] = urlencode(self::$conf['redirect_uri']);

     	$this->instagram = new Instagram(self::$conf);
     	
     }
     
     public static function instance() {
     	
     	if(!self::$instance) {
     		
     		self::$instance = new self();
     	
     	}
     	
     	return self::$instance;
     	
     }
     
     public static function berricsInstance() {
     	
     	
     	self::instance()->instagram->setAccessToken(self::$berrics_access_token);
     	
     	return self::$instance;
     	
     	
     }
     
     public static function userInstance($token) {
     	
     	self::instance()->instagram->setAccessToken($token);
     	
     	return self::$instance;
     	
     }
     
     
     
     
   
}




?>