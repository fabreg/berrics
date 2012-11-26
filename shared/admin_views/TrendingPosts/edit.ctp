<script>
jQuery(document).ready(function($) {
	
	$( "#TrendingPostStartDateDate,#TrendingPostEndDateDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#TrendingPostStartTime,#TrendingPostEndTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

});

</script>
<?php 
$a = array();
for ($i=1; $i < 99; $i++) { 
	$a[$i] = $i;
}

?>
<div class="page-header">
	<h1>Edit Trending Post</h1>
</div>
<div class="trendingPosts form">
<div class="well">
	<div>
		<h3>Post</h3>
	</div>
	<div>
		<h4>
			<?php echo $this->request->data['Dailyop']['name']; ?>
			<small><?php echo $this->request->data['Dailyop']['sub_title']; ?></small>
		</h4>
	</div>
</div>
<?php echo $this->Form->create('TrendingPost'); ?>
	<div class="row-fluid">
		<div class="span6">
			<div class="well well-small">
				<?php 
				echo $this->Form->input('start_date_date',array("label"=>"Start Date"));
				echo $this->Form->input("start_time",array("label"=>"Start Time"));
			 ?>
			</div>
		</div>
		<div class="span6">
			<div class="well well-small">
				<?php 
				echo $this->Form->input('end_date_date',array("label"=>"End Date"));
				echo $this->Form->input("end_time",array("label"=>"End Time"));
			 ?>
			</div>
		</div>
	</div>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('section',array("options"=>TrendingPost::sections()));
		echo $this->Form->input('display_weight',array("options"=>$a));
	?>
	
	<div class="form-actions">
		<button class="btn btn-primary" type="submit">Update</button>
	</div>
<?php echo $this->Form->end(); ?>
</div>