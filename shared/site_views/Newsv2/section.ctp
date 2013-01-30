<?php 
	
	$this->set("title_for_layout","The Berrics - News");

?>
<div id="news-section">
	<div class="row-fluid heading">
		<div class="span4">
			<h1>News</h1>
		</div>
		<div class="span8">
			<div style="float:right;"><?php echo $this->element("layout/v3/bootstrap-paginator") ?></div> 
		</div>
	</div>
	<div class="inner">
		<?php foreach ($posts as $k => $v): ?>
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)); ?>
		<?php endforeach ?>
	</div>
</div>
<div style="float:right;"><?php echo $this->element("layout/v3/bootstrap-paginator") ?></div> 