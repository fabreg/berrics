<?php 

$sort =array();

for($i=1;$i<=99;$i++) $sort[$i] = $i;

?>
<div class='form'>
	<fieldset>
		<legend>Edit Entry</legend>
		<?php 
		
			echo $this->Form->create("SlsEntry",array("url"=>$this->here));
			echo $this->Form->input('id');
			echo $this->Form->input("name");
			echo $this->Form->input("sort_order",array("options"=>$sort));
			echo $this->Form->input("dailyop_id",array("options"=>$postSelect,"label"=>"Dailyops Post"));
			echo $this->Form->end("Update Entry");
		?>
	</fieldset>
</div>