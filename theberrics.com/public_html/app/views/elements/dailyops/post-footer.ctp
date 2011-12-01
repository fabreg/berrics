<?php 

	$d = $dop['Dailyop'];
	$m = $dop['DailyopMediaItem'];
	$f = $m[0]['MediaFile'];
	$s = $dop['DailyopSection'];
	$t = $dop['Tag'];
	
	$url = $this->Berrics->dailyopsPostUrl($dop);
	$report_queue = $this->Session->read("MediaFileReportQueue");
	
	if(!is_array($report_queue)) {
		
		$report_queue = array();
		
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
							
							echo "<a href='/tags/".$v['slug']."' title='".$v['name']."'>".strtoupper($v['name'])."</a>";
							echo "&nbsp;";
						}
					}

				?>
				<div style='clear:both;'></div>
			</div>
			<div class='buttons'>
				<div class='socialize'>
					<div class='twitter'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$url; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
					</div> 
					<?php if($d['contest_post'] == 1): ?>
						<?php 
						
							echo $this->Form->create("UserContest",array("style"=>"float:left;","url"=>"/31-days-of-theotis/found"));
						?>
						<div class='fb-form-button'><img alt='' border='0' src='/theme/31-days-of-theotis/img/fakebook.png' onclick='$(this).parent().parent().submit(); return true;' />
						<div class='flag'>
						68
						</div>
						</div>
						<?php
						//make the cipher
							echo $this->Form->input($this->Session->id(),array("type"=>"hidden","value"=>base64_encode(serialize(Array("session_id"=>$this->Session->id(),"dailyop_id"=>$d['id'])))));
							echo $this->Form->end();
						
						?>
						
					<?php else: ?>
					<fb:like href="<?php echo urlencode("http://".$_SERVER['SERVER_NAME'].$url); ?>" layout="button_count" show_faces="false" width="25" font="lucida grande"></fb:like>
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
			<div>
				<a href='http://admin.theberrics.com/dailyops/edit/<?php echo $d['id']; ?>' target='_blank'>Admin Edit</a> <a href='http://admin.theberrics.com/media_files/update_video_still/<?php echo $f['id']; ?>' target='_blank'>Update Video Still</a>
				<a href='http://admin.theberrics.com/traffic_reports/media_file_details/media_file_id:<?php echo $f['id']; ?>/date_start:2011-06-20/date_end:<?php echo date("Y-m-d"); ?>' target='_blank'>Media File Report</a> 
				
				<?php if(!in_array($f['id'],$report_queue)): ?>
				<a href='http://dev.admin.theberrics.com/media_files/queue_video_for_report/<?php echo $f['id']; ?>/<?php echo base64_encode("http://".$_SERVER['SERVER_NAME'].$this->here)?>'>Queue for report</a>
				<?php 
					endif;
				?>
			</div>
			<?php 
			
				endif;
			
			?>
</div>