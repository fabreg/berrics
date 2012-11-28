<?php 

	$this->Html->script(array("v3/jquery.lazyload.min"),array("inline"=>false));

?>
<script>
jQuery(document).ready(function($) {
		

	$('.lazy').lazyload();



});

</script>
<div id="post-section" class='clearfix'>
	<div class="row-fluid">
		<div class="span12">
			<div class="banner-728" id='banner1'>
				<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<?php foreach ($posts as $k => $v): ?>
			<div class='post-thumb standard-post-thumb'>
			<?php 

				$media_file = $v['DailyopMediaItem'][0]['MediaFile'];
				$thumb_url = $this->Media->mediaThumbSrc(array(
									"MediaFile"=>$media_file,
									"w"=>300
								));
			?>
			<div class="post-date">
				<?php echo date("m.d.Y",strtotime($v['Dailyop']['publish_date'])) ?>
			</div>
			<img src="/img/v3/layout/blk-px.png" alt="" border='0' data-original='<?php echo $thumb_url; ?>' width='300' class='lazy'>
			<div class="post-title">
				<?php echo $this->Text->truncate(strtoupper($v['Dailyop']['name']),25); ?>
			</div>
			<div class="post-sub-title">
				<?php echo $this->Text->truncate($v['Dailyop']['sub_title'],28); ?>&nbsp;
			</div>
			</div>
		<?php endforeach ?>
	</div>
</div>