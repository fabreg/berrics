<?php 

App::uses("LocalAppController","Controller");

class MediaServiceController extends LocalAppController {


	public $uses = array(
		"MediaFile",
		"OndemandTitle",
		"Dailyop"
	);


	public function beforeFilter() {

		parent::beforeFilter();

		$this->Auth->allow();

		$this->initPermissions();

	}


	public function video_player_request() {
		
		$this->skip_page_view = true;

		$this->layout = "ajax";

		$data = array();

		$media_file_id = (isset($this->request->data['media_file_id'])) ? 
				$this->request->data['media_file_id']:'4d6ed946-4d48-4735-8272-37a20ab5431b';

		$MediaFile = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$media_file_id
			),
			"contain"=>array()
		));

		$handheld = false;

		if(		
				$this->request->is('mobile') && 
				preg_match('/(iPhone|iPod)/',$_SERVER['HTTP_USER_AGENT']) ||
				isset($_GET['handheld'])
			) {

			$handheld = false;

		}


		if(isset($this->request->data['dailyop_id'])) {

			$Post = $this->Dailyop->find("first",array(
						"fields"=>array(
							"Dailyop.id",
							"Dailyop.name",
							"Dailyop.sub_title",
							"Dailyop.uri",
							"DailyopSection.name",
							"DailyopSection.uri"
						),
						"conditions"=>array(
							"Dailyop.id"=>$this->request->data['dailyop_id']
						),
						"contain"=>array(
							"DailyopSection"
						)

					));

		}

		if(!empty($MediaFile['MediaFile']['preroll_label'])) {

			if($handheld) {

				$data[]['AdUrl'] = 'http://pubads.g.doubleclick.net/gampad/ads?sz=320x180&iu=/5885/MVPRE001&ciu_szs&impl=s&gdfp_req=1&env=vp&output=xml_vast2&unviewed_position_start=1&url=[referrer_url]&correlator=[timestamp]';

			} else {

				$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['preroll_label']);

			}

			

		}

		$d['MediaFile'] =  $MediaFile['MediaFile'];
		if(isset($Post)) $d['Dailyop'] = $Post;
		if($handheld && !empty($d['MediaFile']['limelight_file_mobile'])) $d['MediaFile']['limelight_file'] = $d['MediaFile']['limelight_file_mobile'];

		$data[] = $d;

		if(!empty($MediaFile['MediaFile']['postroll_label'])) {

			$data[]['AdUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['postroll_label']);

		}

		$this->insertMediaHit($MediaFile['MediaFile']['id']);

		$this->set(compact("data"));

	}

	public function video_player_requestv2() {
		
		$this->skip_page_view = true;

		$this->layout = "ajax";

		$data = array();

		$data['playlist'] = array();

		$media_file_id = (isset($this->request->params['named']['media_file_id'])) ? 
				$this->request->params['named']['media_file_id']:'4d6ed946-4d48-4735-8272-37a20ab5431b';

		$MediaFile = $this->MediaFile->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$media_file_id
			),
			"contain"=>array()
		));

		$handheld = false;

		if(
				$this->request->is('mobile') && 
				preg_match('/(iPhone|iPod)/',$_SERVER['HTTP_USER_AGENT']) || 
				isset($_GET['handheld'])
			) {

			$handheld = false;

		}


		if(isset($this->request->params['named']['dailyop_id'])) {

			$Post = $this->Dailyop->find("first",array(
						"fields"=>array(
							"Dailyop.id",
							"Dailyop.name",
							"Dailyop.sub_title",
							"Dailyop.uri",
							"DailyopSection.name",
							"DailyopSection.uri"
						),
						"conditions"=>array(
							"Dailyop.id"=>$this->request->params['named']['dailyop_id']
						),
						"contain"=>array(
							"DailyopSection"
						)

					));

		}

		if(!empty($MediaFile['MediaFile']['preroll_label'])) {

			$data['playlist'][]['prerollUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['preroll_label']);
		
		}

		unset($MediaFile['MediaFile']['created'],$MediaFile['MediaFile']['modified']);
		$MediaFile['MediaFile']['jw_url'] = $MediaFile['MediaFile']['file_url'] = "http://berrics.vo.llnwd.net/o45/".$MediaFile['MediaFile']['limelight_file'];
		$data['playlist'][] = array(

			"Video"=>array(
				"MediaFile"=>$MediaFile['MediaFile'],
				'Dailyop'=> (isset($Post['Dailyop']['id'])) ? false:$Post['Dailyop']
			)

		);

		if(!empty($MediaFile['MediaFile']['postroll_label'])) {

			$data['playlist'][]['postrollUrl'] = MediaFile::formatVastUrl($MediaFile['MediaFile']['postroll_label']);

		}

		$this->insertMediaHit($MediaFile['MediaFile']['id']);

		$this->set(compact("data"));

		die(json_encode($data['playlist']));

	}

	public function video_player_requestv3($recordHit = false) {

		$this->skip_page_view = true;

		$this->layout = "ajax";

		$data = array();

		$data['playlist'] = array();

		if(count($this->request->params['named'])>0) $this->request->data = $this->request->params['named'];

		$media_file_id = (isset($this->request->data['media_file_id'])) ? 
				$this->request->data['media_file_id']:'4d6ed946-4d48-4735-8272-37a20ab5431b';

		$dailyop_id = (isset($this->request->data['dailyop_id'])) ? 
				$this->request->data['dailyop_id']:'2520';

		$videos = array();

		//die(print_r($this->request->data));

		//playlist index
		$i = 1;

		$request = array();

		if (isset($_REQUEST['ondemand_title_id'])) {
			
			$videos = $this->OndemandTitle->returnTitleMediaVO($_REQUEST['ondemand_title_id']);
			
			
		} else {
			
			$videos[$i] = $this->MediaFile->returnVideoVO($media_file_id,$dailyop_id);
			$request['start_pos'] = 1;
		}
		
		

		//hardset some values
		

		$request['playlist'] = $videos;

		if($recordHit) $this->insertMediaHit($media_file_id);

		die(json_encode($request));

	}

	public function beacon($media_file_id) {
		
		$this->insertMediaHit($media_file_id);
		die(1);
	}

	public function next_ondemand_post($dailyop_id) {

		$post = $this->Dailyop->returnPost(array("Dailyop.id"=>$dailyop_id),1);
		
		$next = $this->Dailyop->find("first",array(
					"conditions"=>array(
						"Dailyop.ondemand_title_id"=>$post['Dailyop']['ondemand_title_id'],
						"Dailyop.display_weight >"=>$post['Dailyop']['display_weight']
					),
					"contain"=>array(
						"DailyopSection"
					),
					"order"=>array("Dailyop.display_weight"=>"ASC")
				));

		die(json_encode($next));

	}


	public function end() {
		
		$token = "video-end-".md5(serialize($this->request->params['named']));

		$this->loadModel('Dailyop');

		$post = $this->Dailyop->returnPost(array(
					"Dailyop.id"=>$this->request->params['named']['dailyop_id']
				));

		$posts = $this->Dailyop->getRelatedItems($post,array(),true);
		//$posts = $this->Dailyop->postViewRelated($post,true);

		if(count($posts)<=0) {

			$posts = $this->Dailyop->getRecentPostsByPost($post);

		}

		$this->set(compact("posts","post"));
		
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