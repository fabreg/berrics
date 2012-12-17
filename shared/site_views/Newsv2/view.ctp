<?php 

//css file
$this->Html->css(array("v3/article-view"),"stylesheet",array("inline"=>false));
//js file
$this->Html->script(array("v3/article-view"),array("inline"=>false));

$url = "/".$post['DailyopSection']['uri']."/".$post['Dailyop']['uri'];

if($post['Dailyop']['uri'] == "moose-gets-recruited.html") {
	
	$url = "/recruit/moose.html";
	
} else if ($post['Dailyop']['uri'] == "gatorade-chaz-ortiz.html") {
	
	$url = '/gen-ops/go-all-day.html';
	
} else if ($post['Dailyop']['uri'] == "powell-united-nations.html") {
	
	$url = '/united-nations/powell-peralta.html';
	
} else if($post['Dailyop']['uri'] == "girl-and-chocolate-trailer.html") {
	
	$url = '/gen-ops/girl-chocolate-trailer.html';
	
}

$title_for_layout = "The Berrics - News";

if(!empty($post['Dailyop']['name'])) $title_for_layout.= " | ".$post['Dailyop']['name'];

if(!empty($post['Dailyop']['sub_title'])) $title_for_layout .= " - ".$post['Dailyop']['sub_title'];

$this->set("title_for_layout","The Berrics - News - ".$post['Dailyop']['name']);

$back_to_link = "/news/".date("Y",strtotime($this->request->params['date_in']))."/".date("m",strtotime($this->request->params['date_in']))."/".date("d",strtotime($this->request->params['date_in']));

if($post['Dailyop']['best_of']) {
	
	$back_to_link = "/news/2012/01/08";
	
}

?>
<?php echo $this->element("banners/728") ?>
<div class='article article-standard' id='news-article'>
	
	<?php echo $this->element("dailyops/articles/article-top",array("post"=>$post)); ?>
	<?php 
		
		foreach($post['DailyopTextItem'] as $k=>$t):
			if($k==0) continue;
			
			if($t['media_gallery'] == 1) {

				echo $this->element("news/media-gallery",array("post"=>$post));
				continue;
			}

			$img_file = '';
			$vid_file = '';
			
			if(count($t['MediaFile'])>0) {
				
				if($t['MediaFile']['media_type'] == "bcove") {
					
					$mediaItem = $this->Media->mediaThumb(array(
								"MediaFile"=>$t['MediaFile'],
								"w"=>700,
								"h"=>640
							))."<div class='play-button'></div><div class='overlay'></div>";
					$vid_file = "<div class='video-file img-polaroid'>".$this->Berrics->postMediaDiv($post,array("MediaFile"=>$t['MediaFile']))."</div>";
					
				} else {
					
					$style = '';
					switch(strtoupper($t['placement'])) {
						
						case "LEFT":
							$style = 'float:left;';
							$imgw = $t['thumb_width'];
							$imgh = $t['thumb_height'];
						break;
						case "RIGHT":
							$style = 'float:right;';
							$imgw = $t['thumb_width'];
							$imgh = $t['thumb_height'];
						break;
						case "TOP":
							$style = 'clear:both; text-align:center;';
							$imgw = $t['thumb_width'];
							$imgh = $t['thumb_height'];
						break;
						default:
							
						break;
						
					}
					$mediaItem = $this->Media->mediaThumb(array(
								"MediaFile"=>$t['MediaFile'],
								"w"=>$imgw,
								"h"=>$imgh,
								"lazy"=>true
							));
					//check to see if there is a link in the image
					if(strlen($t['MediaFile']['url'])>0) $mediaItem = "<a href='{$t['MediaFile']['url']}'>{$mediaItem}</a>";
					$img_file = "<div class='media-item img-polaroid' style='{$style}'>{$mediaItem}</div>";
							
				}
				
			}
			
			
			
			
	?>
	<div class='dailyop-text-item'>
		<h2><?php echo $t['heading']; ?></h2>
		<?php echo $vid_file; ?>
		<div class='text-item'>
			<?php echo $img_file; ?>
			<p>
			<?php 
				echo nl2br($t['text_content']); 
			?>
			</p>
			<div style='clear:both;'></div>
		</div>
	</div>
	<?php 
		endforeach;
	?>
	<hr />
	
	<div class='links'>
		<?php 
			
			foreach($post['Meta'] as $m):
				//if(strtolower($m['key']) != "link") continue;
				$label = preg_replace('/^(http:\/\/)/i','',$m['val']);
				$label = preg_replace('/^(www\.)/i','',$label);
		?>
			<a href='<?php echo $m['val']; ?>'><?php echo $label; ?></a> | 
		<?php 
			
			endforeach;
		
		?>
	</div>
	<?php echo $this->element("dailyops/posts/recent-related-posts",$related) ?>
</div>

<div style='clear:both;'></div>
<?php 

pr($post);

?>
