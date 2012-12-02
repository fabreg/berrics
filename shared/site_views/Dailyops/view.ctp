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
		<div class="row-fluid">
		<div class="span12">
			<?php echo $this->element("banners/728") ?>
		</div>
	</div>
	<?php 
		
		$entry['Dailyop']['post_template'] = "";

		echo $this->element("dailyops/post-bit",array("dop"=>$entry)); 

	?>

	<h3>Recent <small>(<a href="/<?php echo $entry['DailyopSection']['uri'] ?>"> View More </a>)</small> </h3>
	<div class="thumb-collection clearfix">
		<?php foreach ($recent_posts as $k => $v): ?>
			<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
		<?php endforeach ?>
	</div>
		<h3>Related</h3>
	<div class="thumb-collection clearfix">
		<?php foreach ($related_posts as $k => $v): ?>
			<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
		<?php endforeach ?>
	</div>
</div>
