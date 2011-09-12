<?php

//image constraints
$h = 405;
$w = 624;
$m = $img['MediaFile'];
$this->Html->script(array("articles/gallery","jquery.swfobject"),array("inline"=>false));

?>
<?php 

if($img['MediaFile']['media_type'] == 'bcove'):

?>
<script>

	$(document).ready(function() { 

		$("#video-file").flash({
			swf:"http://dev.theberrics.com/swf/BerricsPlayer.swf",
			flashVars:{
				media_file_id:'<?php echo $m['id']; ?>',
				pre_roll:<?php echo ($m['preroll']==1) ? 1:0; ?>,
				post_roll:<?php echo ($m['postroll']==1) ? 1:0; ?>,
				v_height:405,
				v_width:545
			},
			height:<?php echo 405; ?>,
			width:<?php echo 624; ?>,
			wmode:"transparent"
		
		});

	});

</script>
<?php 

endif;

?>
<div id='gallery'>
	<div class='view-port'>
	<?php 
		
	switch($img['MediaFile']['media_type']) {
		
		case "bcove":
			
			echo "<div id='video-file' style='background-color:black;'></div>";
			
		break;
		default:
			
			echo $this->Media->mediaThumb(array(
			
				"MediaFile"=>$img['MediaFile'],
				"w"=>$w,
				"h"=>$h
			
			));
			
		break;
		
	}
		
	
	?>
	</div>
<div class='thumb-wrapper'>
	<div class='tab-left'></div>
	<div class='tab-right'></div>
	<div class='thumbs'>
		<div class='strip'>
			<?php 
			
			foreach($gallery as $k=>$v) {
				
				$thumb = $this->Media->mediaThumb(array(
					"MediaFile"=>$v['MediaFile'],
					"w"=>85,
					"h"=>85,
					"zc"=>1
				));
				
				$xtra = '';
				
				if($img['MediaFile']['id'] == $v['MediaFile']['id']) {
					
					$xtra = 'selected';
					
				}
				
				$link = $this->Html->link($thumb,$this->here."?image=".$k,array("escape"=>false));
				
				echo $this->Html->div("gallery-thumb {$xtra}",$link,array("escape"=>false));
				
			}
			
			?>
		<div style='clear:both;'></div>
		</div>
	</div>
</div>
</div>
