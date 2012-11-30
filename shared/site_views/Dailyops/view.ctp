<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

$m = $entry['DailyopMediaItem'][0]['MediaFile'];



?>
<style>
#thumbs .left {

	float:left;	
	margin-bottom:8px;
}
#thumbs .right {

	float:right;
	margin-bottom:8px;
}
</style>
<div id="post-view">
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$entry)); ?>
</div>