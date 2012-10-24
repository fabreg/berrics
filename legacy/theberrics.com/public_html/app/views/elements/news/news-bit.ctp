<?php 

//determine the main link that the articel is using
$link = '/news/'.$post['Dailyop']['uri'];

if(!empty($post['Dailyop']['url'])) {
	
	$link = $post['Dailyop']['url'];
	
}


$img_top = '';

$img_text = '';

$item = $post['DailyopTextItem'][0];

$img_w = (empty($item['thumb_width'])) ? 300:$item['thumb_width'];

$img_h = $item['thumb_height'];

$img = "<a href='{$link}'>".$this->Media->mediaThumb(array(

	"MediaFile"=>$item['MediaFile'],
	"w"=>$img_w,
	"h"=>$img_h

))."</a>";

$vid = false;
$pic = false;

foreach($post['DailyopTextItem'] as $key=>$i) {
	if($key==0) continue;
	if(count($i['MediaFile'])>0) {
		
		switch($i['MediaFile']['media_type']) {
			
			case "bcove":
			case "llnw":
				$vid = true;
			break;
			case "image":
			case "img":
				$pic = true;
			break;
			
		}
		
	}
	
}

if(count($item['MediaFile'])>0) {
		
	switch(strtolower($item['placement'])) {
		
		case "left":
			$style='float:left; padding-right:10px;';
			$img_text = "<div style='{$style}' class='media-text'>{$img}</div>";
		break;
		case "right":
			$style='float:right; padding-left:10px;';
			$img_text = "<div style='{$style}' class='media-text'>{$img}</div>";
		break;
		default:
			$img_top = $img;
		break;
		
	}
	
}




?>
<div class='news-bit'>
	<div class='title'><h3><a href='<?php echo $link; ?>'><?php echo $post['Dailyop']['name']; ?></a><h3></div>
	<?php if(!empty($post['Dailyop']['sub_title'])): ?>
	<div><h4><?php echo $post['Dailyop']['sub_title']; ?></h4></div>
	<?php endif; ?>
	<div style='text-align:center;'><?php echo $img_top; ?></div>
	<div class='text-content'>
		<?php echo $img_text; ?>
		<?php echo $post['DailyopTextItem'][0]['text_content']; ?>
	</div>
	<div class='article-link'><a href='<?php echo $link; ?>'>Click here for the full article</a></div>
	<div class='icons'>
		<img src='/img/layout/news/text-icon.jpg' />
		<?php 
			if($pic):
		?>
			<img src='/img/layout/news/pic-icon.jpg' alt='' title='Images' />
		<?php 
			endif;
		?>
		<?php 
			if($vid):
		?>
			<img src='/img/layout/news/vid-icon.jpg' alt='' title='Video' />
		<?php 
			endif;
		?>
	</div>
</div>