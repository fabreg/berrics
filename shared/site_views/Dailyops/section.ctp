<?php 

	//page title
	$this->set("title_for_layout","The Berrics - ".$section['name']);

?>
<script type="text/javascript">
var section=<?php echo json_encode($section); ?>;
jQuery(document).ready(function($) {
	
	$("#SectionYear").change(function() { 

		var year = $(this).val();

		var uri = "/"+section.uri+"/"+year;

		document.location.href = uri;

	});

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
		<div class="span4 offset8">
			<?php echo $this->Form->input("years",array("options"=>$year_select,"id"=>"SectionYear")); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="thumb-collection clearfix">
			<?php foreach ($posts as $k => $v): ?>
				<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<ul class="nav nav-pills pull-right">
			<?php foreach ($year_select as $k => $v): ?>
				<li>
					<a href="/<?php echo $section['uri'];  ?>/<?php echo $v ?>" title='<?php echo addslashes($section['name']); ?> - <?php echo $v; ?>'><?php echo $v; ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>