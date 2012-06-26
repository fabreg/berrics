<?php 

	$d = $dop['Dailyop'];
	$m = $dop['DailyopMediaItem'];
	$f = $m[0]['MediaFile'];
	$s = $dop['DailyopSection'];
	$t = $dop['Tag'];
	
	$url = $this->Berrics->dailyopsPostUrl($dop);
	$report_queue = $this->Session->read("MediaFileReportQueue");
	
	$fb_like = (!empty($d['fb_like_uri_override'])) ? $d['fb_like_uri_override']:$url;
	
	if(!is_array($report_queue)) {
		
		$report_queue = array();
		
	}
	
	//share title for tumblr
	$share_title = $d['name'];
	if(!empty($d['sub_title'])) $share_title .= " - ".$d['sub_title'];
	
	//get a media file source for tumblr
	
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
<div class='footer'>
		<div class='tags'>
				<?php
					if(!empty($s['icon_light_file'])):
				?>
					<div class='icon'>
						<?php 
						
							$icon = $this->Media->sectionIcon(array("DailyopSection"=>$s,"w"=>32,"h"=>32),array("border"=>0,"url"=>"/".$s['uri'],"title"=>$s['name']));
					
						?>
					</div>
				<?php 
				
					endif;
				
				?>
				<?php 
				
					if(count($t)>0) {
						
						echo "<strong>Tags: </strong>";
						
						foreach($t as $v) {
							echo "<span class='tag'>";
							
							if(isset($v['User'][0]['facebook_account_num']) && !empty($v['User'][0]['facebook_account_num'])) echo "<a href='http://facbook.com/profile.php?id={$v['User'][0]['facebook_account_num']}' target='_blank' ><img border='0' src='/img/layout/fb-tag-icon.jpg'  /></a>";
							
							if(isset($v['User'][0]['twitter_handle']) && !empty($v['User'][0]['twitter_handle'])) echo "<a href='http://twitter.com/{$v['User'][0]['twitter_handle']}' target='_blank' ><img border='0' src='/img/layout/twitter-tag-icon.jpg' /></a>";
							
							if(isset($v['User'][0]['instagram_handle']) && !empty($v['User'][0]['instagram_handle'])) echo "<a href='http://web.stagram.com/n/{$v['User'][0]['instagram_handle']}' target='_blank' ><img border='0' src='/img/layout/instagram-tag-icon.jpg'  /></a>";
							
							
							echo "<a href='/tags/".$v['slug']."' title='".$v['name']."'>".strtoupper($v['name'])."</a>";
							echo "</span>";
							echo "&nbsp;";
						}
					}

				?>
				<div style='clear:both;'></div>
			</div>
			<div class='buttons'>
				<div class='socialize'>
					<?php if(!empty($tumblr_source) && !$_SERVER['HTTPS']): ?>
					<div class='tumblr'>
					<a href="http://www.tumblr.com/share/photo?source=<?php echo urlencode($tumblr_source) ?>&caption=<?php echo urlencode($share_title) ?>&clickthru=<?php echo urlencode("http://theberrics.com".$url) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:61px; height:20px; background:url('http://platform.tumblr.com/v1/share_2.png') top left no-repeat transparent;">Share on Tumblr</a>
					</div>
					<?php endif; ?>
					<div class='twitter'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$url; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
					</div> 
						
					<?php if(strtotime($d['publish_date'])<time()): ?>
					<div class="fb-like" data-href="<?php echo urlencode("http://theberrics.com".$fb_like); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style='float:left;'></div>
					<?php  /* <fb:like href="<?php echo urlencode("http://".$_SERVER['SERVER_NAME'].$url); ?>" layout="button_count" show_faces="false" width="25" font="lucida grande"></fb:like> */ ?>
					<?php endif; ?>
					
				</div>	
				
				<div class='date-info'>
					<?php 
					
						echo $this->Html->link("PERMALINK",$this->Berrics->dailyopsPostUrl($dop));
					
					?> | 
					<?php 
					
						echo $this->Time->niceShort($d['publish_date']);
					
					?>
				</div>
				<div style='clear:both;'></div>
			</div>
			<?php 
				if($this->Session->read("is_admin") == 1):
			?>
			<div style='font-size:10px;'>
				<a href='http://admin.theberrics.com/dailyops/edit/<?php echo $d['id']; ?>' target='_blank'>Admin Edit</a> <a href='http://admin.theberrics.com/media_files/update_video_still/<?php echo $f['id']; ?>' target='_blank'>Update Video Still</a>
				<a href='http://admin.theberrics.com/traffic_reports/media_file_details/media_file_id:<?php echo $f['id']; ?>/date_start:2011-06-20/date_end:<?php echo date("Y-m-d"); ?>' target='_blank'>Media File Report</a> 
				
				<?php if(!in_array($f['id'],$report_queue)): ?>
				<a href='http://admin.theberrics.com/media_files/queue_video_for_report/<?php echo $f['id']; ?>/<?php echo base64_encode("http://".$_SERVER['SERVER_NAME'].$this->here)?>'>Queue for report</a>
				<?php 
					endif;
				?>
			</div>
			<?php 
			
				endif;
			
			?>
</div>