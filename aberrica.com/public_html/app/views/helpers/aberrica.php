<?php

class AberricaHelper extends AppHelper {
	
	public $helpers = array("Html","Media");
	
	public function articleLink($article,$label,$options = array()) {
		
		$link = "/".date("Y",strtotime($article['publish_date']))."/".date("m",strtotime($article['publish_date']))."/".date("d",strtotime($article['publish_date']))."/".$article['uri'];
		
		$link = $this->Html->link($label,$link,$options);
		
		return $link;
		
	}
	
	public function articleParagraphThumb($paragraph) {
		
		$mediaFile = $paragraph['MediaFile'];
		
		$thumb = $this->Media->mediaThumb(array(
		
			"MediaFile"=>$mediaFile,
			"w"=>$paragraph['media_width'],
			"h"=>$paragraph['media_height'],
			"zc"=>$paragraph['media_zc']	
		
		));
		
		$direction = $paragraph['media_align'];
		
		$img = "<div class='article-thumb {$direction}'>{$thumb}</div>";
		
		return $img;
		
	}
	
	
}

?>