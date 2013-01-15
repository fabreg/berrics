<?php 
//lets use the media help and get some html for the interface

$img_html = $this->Media->mediaThumb(array(
	"MediaFile"=>$data['MediaFile'],
	"w"=>700,
	"h"=>400,
	"zc"=>1
),array("display_weight"=>$data['DailyopMediaItem']['display_weight']));

//inject the html into the json output
$data['MediaFile']['file_html'] = $img_html;

echo json_encode($data);

?>