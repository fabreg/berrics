<style type="text/css">
	
#search-results {

	max-width: 728px;
	margin: auto;

}

</style>
<div id="search-results">
	<?php foreach ($posts as $k => $v): ?>
		<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
	<?php endforeach ?>
</div>