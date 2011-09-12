
<div class='search-form'>
	<?php 
	
		echo $this->Form->create("Search",array("url"=>array("controller"=>"search","action"=>"index")));
		echo $this->Form->text("Tag",array("label"=>"Search"));
		
	?>
	<input type='submit' value='' class='search-submit' />
	<?php 
		echo $this->Form->end();
	
	?>
</div>

