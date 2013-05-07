<?php 
	
	$link = "/".$post['DailyopSection']['uri']."/".$post['Dailyop']['uri'];
	$t = $post['DailyopTextItem'][0];
?>
<tr>
	<td width='100'>
		<a href='<?php echo $link; ?>'>
		<?php 
			$media_file = $post['DailyopTextItem'][0]['MediaFile'];
			echo $this->Media->mediaThumb(array(
				"MediaFile"=>$media_file,
				"w"=>90,
				"h"=>75,
				"zc"=>1
			));
		?>
		</a>
	</td>
	<td>
		<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($post['Dailyop']['name'],$max_title); ?></a>
		<div>
			<small>
				<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($post['Dailyop']['sub_title'],$max_sub_title); ?></a>
			</small>
		</div>
		<p>
			<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($t['text_content'],$max_text); ?></a>
		</p>
	</td>
</tr>