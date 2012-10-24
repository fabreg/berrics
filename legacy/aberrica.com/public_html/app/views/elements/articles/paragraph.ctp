<?php

$text = $p['text_content'];
$heading = $p['heading'];
$tag = $p['heading_tag'];
?>
<div class='paragraph-bit'>
	<?php 
	
		if(!empty($heading)) {

			echo "<{$tag}>{$heading}</{$tag}>";
			
		}
	
	?>
	<?php 
		if(!empty($text)):
	?>
	<p>
		<?php echo (count($p['MediaFile'])>0) ? $this->Aberrica->articleParagraphThumb($p):""; ?>
		<?php echo stripslashes(nl2br($p['text_content'])); ?>
	</p>
	<?php 
	
		elseif(strlen($p['MediaFile']['id'])>0):
		
	?>
		<div class='full-image'>
		<?php 
		
			echo $this->Media->mediaThumb(array(
			
				"MediaFile"=>$p['MediaFile'],
				"w"=>624,
				"h"=>624
			
			));
		
		?>
		
		</div>
	<?php 
	
		endif;
	
	?>
	<?php 
	
	//youtube and vimeo embeds
	if(!empty($p['youtube_url'])) {
		
		echo "<div class='embed-video'>";
		echo "[youtube=".$p['youtube_url']."]";
		echo "</div>";
		
	}
	
	if(!empty($p['vimeo_url'])) {
		
		echo "<div class='embed-video'>";
		echo "[vimeo=".$p['vimeo_url']."]";
		echo "</div>";
		
	}
	
	if(!empty($p['soundcloud_url'])) {
		echo "<div class='soundcloud'>";
		echo $this->Media->soundcloudUrl($p['soundcloud_url']);
		echo "</div>";
	}
	
	?>
</div>