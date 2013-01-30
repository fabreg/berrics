<div class='page-header'>
<h1>New Splash Creative</h1>
</div>
<div class='span4'>
	<?php 
		echo $this->Form->create("SplashCreative");
		echo $this->Form->input("page_title");
		echo $this->Form->submit("Save Creative"); 
		echo $this->Form->end();
	?>
</div>