<script>
$(document).ready(function() {


	$( "#MediahuntTaskPublishDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});
</script>
<?php 

$sort = array();

for($i=1;$i<=99;$i++) $sort[$i] = $i;

?>
<div class="mediahuntTasks form">
<?php echo $this->Form->create('MediahuntTask',array("url"=>$this->here));?>
	<fieldset>
		<legend><?php __('Edit Mediahunt Task'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
		echo $this->Form->input("publish_date",array("type"=>"text"));
		echo $this->Form->input('sort_order',array("options"=>$sort));
		echo $this->Form->input('name');
		echo $this->Form->input('details');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>