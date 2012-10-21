<?php

//we need a video URL

$video_url = '';

switch($MediaFile['media_type']) {
	
	case "bcove":
		$video_url = $MediaFile['brightcove_url'];
		
		if(empty($video_url)) {
			
			//we gotta do an API call to brightcove to ge the URL
			
			$bc = BCAPI::instance();
			
			$bc_data = $bc->bc->find("videobyid",array("video_id"=>$MediaFile['brightcove_id']));
			
			$video_url = $bc_data->FLVURL;
			
			die(pr($bc_data));
			
		}
	break;
	
}
?>
<div class='dops-video-div' video_url='<?php echo $video_url; ?>'>
	

</div>