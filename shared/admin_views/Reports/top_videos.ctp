<script type="text/javascript">
jQuery(document).ready(function() {
	
	

});

</script>
<h2>Top Videos</h2>
<div class="row-fluid">
	<div class="span6">
		<?php echo $this->Form->create('Report'); ?>
		<?php 

			$l = array();
			for($i=50;$i<=200;($i+=50)) $l[$i] = $i;

			echo $this->Form->input("title");
			echo $this->Form->input('start_date');
			echo $this->Form->input('end_date');
			echo $this->Form->input('limit',array('options'=>$l));

		?>
		<div class="form-actions"><button class="btn btn-primary">Generate Report</button></div>
		<?php echo $this->Form->end(); ?>
	</div>
	<div class="span6"></div>
</div>