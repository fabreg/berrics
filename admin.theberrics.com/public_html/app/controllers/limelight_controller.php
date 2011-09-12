<?php

App::import("Controller","AdminApp");

class LimelightController extends AdminAppController {
	
	public $uses = array("MediaFile");
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	public function index() {
		
		//get the total amount of videos
		$videoCount = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove")));
		
		//get the total amount of videos that have been transfered to limelight
		$llnwCount = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove","limelight_transfer_status"=>1)));
		
		//get the total amount of videos that are active on limelight
		$llnwLive = $this->MediaFile->find("count",array("conditions"=>array("MediaFile.media_type"=>"bcove","limelight_active"=>1)));
		
		$this->set(compact("videoCount","llnwCount","llnwLive"));
		
	}
	
	public function transfer_file() {
		
		$ftp = ftp_connect("berrics.upload.llnw.net");
		
		ftp_login($ftp,"berrics-ht","yteem8");
		
		ftp_pasv($ftp, true);
		
		$files = $this->MediaFile->find("all",array(
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove",
				"MediaFile.limelight_transfer_status"=>0
			),
			"limit"=>10,
			"order"=>array("MediaFile.id"=>"ASC"),
			"contain"=>array()
		));
		$cwd = getcwd();
		
		chdir("/tmp/bc");
		foreach($files as $f) {
			
			$url = $f['MediaFile']['brightcove_url'];
			
			$file_name = explode("?",$url);
			
			$file_name = $file_name[0];
			
			$ext = pathinfo($file_name,PATHINFO_EXTENSION);
			
			$fn = $f['MediaFile']['id'].".".$ext;
			
			//save the file
			//die("wget {$url} -O ".$f['MediaFile']['id'].".".$ext);
			exec('wget "'.$url.'" -O '.$fn);
			
			if(ftp_put($ftp,$fn,"/tmp/bc/".$fn,FTP_BINARY)) {
			
				unlink("/tmp/bc/".$fn);
				
				$this->MediaFile->create();
				$this->MediaFile->id = $f['MediaFile']['id'];
				$this->MediaFile->save(array(
					"limelight_file"=>$fn,
					"limelight_transfer_status"=>1
				));
			}
			
		}
		

		
		ftp_close($ftp);
		
	}
	
}