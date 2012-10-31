<?php

App::import("Controller","LocalApp");
App::import("Vendor","BCAPI",array("file"=>"bc_api.php"));


class MediaController extends LocalAppController {
	
	public $uses = array();
	
	private $limelight_uri = 'http://berrics.vo.llnwd.net/o45/';
	
	
	public function beforeFilter() {
		
		//catch json post
		if(isset($this->request->data['json'])) $this->request->params['named'] = json_decode($this->request->data['json'],true);
		

		parent::beforeFilter();
		$this->initPermissions();
		$this->Auth->allow("*");
		
		
	}
	
	
	public function ajax_video($id) {
		
		$this->loadModel("MediaFile");
		
		$m = $this->MediaFile->find("first",array(
		
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		
		));
		
		$m = $m['MediaFile'];
		if($m['media_type'] == 'bcove' && $m['limelight_transfer_status'] == 1 && $m['limelight_active'] == 1) {
			
			$m['brightcove_url'] = $this->limelight_uri.$m['limelight_file'];
			
		} elseif($m['media_type'] == 'bcove' && empty($m['brightcove_url'])) {
			
			$bc_info = BCAPI::instance()->bc->find("videobyid",array("video_id"=>$m['brightcove_id']));
			
			$m['brightcove_url'] = $bc_info->FLVURL;

		}
		
		
		$this->set(compact("m"));
		
	}
	
	public function json_file_request($id = false) {
		
		$this->loadModel("MediaFile");
		
		$m = $this->MediaFile->find("first",array(
		
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		
		));
		
		
		
		$m = $m['MediaFile'];

		$m['brightcove_url'] = $this->limelight_uri.$m['limelight_file'];

		/*
		
		if($m['media_type'] == 'bcove' && $m['limelight_transfer_status'] == 1 && $m['limelight_active'] == 1) {
			
			
			
		} elseif($m['media_type'] == 'bcove' && empty($m['brightcove_url'])) {
			
			$bc_info = BCAPI::instance()->bc->find("videobyid",array("video_id"=>$m['brightcove_id']));
			
			$m['brightcove_url'] = $bc_info->FLVURL;
			
			$this->MediaFile->id = $m['id'];
			
			$this->MediaFile->save(array(
			
				"brightcove_url"=>$m['brightcove_url']
			
			));
			
		}
		*/
		
		$this->insertMediaHit($m['id']);
		
		//die(json_encode($m));
		
		$this->layout = "ajax";
		
		$this->set(compact("m"));
		
		return $m;
		
	}
	
	public function embed($id,$height,$width) {
		$this->loadModel("MediaFile");
		//get the video
		$media = $this->MediaFile->find("first",array(
		
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		
		));
		
		$this->layout = 'js/js';
		
		$this->set(compact("media","height","width"));
		
	}
	
	
	public function json_related_videos($id = false) {
		
		
		$this->loadModel("MediaFile");
		
		$m = $this->MediaFile->find("first",array(
		
				"conditions"=>array(
					"MediaFile.id"=>$id
				),
				"contain"=>array("Tag")
			
			));
		
		die(pr($m));

		
	}
	
	
	public function json_video_tag($id) {
		
		$ads = Arr::videoAdUrls();
		$m = $this->json_file_request($id);
		
		$pre = false;
		$post = false;
		
		if(array_key_exists($m['preroll'],$ads)) {
			
			$pre = $this->adRequest($ads[$m['preroll']]);
			
		}
		
		if(array_key_exists($m['postroll'],$ads)) {
			
			$post = $this->adRequest($ads[$m['postroll']]);
			
		}
		
		$this->set(compact("pre","post"));
		
		
	}
	
	private function adRequest($url) {
		
		App::import("Lib","Xml");
		
		$ad = false;

		
		
	}
	
	public function json_video_service() {
		
		$this->skip_page_view = true;
		$this->layout = "ajax";

		$data = array();
		
		//media file
		if(isset($this->request->params['named']['media_file_id'])) {
			
			$this->loadModel("MediaFile");
			
			$video = $this->MediaFile->find("first",array(
			
				"conditions"=>array(
				
					"MediaFile.id"=>$this->request->params['named']['media_file_id']
			
				),
				"contain"=>array()
			
			));
			
			
			$data += $video;
			
			$this->insertMediaHit($video['MediaFile']['id']);
			
		}
		
		
		
		//dailyops post
		if(isset($this->request->params['named']['dailyop_id'])) {
			
			$this->loadModel("Dailyop");
			
			$d = $this->Dailyop->find("first",array(
			
				"conditions"=>array(
					"Dailyop.id"=>$this->request->params['named']['dailyop_id']
				),
				"contain"=>array(
					"DailyopSection"
				)
			
			));
			
			$data += $d;
			
		}
		

		$this->set(compact("data"));
		
	}
	
	public function request_html_video($id) {
		
		$this->loadModel("MediaFile");
		
		$video = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		));
		
		$this->insertMediaHit($id);
		
		$video['MediaFile']['limelight_file'] = $this->limelight_uri.$video['MediaFile']['limelight_file'];
		
		$video['MediaFile'] = MediaFile::formatVideoAdUrls($video['MediaFile']);
		
		die(json_encode($video));
		
	}
	
	private function insertMediaHit($id) {
		
		
		$this->loadModel('MediaFileView');
		
		$mobile = false;
		
		if($this->RequestHandler->isMobile()) {
			
			$mobile = true;
			
		}
		
		$data = array();	
		$data["geo_country"]=(isset($_SERVER['GEOIP_COUNTRY_CODE'])) ? $_SERVER['GEOIP_COUNTRY_CODE']:NULL;
		$data["geo_region"]=(isset($_SERVER['GEOIP_REGION'])) ? $_SERVER['GEOIP_REGION']:NULL;
		$data["geo_region_name"]=(isset($_SERVER['GEOIP_REGION_NAME'])) ? $_SERVER['GEOIP_REGION_NAME']:NULL;
		$data["geo_dma_code"]=(isset($_SERVER['GEOIP_DMA_CODE'])) ? $_SERVER['GEOIP_DMA_CODE']:NULL;
		$data["geo_postal_code"]=(isset($_SERVER['GEOIP_POSTAL_CODE'])) ? $_SERVER['GEOIP_POSTAL_CODE']:NULL;
		$data["geo_city"]=(isset($_SERVER['GEOIP_CITY'])) ? $_SERVER['GEOIP_CITY']:NULL;
		$data["ip_address"]=$_SERVER['GEOIP_ADDR'];
		$data["mobile"] = $mobile;
		$data['media_file_id'] = $id;
		
		$this->MediaFileView->save($data);
		
	}
	
	
}


?>