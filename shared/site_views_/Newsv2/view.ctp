<?php 

$misc = Arr::dailyopsMiscCategories();

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

$this->set("title_for_layout","Aberrican Times | ".$post['Dailyop']['name']);

$back_to_link = "/news/".date("Y",strtotime($this->request->params['date_in']))."/".date("m",strtotime($this->request->params['date_in']))."/".date("d",strtotime($this->request->params['date_in']));

if($post['Dailyop']['best_of']) {
	
	$back_to_link = "/news/2012/01/08";
	
}

?>
<div id='news-article'>
	<div>
		<h1><?php echo $post['Dailyop']['name']; ?></h1>
		<div class='publish-date'><?php echo $misc[$post['Dailyop']['misc_category']]; ?> | <?php echo date("M d, Y",strtotime($post['Dailyop']['publish_date'])); ?></div>
		<div>
			<a href='<?php echo $back_to_link; ?>'>
				<img src='/img/layout/news/back-home.jpg' border='0'/>
			</a>
			<div style='float:right'>
				<fb:like href="<?php echo urlencode("http://".$_SERVER['SERVER_NAME'].$url); ?>" layout="button_count" show_faces="false" width="25" font="lucida grande"></fb:like>
			</div>
			<div class='twitter' style='float:right; padding-right:5px;'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://".$_SERVER['SERVER_NAME'].$url; ?>" data-text='<?php echo addslashes($post['Dailyop']['name']." ".$post['Dailyop']['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
					</div> 
			<div style='clear:both;'></div>
		</div>
	</div>
	<?php 
		
		foreach($post['DailyopTextItem'] as $k=>$t):
			if($k==0) continue;
			
			$img_file = '';
			$vid_file = '';
			
			if(count($t['MediaFile'])>0) {
				
				if($t['MediaFile']['media_type'] == "bcove") {
					
					$mediaItem = $this->Media->mediaThumb(array(
								"MediaFile"=>$t['MediaFile'],
								"w"=>700,
								"h"=>640
							))."<div class='play-button'></div><div class='overlay'></div>";
					$vid_file = "<div class='video-file'>".$this->Berrics->mediaFileDiv($mediaItem,array("MediaFile"=>array_merge($t['MediaFile'],array("Dailyop"=>$post))))."</div>";
					
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
								"h"=>$imgh
							));
					//check to see if there is a link in the image
					if(strlen($t['MediaFile']['url'])>0) $mediaItem = "<a href='{$t['MediaFile']['url']}'>{$mediaItem}</a>";
					$img_file = "<div class='media-item' style='{$style}'>{$mediaItem}</div>";
							
				}
				
			}
			
			
			
			
	?>
	<div class='dailyop-text-item'>
		<h2><?php echo $t['heading']; ?></h2>
		<?php echo $vid_file; ?>
		<div class='text-item'>
			<?php echo $img_file; ?>
			<?php 
				echo nl2br($t['text_content']); 
			?>
			<div style='clear:both;'></div>
		</div>
		
	</div>
	<?php 
		endforeach;
	?>
	<?php if(isset($instagram)): ?>
		<style>
		.instagram-image-item {
		
			float:left;
			padding:10px;
			border:1px solid #999;
			background-color:#bbb4a4;
			margin-bottom:4px;
			margin-left:5px;
		}
		
		.instagram-image-item img {
		
			border:1px solid #999;
			
		
		}
		
		.instagram-image-item:nth-child(odd) {
		
			float:right;
			margin-right:5px;
		}
		</style>
		<div>
			<h2 style='padding-bottom:5px; margin-bottom:5px; border-bottom:1px solid #000;'>Instagram: happybirthdayerickoston</h2>
			<?php foreach($instagram['data'] as $v): ?>
				<div class='instagram-image-item'>
					<img border='0' src='<?php echo $v['images']['low_resolution']['url']; ?>'/>
					<div>
						@<?php echo $v['user']['username']; ?> <br />
						Likes: <?php echo $v['likes']['count']; ?>
					</div>
				</div>
			<?php endforeach; ?>
			<div style='clear:both;'></div>
		</div>
	<?php endif; ?>
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
	<div>
			<a href='<?php echo $back_to_link; ?>'>
				<img src='/img/layout/news/back-home.jpg' border='0'/>
			</a>
		</div>
</div>
<div id='summary-col'>
	<div class='inner'>
		
		<!-- Unified -->
		<div class='heading'>
			<img border='0' alt='' src='/img/layout/news/unified-header.jpg'/>
		</div>
		<div class='scroller'>
			<?php foreach($unified as $p): ?>
				<?php echo $this->element("newsv2/unified-bit",array("p"=>$p)); ?>
			<?php endforeach; ?>
		</div>
		<?php echo $this->element("layout/right-col-social-buttons"); ?>
		<div class='heading'>
			<img border='0' alt='' src='/img/layout/news/upcoming-header.jpg'/>
		</div>
		<div class='scroller'>
			<?php foreach($event_news as $p): ?>
				<?php echo $this->element("newsv2/event-bit",array("p"=>$p)); ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>
<div style='clear:both;'></div>
<?php 

pr($post);

?>
