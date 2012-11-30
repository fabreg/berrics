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

	$('.bottom-year-nav li[data-year=<?php echo $year; ?>]').addClass('active');

});


</script>
<div id="post-section" class='clearfix'>
	<div class="row-fluid">
		<div class="span12">
			<?php echo $this->element("banners/728") ?>
		</div>
	</div>
	<?php if (!empty($section['section_heading_file'])): ?>
	<div class="row-fluid section-heading-div">
		<div class="span12">
			<?php echo $this->Media->sectionHeading(array(
				"DailyopSection"=>$section,
				"w"=>728
			)); ?>
		</div>
	</div>
	<?php endif ?>
	<div class="row-fluid">
		<div class="span5 offset7" id='jump-menu'>
			<?php echo $this->Form->create('DailyopSection',array(
				"id"=>'DailyopSectionForm',
				"url"=>$this->request->here,
				"class"=>"form form-horizontal"
			)); ?>
			<?php echo $this->Form->input("years",array("options"=>$year_select,"id"=>"SectionYear","selected"=>$year,"label"=>"JUMP TO")); ?>
			<?php echo $this->Form->end(); ?>
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
		<ul class="nav nav-pills pull-right bottom-year-nav">
			<?php foreach ($year_select as $k => $v): ?>
				<li data-year='<?php echo $v; ?>'>
					<a href="/<?php echo $section['uri'];  ?>/<?php echo $v ?>" title='<?php echo addslashes($section['name']); ?> - <?php echo $v; ?>'><?php echo $v; ?></a>
				</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>