<?php

class ImgServer {
	
	public static $instance = false;
	public static $connected = false;
	public $sftp = false;
	
	private function __construct() {
		
		$oldPath = set_include_path("/home/sites/berrics.v3/shared/vendors/phpseclib");
		
		App::import("Vendor","SFTP",array("file"=>"phpseclib/Net/SFTP.php"));
		
		set_include_path($oldPath);
		
		$uname = php_uname('n');
		
		switch($uname) {
			
			case "WEB2VM":
				$this->sftp = new Net_SFTP('50.56.79.100');
			break;
			default:
				$this->sftp = new Net_SFTP('10.181.80.17');
			break;
			
		}
		
		
		
	}
	
	public static function instance() {
		
		if(!self::$instance) {
			
			self::$instance = new self();
			
		}
		
		return self::$instance;
		
	}
	
	public function connect() {
		
		if(!$this->sftp->login('root','WEB2B7eMsiJ43')) {
			
			die("Failed to connect to img.theberrics.com");
			
		} else {
			
			self::$connected = true;
			
		}
		
	}
	
	public function close() {
		
		$this->sftp->disconnect();
		
	}
	
	public function upload_video_still($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/video/stills");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}

	public function upload_video_still_slim($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/video/stills-slim");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}

	public function upload_video_still_large($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/video/stills-large");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_image_file($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/images");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_icon_file($file_name,$file_path,$auto_connect = true) {
		
		if($auto_connect) {
			
			$this->connect();
			
		}
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/berrics-icons");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		if($auto_connect) { 
			
			$this->close();
			
		}
		
	}
	
	public function upload_swf_file($file_name, $file_path) {
		
		
		
	}
	
	public function upload_brand_logo($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/brand-logos");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_unified_logo($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/unified-logos");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_ondemand_cover($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/ondemand-titles");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	
	public function upload_bangyoself_entry($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/bang-yoself");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	public function upload_product_image($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/product-img");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	public function delete_product_image($file_name) {
		
		$this->connect();
		
		$this->sftp->delete("/home/sites/berrics.static/img.theberrics.com/public_html/product-img/".$file_name);
		
		$this->close();
		
	}
	
	public function upload_profile_image($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/profile-img");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_canteen_brand_logo($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/brand-logos");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_canteen_promo_icon($file_name, $file_path) {
		
		$this->connect();
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/canteen-promo-icons");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		$this->close();
		
	}
	
	public function upload_shipping_label($file_name, $file_path) {
		
		if(!self::$connected) { $this->connect();  }
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/shipping");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		//$this->close();
		
	}
	
	public function upload_tmp_file($file_name,$file_path) {
		
		if(!self::$connected) {
			$this->connect();
		}
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/tmp");
		
		$this->sftp->put($file_name,$file_path,NET_SFTP_LOCAL_FILE);
		
		return $file_name;
		
	}
	
	public function move_tmp_file($file_name,$new_path) {
		
		if(!self::$connected) {
			$this->connect();
		}
		
		$base_path = "/home/sites/berrics.static/img.theberrics.com/public_html/";
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html/tmp");
		
		$new_path = $base_path.$new_path;
		
		$this->sftp->rename($file_name,$new_path."/".$file_name);
		
		
	}
	
	public function delete_file($file) {
		
		if(!self::$connected) {
			$this->connect();
		}
		
		$this->sftp->chdir("/home/sites/berrics.static/img.theberrics.com/public_html");
		
		$this->sftp->delete($file);
		
	}

	
	
}
