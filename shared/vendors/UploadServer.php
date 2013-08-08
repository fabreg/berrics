<?php

class UploadServer {
	
	
	private $sftp = false;
	
	public function __construct() {
		
		$oldPath = set_include_path("/home/sites/berrics.v3/shared/vendors/phpseclib");
		
		App::import("Vendor","SFTP",array("file"=>"phpseclib/Net/SFTP.php"));
		
		set_include_path($oldPath);
		
		$uname = php_uname('n');
		
		switch($uname) {
			
			case "WEB2VM":
				$this->sftp = new Net_SFTP('54.213.130.5');
			break;
			default:
				$this->sftp = new Net_SFTP('172.31.26.63');
			break;
			
		}
		
		//login to the server
		if(!$this->sftp->login('uploader','19Berrics82')) {
			
			throw new UploadServerException("Failed To Connect To Uploading Server");
			
		}
		
	}
	/**
	 * 
	 * @param $file $_FILES Array of the upload
	 * @return unknown_type
	 */
	public function moveUpload($file = false) {
		
		if(!is_uploaded_file($file['tmp_name'])) return false;
		
		//move to the temp dir
		$tmp_path = TMP.$file['name'];
		
		if(move_uploaded_file($file['tmp_name'],$tmp_path)) return $tmp_path;
		
		return false;
		
	}
	
	public function pushUpload($full_tmp_path = false,$file_name = false) {
		
		$this->sftp->chdir("/home/uploads/");
		
		if($this->sftp->put($file_name,$full_tmp_path,NET_SFTP_LOCAL_FILE)) {
			
			unlink($full_tmp_path);
			return true;
			
		} 
		
		return false;
		
	}
	
	public function __destruct() {
		
		$this->sftp->disconnect();
		
	}
	
	
}
class UploadServerException extends Exception {}