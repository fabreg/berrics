<?php
$ig_data = json_decode($image['MediahuntMediaItem']['instagram_data'],true);
?>
<div class='image-view'>
	<div class='image-file'>
		<img border='0' src='http://img.theberrics.com/i.php?src=/mediahunt-media/<?php echo $image['MediahuntMediaItem']['file_name']; ?>&w=275' />
	</div>
	<div class='image-user'>
		<div class='image-task'><span>CHALLENGE: </span><?php echo $image['MediahuntTask']['name']; ?></div>
		<div class='image-user'><span>Photo By: </span><?php echo $image['User']['first_name']; ?> <?php echo $image['User']['last_name']; ?></div>
		<?php if($image['MediahuntMediaItem']['instagram_id']): ?>
		<div class='image-instagram-link'><span>Instagram:</span> <a rel='no-ajax' href='<?php echo $ig_data['data']['link']; ?>' target='_blank'><?php echo $ig_data['data']['link']; ?></a></div>
		<?php endif; ?>
		<div class='share-buttons'>
			<div class='twitter'>
				<a rel='no-ajax' href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com/".$_GET['url']; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
			</div>
			<div class='facebook'>
				<div class="fb-like" data-href="<?php echo urlencode("http://theberrics.com/".$_GET['url']); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" ></div>
			</div> 
			
			
			<div style='clear:both;'></div>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>