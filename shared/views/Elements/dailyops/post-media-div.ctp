<?php 

if(!is_array($opts)) $opts = array();

$template = $Dailyop['Dailyop']['post_template'];

if(isset($opts['MediaFile'])) {

	$MediaFile = $opts['MediaFile'];
	unset($opts['MediaFile']);

} else {

	$MediaFile = $Dailyop['DailyopMediaItem'][0]['MediaFile'];

}


$opts = array_merge(array(
			"data-media-file-id"=>$MediaFile['id'],
			"data-dailyop-id"=>$Dailyop['Dailyop']['id'],
			"data-dailyop-section-id"=>$Dailyop['Dailyop']['dailyop_section_id'],
			"data-media-type"=>$MediaFile['media_type'],
			"data-slide-show"=>$Dailyop['Dailyop']['slide_show'],
			"data-platform"=>$platform,
			"data-dailyop-display-weight"=>1,//$Dailyop['Dailyop']['display_weight'],
			"class"=>"post-media-div",
			"id"=>"media-file-div-".$MediaFile['id']
		),$opts);

$html = "Nothing";

switch($MediaFile['media_type']) {

	case "img":
		$html = $this->Media->mediaThumb(array(

			"MediaFile"=>$MediaFile,
			"w"=>700

		));

		if(!empty($Dailyop['Dailyop']['url'])) {

			$link_ops = array(
				"href"=>$Dailyop['Dailyop']['url']
			);

			if(!empty($Dailyop['Dailyop']['window_target'])) {

				$link_ops['target'] = $Dailyop['Dailyop']['window_target'];

			}
				

			$html = $this->Html->tag("a",$html,$link_ops);

		}

	break;
	case "bcove": //video file
		
		App::import("Vendor","Mobile_Detect",array("file"=>"Mobile_Detect.php"));

		$MobileDetect = new Mobile_Detect();

		if($MobileDetect->isMobile()) {

			$html = $this->element("dailyops/video/html5",compact("MediaFile","Dailyop","opts"));

		} else {



		}

		$html = $this->element("dailyops/video/html5",compact("MediaFile","Dailyop","opts"));

		

	break;

}

echo $this->Html->tag("div",$html,$opts);

?>