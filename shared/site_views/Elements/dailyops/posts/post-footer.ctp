<?php 

$url = $this->Berrics->dailyopsPostUrl($dop);

$fb_like = $url;

$d = $dop['Dailyop'];

if(!empty($dop['Dailyop']['fb_like_uri_override'])) $fb_like = $dop['Dailyop']['fb_like_uri_override'];

$tumblr_source = "";
	
	switch(strtolower($f['media_type'])) {
		
		case "bcove":
			$tumblr_source = "http://img.theberrics.com/video/stills/".$f['file_video_still'];
		break;
		case "img":
		case "image":
			$tumblr_source = "http://img.theberrics.com/images/".$f['file'];
			break;
	}

?>
<div class="post-footer clearfix">
	<div class="row-fluid">
		<div class="social-media span6 pull-right">
			<?php if(!empty($tumblr_source) && !$_SERVER['HTTPS']): ?>
				<div class='tumblr'>
					<a href="http://www.tumblr.com/share/photo?source=<?php echo urlencode($tumblr_source) ?>&caption=<?php echo urlencode($share_title) ?>&clickthru=<?php echo urlencode("http://theberrics.com".$url) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;">Share on Tumblr</a>
				</div>
			<?php endif; ?>
				<?php if(strtotime($d['publish_date'])<time()): ?>	
				<div class="fb-like" data-href="<?php echo "http://theberrics.com".$fb_like; ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true"></div>
			<?php endif; ?>
				<div class='twitter'>
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$url; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
				</div> 
			
		</div>
		<div class="tags span8">
			TAGS// 
			<?php foreach ($dop['Tag'] as $k => $v): ?>
				<a href=""><?php echo strtoupper($v['name']); ?></a>&nbsp;
			<?php endforeach ?>
		</div>
		
	</div>
</div>