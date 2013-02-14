<?php
class MediaFile extends AppModel {
	
	/**
	 * Limelight Media Vault Cypher Hash
	 * @var string
	 */
	public static $mv_hash = "yzJiEzNqFAfu6";
	
	
	/**
	 * LimeLight Media Vault URL
	 * @var string
	 */
	public static $mv_url = "http://berrics.vo.llnwd.net/o45/s/";

	public static $ll_url = "http://berrics.vo.llnwd.net/o45/";

	public static $dfp_vast_url = "http://pubads.g.doubleclick.net/gampad/ads?sz=700x394&iu=/5885/#LABEL#&ciu_szs&impl=s&gdfp_req=1&env=vp&output=xml_vast2&unviewed_position_start=1&url=[referrer_url]&correlator=[timestamp]";
	
	var $name = 'MediaFile';
	
	

	var $belongsTo = array(
		"Website"
	);
	
	

	var $hasMany = array(
		
		'MediaFileView' => array(
			'className' => 'MediaFileView',
			'foreignKey' => 'media_file_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		"DailyopMediaItem"
	);


	var $hasAndBelongsToMany = array(
	
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'media_files_tags',
			'foreignKey' => 'media_file_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		),
		"User"
	);
	/**
	 * All media types and aliases
	 * @return Array
	 */
	static function mediaFileTypes() {
		
		$a = array(
		
			"bcove"=>"Video (LimeLight CDN)",
			//"video"=>"Video (?? new CDN???)",
			"img"=>"Image File (Berrics CDN)",
			"flash"=>" SWF File",
			"piclink"=>"Image w/ Anchor (Legacy)",
			"pic"=>"Image (Legacy)"
		
		);
		
		
		return $a;
		
		
	}

	
	public function returnMediaFile($cond = array(),$isAdmin = false) {
		
		
		
		$this->find("first",array(
		
			""	
		
		));
		
		
		
	}
	
	public static function formatVideoAdUrls($m = array()) {
		
		$urls = Arr::adLabelUrls();
		$preroll = false;
		$postroll = false;
		
		//preroll stuff
		if(!empty($m['preroll_label'])) {
			
			$m['preroll'] = str_replace("#LABEL#",$m['preroll_label'],$urls['preroll']);
			$preroll = true;
		}
		
		if(!empty($m['preroll_label_override'])) {
			
			$m['preroll'] = str_replace("#LABEL#",$m['preroll_label_override'],$urls['preroll']);
			$preroll = true;
		}
		
		//post roll stuff
		if(!empty($m['postroll_label'])) {
			
			$m['postroll'] = str_replace("#LABEL#",$m['postroll_label'],$urls['postroll']);
			$postroll = true;
		}
		
		if(!empty($m['postroll_label_override'])) {
			
			$m['postroll'] = str_replace("#LABEL#",$m['postroll_label_override'],$urls['postroll']);
			$postroll = true;
		}
		//$preroll = false;
		if(!$preroll) {
			
			$m['preroll'] = '';
			
		} 
		
		if(!$postroll) {
			
			$m['postroll'] = '';
			
		} 
		
		$m['preroll'] = str_replace("#TAGS#",$m['preroll_tags'],$m['preroll']);
		$m['postroll'] = str_replace("#TAGS#",$m['postroll_tags'],$m['postroll']);
		
		return $m;
		
	}
	
	
	public static function returnSecureUrl($MediaFile = array(),$ttl = 30) {
		
		if(
			!isset($MediaFile['id']) || 
			!isset($MediaFile['limelight_file']) ||
			($MediaFile['limelight_mediavault_active']!=1)
		) {
			
			throw new Exception("[LLMediaVault::returnSecureUrl()]:Invalid Media File");
			
		}
		
		//30 seconds in the future
		$time = strtotime("+{$ttl} Seconds");
		
		$url = self::$mv_url.$MediaFile['limelight_file']."?e=".$time;
		
		$hash = md5(self::$mv_hash.$url);
		
		return $url."&h=".$hash;
		
	}

	public function downloadVideoToTmp($id = false) {
		
		$file = $this->find("first",array(
			"conditions"=>array(
				"MediaFile.id"=>$id
			),
			"contain"=>array()
		));

		$file_dl = self::$ll_url.$file['MediaFile']['limelight_file'];

		if(!file_exists("/home/sites/tmpfiles/".$file['MediaFile']['limelight_file'])) {

			$output = passthru("curl {$file_dl} > '/home/sites/tmpfiles/{$file['MediaFile']['limelight_file']}'");

		}

		return "/home/sites/tmpfiles/".$file['MediaFile']['limelight_file'];

	}
	/**
	 * Return Video VO
	 * Returns a videoVO object that has an ad scedule attached to it
	 * for double click advertising API's
	 */
	public function returnVideoVO($id = false,$dailyop_id = false) {
		
		$token = "videoVO-".$id;

		if(($data = Cache::read($token,"1min")) === false) {

			$video = $this->find("first",array(
						"fields"=>array(
							"MediaFile.id","MediaFile.limelight_file","MediaFile.limelight_file_ogv","MediaFile.limelight_file_mobile",
							"MediaFile.file_video_still","MediaFile.preroll_label","MediaFile.postroll_label","MediaFile.preroll_label_override",
							"MediaFile.postroll_label_override","MediaFile.name"
						),
						"conditions"=>array(
							"MediaFile.id"=>$id
						),
						"contain"=>array()

					));

			//get the ad units that are in-scope
			$preRollUnit = $video['MediaFile']['preroll_label_override'];

			if(empty($preRollUnit) && !empty($video['MediaFile']['preroll_label'])) $preRollUnit = $video['MediaFile']['preroll_label'];

			$postRollUnit = $video['MediaFile']['postroll_label_override'];

			if(empty($postRollUnit) && !empty($video['MediaFile']['postroll_label'])) $postRollUnit = $video['MediaFile']['postroll_label'];


			//make the data object to return

			$data['MediaFile'] = $video['MediaFile'];
			$data['Ads'] = array();

			if(!empty($preRollUnit)) $data['Ads']['preroll'] = self::formatVastUrl($preRollUnit);
			//if(!empty($preRollUnit)) $data['Ads']['postroll'] = self::formatVastUrl($preRollUnit);
			//if(!empty($postRollUnit)) $data['Ads']['postroll'] = self::formatVastUrl($postRollUnit);

			if($dailyop_id) {

				$data['Dailyop'] = $this->DailyopMediaItem->Dailyop->find("first",array(
						"fields"=>array(
							"Dailyop.id","Dailyop.name","Dailyop.sub_title","Dailyop.uri",
							"DailyopSection.name","DailyopSection.uri"
						),
						"conditions"=>array(
							"Dailyop.id"=>$dailyop_id
						),
						"contain"=>array(
							"DailyopSection"
						)
					));

			}

			Cache::write($token,$data,"1min");

		}

		return $data;

	}

	public static function formatVastUrl($label = false, $tags = false) {
		
		$url = self::$dfp_vast_url;

		if($label) $url = str_replace("#LABEL#","".$label,$url);

		return $url;

	}

	
	
	

}
