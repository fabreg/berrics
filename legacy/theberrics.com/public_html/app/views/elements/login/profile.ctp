<div class='profile-bit'>
	<div class='name'>
		<?php echo $this->Session->read("Auth.User.first_name")." ".$this->Session->read("Auth.User.last_name"); ?>
	</div>
	<div>
		<?php echo $this->Html->link("Logout",array("controller"=>"login","action"=>"logout","plugin"=>"identity")); ?>
	</div>
</div>