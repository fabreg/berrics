<script>
jQuery(document).ready(function($) {
	
	

});
</script>
<div class="trendingPosts form">
<?php echo $this->Form->create('TrendingPost'); ?>
<?php
		echo $this->Form->input('dailyop_id');
		echo $this->Form->input('display_weight');
		echo $this->Form->input('section');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('active');
	?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
