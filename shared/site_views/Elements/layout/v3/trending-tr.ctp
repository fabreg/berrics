<?php 

$link = "/".$post['Dailyop']['DailyopSection']['uri']."/".$post['Dailyop']['uri'];

if($post['Dailyop']['DailyopSection']['uri'] != "news") {

	$link .= "?autoplay";

}

?>
<tr>
	<td width='100'>
		<a href='<?php echo $link; ?>'>
		<?php echo $this->Media->mediaThumb(array(
			"MediaFile"=>$post['Dailyop']['DailyopMediaItem'][0]['MediaFile'],
			"w"=>90,
			"h"=>60,
			"lazy"=>false
		)); ?>
		</a>
	</td>
	<td>
		<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($post['Dailyop']['name'],36); ?></a>
		<div>
			<small>
				<a href='<?php echo $link; ?>'><?php echo $this->Text->truncate($post['Dailyop']['sub_title'],36); ?>&nbsp;</a>
			</small>
		</div>
	</td>
</tr>