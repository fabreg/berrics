<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

$m = $post['DailyopMediaItem'][0]['MediaFile'];



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
		
		$post['Dailyop']['post_template'] = "";

		echo $this->element("dailyops/post-bit",array("dop"=>$post)); 
		
	?>

	<?php echo $this->element("dailyops/posts/recent-related-posts",$post); ?>

</div>
