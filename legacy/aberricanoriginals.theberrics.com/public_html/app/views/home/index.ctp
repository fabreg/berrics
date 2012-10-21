<?php 


?>
<script>
var sid='<?php echo $this->Session->id(); ?>';
$(document).ready(function() { 


	$('.display-media').click(function() { 

			

			//alert(post);

			/*
			var swfVars = {
				'media_file_id':m['id'],
				videoAspectRatio:1,
				"dailyop_id":data['dailyop_id'],
				pre_roll:m['preroll'],
				post_roll:m['postroll']
			};
			*/
		var params = {
			"media_file_id":$(this).attr("media_file_id"),
			"dailyop_id":$(this).attr("dailyop_id"),
			"videoAspectRatio":1,
			pre_roll:'',
			post_roll:'http://ad.doubleclick.net/N5885/adx/LEVIS;sz=8x8;cue=post;ord='+Math.random()+'?'
		};
		$(this).flash({
			swf:"http://theberrics.com/swf/BerricsPlayer.swf?time="+Math.random(),
			flashVars:params,
			height:340,
			width:580,
			wmode:"opaque",
			bgcolor:"#000000",
			allowfullscreen:"true"
			
		});

		$(this).unbind('click');

			

	});
	
	$('.un-published').find('img').css({

		"opacity":.3

	});



	if(document.location.href.match(/(autoplay)/)) {


		$(".display-media").click();
		
	}

	$('.published').hover(function() {

		$(this).css({

			"border-color":"#860c19"

		});

	},function() { 

		$(this).css({
			"border-color":"#333"
		});



	}).click(function() { 


		var ref = $(this).attr("uri");

		document.location.href="/"+ref+"?autoplay";
		

	});
	

	
});
</script>
<style>
.img-thumb {

	float:left;
	margin:1px;
	padding:2px;
	font-size:11px;
	color:#666;
	border:1px solid #000;
	width:108px;
}

.published {

	border:1px solid #333;
	cursor:pointer;
}

.caption {


}

.caption .location {

	padding:2px;

}

.caption .sub_title {

	padding:2px;
	font-weight:bold;
}

</style>
<div id='levis'>
	<div class='left'>
		<img src='/img/video-heading.jpg'  style='margin-bottom:4px;' />
		<div id='video'>
			<div class='display-media' dailyop_id='<?php echo $viewing['Dailyop']['id']; ?>' media_file_id='<?php echo $viewing['DailyopMediaItem'][1]['MediaFile']['id']; ?>' >
				<?php
					echo $this->Media->mediaThumb(array(
						"MediaFile"=>$viewing['DailyopMediaItem'][1]['MediaFile'],
						"w"=>580,
						"h"=>340,
						"zc"=>1
					));
				?>
			</div>
		</div>
		<div style='padding:5px; text-align:left;'>
			<fb:like href="<?php echo urlencode("http://theberrics.com/".$viewing['DailyopSection']['uri']."/".$viewing['Dailyop']['uri']); ?>" layout="button_count" show_faces="false" width="25" font="lucida grande"></fb:like>
		</div>
		<div id='nav-strip'>
			<div class='heading'>ABERRICAN ORIGINALS</div>
			<div id='nav' style='border-bottom:1px solid #af0606;' >
				<?php 
					foreach($posts as $post):
					
					if($post['Dailyop']['id'] == 3240) {
						
						continue;
						
					}
					
					$curr_time = time();
					
					$this_time = strtotime($post['Dailyop']['publish_date']);
					
					
					
					if($this_time < $curr_time) {
						
						$cls = "published";
						$caption = "";
						$link = true;
						
					} else {
						
						$link = false;
						$cls = "un-published";
						$caption = "<span style='color:#860c19; '>Date: ".date("D M dS",strtotime($post['Dailyop']['publish_date']))."</span>";
					}
					
					
				?>
					<div class='img-thumb <?php echo $cls; ?>' uri='<?php echo $post['Dailyop']['uri']; ?>'>
						<?php 
						
							if($link) echo "<a href='/".$post['Dailyop']['uri']."?autoplay'>";
						
						?>
						<img src='http://img.theberrics.com/images/<?php echo $post['DailyopMediaItem'][2]['MediaFile']['file']; ?>' border='0' />
						<?php 
						
							if($link) echo "</a>";
						
						?>
						<div class='caption'>
							<div class='sub_title'>
								<?php echo $post['Dailyop']['sub_title']; ?>
							</div>
							<div class='location'>
								<?php echo $post['Meta'][0]['val']; ?>
							</div>
							<?php echo $caption; ?>
						</div>
					</div>
				<?php 
				
					endforeach;
				
				?>
				<div style='clear:both;'></div>
				
			</div>
			<div style='padding:5px; float:right;'>
				<a href='http://aberricanoriginals.theberrics.com/?autoplay' style='color:#af0606;'>
					<img src='/img/footer_explanation.jpg' border='0'/>
				</a>
			</div>
			<div style='padding:5px; float:left;'>
				<a href='http://theberrics.com/dailyops.php' style='color:#af0606;'>
					<img src='/img/footer_back.jpg' border='0' />
				</a>
			</div>
		</div>
	</div>
	<div class='right'>
		<?php 
		if(date("d")>2):
		?>
		<div>
			<img src='/img/closed.jpg' />
		</div>
		<?php 
		
		else:
		
		?>
		<img src='/img/win-heading.jpg' />
		<div class='rules-text'>
			<p>
				To coincide with the Museum of Contemporary Art's ground breaking exhibit Art in the Streets, The Berrics and Levi's have teamed up to incite filmmakers and skateboarders everywhere to document the art that they see in their streets.  Murals or architecture.  Billboards or graffiti.  Construction or demolition.  The ebb and flow of rush hour traffic or the silence of a deserted street at 4 in the morning.  The limitations are defined only by your own relationship with skateboarding and the world around you.  Literal or abstract, it's all fair game.  Have fun!  			</p>
			<br />
			<div class='heading'>VIDEO REQUIREMENTS</div>
			<ul>
				<li>- No More Than 3 Minutes</li>
				<li>- File Size Must Be 100 MB Or Below</li>
				<li>- File Format .MOV .MP4</li>
				<li>- Video Must Be Submitted Before August 3rd 2011</li>
			</ul>
		</div>
		<div id='enter'>
			<?php 
			
				if($this->Session->check("Auth.User.id")) {
					
					echo $this->element("form");
					 
				} else {
					
					echo $this->element("login");
					
				}
			
			?>
		</div>
		<div><img src='/img/candy-cane.jpg' /></div>
		<?php endif; ?>
	</div>
	<div style='clear:both;'></div>
</div>
<div style='clear:both;'></div>
<div style='text-align:center; padding-top:20px;'></div>