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
			"video"=>"Video (?? new CDN???)",
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
	
	
	

}
