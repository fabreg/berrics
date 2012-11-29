<?php 


$link = "/".$post['Dailyop']['DailyopSection']['uri']."/".$post['Dailyop']['uri'];

 ?>
<tr>
	<td width='100'>
		<a href='<?php echo $link; ?>'>
		<?php echo $this->Media->mediaThumb(array(
			"MediaFile"=>$post['Dailyop']['DailyopMediaItem'][0]['MediaFile'],
			"w"=>90,
		)); ?>
		</a>
	</td>
	<td>
		<?php echo $this->Text->truncate($post['Dailyop']['name'],36); ?>
		<div>
			<small>
				<?php echo $this->Text->truncate($post['Dailyop']['sub_title'],36); ?>&nbsp;
			</small>
		</div>
	</td>
</tr>