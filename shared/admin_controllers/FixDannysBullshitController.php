<?php

App::import("Controller","LocalApp");
App::import("Vendors","BCAPI",array("file"=>"bc_api.php"));

class FixDannysBullshitController extends LocalAppController {
	
	
	public $uses = array();
	
	public function beforeFilter() {
		
		parent::beforeFilter();
		
		$this->initPermissions();
		
	}
	
	
	
	public function check_swf_files() {
		
		set_time_limit(0);
		
		$this->loadModel("MediaFile");
		
		//get all the SWF file instances
		
		$swfs = $this->MediaFile->find("all",array(
		
			"conditions"=>array(
				"MediaFile.media_type"=>"flash",
				"MediaFile.process_flv !="=>1
			),
			"contain"=>array(),
			"limit"=>25
			
		));
		
		////////////////
		$flv_path = "/home/sites/flv.master/";
		
		$i = 1;
		
		foreach($swfs as $swf) {
			
			$this->MediaFile->create();
			$this->MediaFile->id = $swf['MediaFile']['id'];
			
			echo "<br />";
			if(($flv_file = $this->locate_flv_file($swf['MediaFile']['file'])) === false) {
				
				echo "NOT FOUND";
				$this->MediaFile->save(array(
				
					
					"process_flv"=>1
				
				));
			} else {
				
				echo "FOUND ({$i}): ".$flv_file;
				
				//send over the file	
				$bc_id = $this->send_to_bc($flv_path.$flv_file);
				
				//update the video file entry
				
				
				$this->MediaFile->save(array(
				
					"brightcove_id"=>$bc_id,
					"process_flv"=>1,
					"media_type"=>"bcove"
				
				));
				
				
				
				$i++;
				
			}

		}
		
		die("<br />Stopped");
		
	}
	
	
	private function locate_flv_file($swf_file) {
		
		$flv_path = "/home/sites/flv.master/";
		
		//replace .swf extension with the .flv extension
		
		$flv_file = str_replace(".swf",".flv",$swf_file);
		
		$flv_file = str_replace("swf/","",$flv_file);
		
		//check to see if the file exists
		
		if(file_exists($flv_path.$flv_file)) {
			
			
			return $flv_file;
			
		}
		
		return false;
		
	}
	
	
	private function send_to_bc($file) {
		
		$bc = BCAPI::instance();
		
		try {
			
			$bc_id = $bc->bc->createMedia("video",$file,array(
				
					"name"=>$this->request->data['MediaFile']['name'],
					"H264NoProcessing"=>TRUE
				
				));
			
		}
		catch(BCMAPIException $e) {
			
			die(print_r($e));
			
		}
		
		return $bc_id;
		
	}
	
	
}


?>