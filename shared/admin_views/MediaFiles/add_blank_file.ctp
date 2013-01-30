<div class='form'>
	<?php echo $this->Form->create("MediaFile",array()); ?>
	<fieldset>
		<legend>Add Blank Media File</legend>
		<?php if(isset($post)): ?>
		<div><div style='padding:5px; color:red; font-weight:bold; font-style:italic;'>Attaching Blank File to: </div><?php echo $post['Dailyop']['name']; ?><?php  echo (!empty($post['Dailyop']['sub_title'])) ? "-".$post['Dailyop']['sub_title']:""; ?></div>
		<?php endif; ?>
		<?php 

			echo $this->Form->input("name");
			
			if(isset($this->request->params['pass'][0])) {
				
				echo $this->Form->input("callback",array("value"=>$this->request->params['pass'][0],"type"=>"hidden"));
				
			}
			
			echo $this->Form->input("media_type",array("options"=>MediaFile::mediaFileTypes()));
			
			if(isset($post)) {
				
				echo $this->Form->input("dailyop_id",array("type"=>"hidden","value"=>$post['Dailyop']['id']));
				
			}
			
			echo $this->Form->submit("Add File");
		
		?>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>