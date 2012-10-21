<fieldset>
	<legend>Image File Linking</legend>
	<p>The following URL will be used as a link on the image in certain contexts.</p>
	<p>* Make sure to use a fully quantified URL. IE: "http://"</p>
	<?php 
	
		echo $this->Form->input("MediaFile.url");
		echo $this->Form->submit("Update");
	
	?>
</fieldset>