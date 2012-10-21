<?php

class LLFTP {
	
	private $conn = false;
	private $un = "berrics-ht";
	private $pw = "yteem8";
	public $domain = "berrics.upload.llnw.net";
	
	public function __construct() {
		
		
	}
	
	public function connect() {
		
		if(!$this->conn) { 
		
			$this->conn = ftp_connect($this->domain);
		
			ftp_login($this->conn,$this->un,$this->pw);
			
			ftp_pasv($this->conn,true);
			
		}
		
	}
	
	public function close() {
		
		if($this->conn) return ftp_close($this->conn);
		
	}
	
	public function ftpFile($file_name,$tmp_path) {
		
		
		$this->connect();
		
		$upload = ftp_put($this->conn,$file_name,$tmp_path,FTP_BINARY);
		
		$this->close(); 
		
		return $upload;
		
	}
	
	
	private function checkFileExists() {
		
		
		
	}
	
	private function renameFileRevision() {
		
		
		
	}
	
	
	
}