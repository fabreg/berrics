<?php 

$misc = Arr::dailyopsMiscCategories();

$url = "/".$post['DailyopSection']['uri']."/".$post['Dailyop']['uri'];

if($post['Dailyop']['uri'] == "moose-gets-recruited.html") {
	
	$url = "/recruit/moose.html";
	
} else if ($post['Dailyop']['uri'] == "gatorade-chaz-ortiz.html") {
	
	$url = '/gen-ops/go-all-day.html';
	
} else if ($post['Dailyop']['uri'] == "powell-united-nations.html") {
	
	$url = '/united-nations/powell-peralta.html';
	
}


?>
<div id='news-article'>
	<div>
		<h1><?php echo $post['Dailyop']['name']; ?></h1>
		<div class='publish-date'><?php echo $misc[$post['Dailyop']['misc_category']]; ?> | <?php echo date("M d, Y",strtotime($post['Dailyop']['publish_date'])); ?></div>
		<div>
			<a href='/news/<?php echo date("Y",strtotime($this->params['date_in'])); ?>/<?php echo date("m",strtotime($this->params['date_in'])); ?>/<?php echo date("d",strtotime($this->params['date_in'])); ?>'>
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
					$vid_file = "<div class='video-file'>".$this->Berrics->mediaFileDiv($mediaItem,array("MediaFile"=>$t['MediaFile'],"Dailyop"=>$post))."</div>";
					
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
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".nl2br($t['text_content']); 
			?>
			<div style='clear:both;'></div>
		</div>
		
	</div>
	<?php 
		endforeach;
	?>
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
			<a href='/news/<?php echo date("Y",strtotime($this->params['date_in'])); ?>/<?php echo date("m",strtotime($this->params['date_in'])); ?>/<?php echo date("d",strtotime($this->params['date_in'])); ?>'>
				<img src='/img/layout/news/back-home.jpg' border='0'/>
			</a>
		</div>
</div>
<?php 

pr($post);

?>
