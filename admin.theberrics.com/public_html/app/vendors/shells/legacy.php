<?php

App::import("Vendor","ImgServer",array("file"=>"ImgServer.php"));

class LegacyShell extends Shell {
	
	public $uses = array("MediaFile");
	
	public function main() {
		
		$this->hr();
		$this->out("The Berrics Legacy Media Operations");
		$this->hr();
		
		///let's choose some commands
		$this->out("[1] BrightCove Data Synchronization");
		$this->out("[2]  ");
		
	}
	
	public function limelight() {
		App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));
		$ftp = ftp_connect("berrics.upload.llnw.net");
		
		ftp_login($ftp,"berrics-ht","yteem8");
		
		ftp_pasv($ftp, true);
		
		$files = $this->MediaFile->find("all",array(
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove",
				"MediaFile.limelight_transfer_status"=>0
			),
			"limit"=>700,
			"order"=>array("MediaFile.id"=>"ASC"),
			"contain"=>array()
		));
		$cwd = getcwd();
		
		chdir("/tmp/bc");
		foreach($files as $f) {
			
			$url = $f['MediaFile']['brightcove_url'];
			
			if(strlen($url)<=0) {
				
				$bc_info = BCAPI::instance()->bc->find("videobyid",array("video_id"=>$f['MediaFile']['brightcove_id']));
			
				$url = $bc_info->FLVURL;
				
			}
			
			$file_name = explode("?",$url);
			
			$file_name = $file_name[0];
			
			$ext = pathinfo($file_name,PATHINFO_EXTENSION);
			
			$fn = $f['MediaFile']['id'].".".$ext;
			$this->out("+++++++++++++++++++++");
			$this->out("File:".$fn);
			
			//save the file
			//die("wget {$url} -O ".$f['MediaFile']['id'].".".$ext);
			exec('wget "'.$url.'" -O '.$fn);
			$upload = ftp_put($ftp,$fn,"/tmp/bc/".$fn,FTP_BINARY);
			if($upload) {
				$this->out("File Uploaded Successfully");
				unlink("/tmp/bc/".$fn);
				
				$this->MediaFile->create();
				$this->MediaFile->id = $f['MediaFile']['id'];
				$this->MediaFile->save(array(
					"limelight_file"=>$fn,
					"limelight_transfer_status"=>1
				));
			} else {
				
				$this->out("**ERROR**");
				
			}
			$this->out("+++++++++++++++++++++");
		}
		

		
		ftp_close($ftp);
		
		
	}
	
	public function brightcove_file_migration() {
		
		set_time_limit(0);
		
		
		$conds = array(
				"MediaFile.media_type"=>"bcove",
				"MediaFile.file_video_still"=>NULL
			);
			
			
	
		
		
		//get 100 brightcove posts that do not have any file_video_still populated
		$files = $this->MediaFile->find("all",array(
		
			"conditions"=>$conds,
			"limit"=>500,
			"contain"=>array()
		
		));
		
		
		$cwd = getcwd();
		
		chdir("/home/sites/berrics/img.theberrics.com/public_html/video/stills");
		
		//brightcove API
		App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));
		
		$bc = BCAPI::instance()->bc;
		
		foreach($files as $file) {
			
			$m = $file['MediaFile'];
			
			if($m['brightcove_id']>0) {
				
				
					$bc_info = $bc->find("videobyid",array("video_id"=>$m['brightcove_id']));
			
					$image = $bc_info->videoStillURL;
					
					
					//save the image
				//	die("wget $image -O ".$m['id'].".jpg");
					exec("wget $image -O ".$m['id'].".jpg");
					
					ImgServer::instance()->upload_video_still($m['id'].".jpg","/home/sites/berrics/img.theberrics.com/public_html/video/stills/".$m['id'].".jpg");
					
					//save the info
					$this->MediaFile->create();
					
					$this->MediaFile->id = $m['id'];
					
					$this->MediaFile->save(
						array(
						
							"file_video_still"=>$m['id'].".jpg",
							"brightcove_url"=>$bc_info->FLVURL
						
						)
					);
					
					$this->out("Saved: ".$m['id']);
					
				
			}
			
			
			

			
		}
		
		
		
		
	}
	
	public function stills_check() {
		
		
		//get all the bcove media files
		
		$files = $this->MediaFile->find("all",array(
			
			"conditions"=>array(
				"MediaFile.media_type"=>"bcove"
			),
			"contain"=>array()
		
		));
		
		foreach($files as $v) {
			
			
			//check to see if file exists
			$m = $v['MediaFile'];
			if(!empty($m['file_video_still'])) {
				
				
				if(!file_exists("/home/sites/berrics/img.theberrics.com/public_html/video/stills/".$m['file_video_still'])) {
					
					
					//updat the record
					$this->MediaFile->create();
					
					$this->MediaFile->id = $m['id'];
					
					
					$this->MediaFile->save(
						array(
						
							"file_video_still"=>NULL
						
						)
					);
					
					$this->out("File Not Found");
				
				}
				
				
			}
			
			
		}
		
		
		
	}
	
	
	
}


?>