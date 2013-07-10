<?php 

$url = $this->Berrics->dailyopsPostUrl($dop);

$fb_like = $url;

$d = $dop['Dailyop'];

if(!empty($dop['Dailyop']['fb_like_uri_override'])) $fb_like = $dop['Dailyop']['fb_like_uri_override'];

$tumblr_source = "";
	/*
	switch(strtolower($f['media_type'])) {
		
		case "bcove":
			$tumblr_source = "http://img01.theberrics.com/video/stills/".$f['file_video_still'];
		break;
		case "img":
		case "image":
			$tumblr_source = "http://img01.theberrics.com/images/".$f['file'];
			break;
	}
	*/

?>
<div class="post-footer clearfix">
	<div class="row-fluid">
		<div class="social-media span4 pull-right">
			<?php if(!empty($tumblr_source) && !$_SERVER['HTTPS']): ?>
				<div class='tumblr'>
					<a href="http://www.tumblr.com/share/photo?source=<?php echo urlencode($tumblr_source) ?>&amp;caption=<?php echo urlencode($share_title) ?>&amp;clickthru=<?php echo urlencode("http://theberrics.com".$url) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;">Share on Tumblr</a>
				</div>
			<?php endif; ?>
				<?php if(strtotime($d['publish_date'])<time()): ?>	
				<div class="fb-like" data-href="<?php echo "http://theberrics.com".$fb_like; ?>" data-send="false" data-layout="button_count" data-width="100" data-show-faces="true"></div>
			<?php endif; ?>
				<div class='twitter'>
					<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$url; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
				</div> 
			
		</div>
		<?php if (count($dop['Tag'])>0): ?>
				<div class="tags span8">
					TAGS// <?php echo $this->Berrics->parseTagLinks($dop['Tag']) ?>
				</div>	
		<?php endif ?>
		<?php 
			$report_queue = CakeSession::read("MediaFileReportQueue");

			if(!is_array($report_queue)) {
				
				$report_queue = array();
				
			}

			if($dop['DailyopMediaItem'][0]['MediaFile']['media_type'] == "bcove") {

				$media_file_id = $dop['DailyopMediaItem'][0]['MediaFile']['id'];

			} else {

				$media_file_id = false;

			}

			if (CakeSession::read("is_admin") == 1 && $media_file_id && (!in_array($media_file_id,$report_queue))): 

		?>
		<a id='report-queue-btn' href="http://cp.theberrics.com/media_files/queue_video_for_report/<?php echo $media_file_id; ?>/<?php echo base64_encode("http://theberrics.com".$this->request->here); ?>" class="btn btn-warning"><i class="icon icon-white icon-plus-sign"></i> Add Video To Report Queue</a>	
		<?php endif ?>
		
	</div>
</div>