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
		<legend><?php __('Add Mediahunt Task'); ?></legend>
	<?php
		echo $this->Form->input('active');
		if(!empty($this->params['named']['mediahunt_event_id'])) {
			
			echo $this->Form->input("mediahunt_event_id",array("value"=>$this->params['named']['mediahunt_event_id'],"type"=>"hidden"));
			
		} else {
			
			echo $this->Form->input('mediahunt_event_id');
			
		}
		echo $this->Form->input("publish_date",array("type"=>"text"));
		echo $this->Form->input('sort_order',array("options"=>$sort));
		echo $this->Form->input('name');
		echo $this->Form->input('details');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
