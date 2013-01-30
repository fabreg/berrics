<script>

$(document).ready(function() { 

	

	
});

</script>
<div>
	<h3>Assigned Users</h3>
</div>
<?php 
echo $this->Form->create("Dailyop",array("url"=>array("action"=>"handle_tab_save",$this->request->data['Dailyop']['id']))); 
echo $this->Form->input("element",array("type"=>"hidden","value"=>"edit-users"));
echo $this->Form->input("id");
?>
<div class='row-fluid'>
	<div class='span6'>
		<?php 
				
		?>
	</div>
	<div class='span6'>
		<?php foreach($this->request->data['UserAssignedPost'] as $p): ?>
		
		<?php endforeach; ?>
	</div>
</div>
<?php $this->Form->end(); ?>