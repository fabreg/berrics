<div class='form'>
<fieldset>
	<legend>Update Password For: <span style='text-decoration:underline; color:#fa460f;'> <?php echo $this->data['User']['first_name']; ?> <?php echo $this->data['User']['last_name']; ?> ( <?php echo $this->data['User']['email']; ?> ) </span> </legend>
	<?php 

	echo $this->Form->create("User",array("url"=>"/users/update_password/".$this->data['User']['id']));
	echo $this->Form->input("id");
	echo $this->Form->input("passwd",array("label"=>"New Password","value"=>""));
	echo $this->Form->end("Update Password");
	
	?>
</fieldset>

</div>