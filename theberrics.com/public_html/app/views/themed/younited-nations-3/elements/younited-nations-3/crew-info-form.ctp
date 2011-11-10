<div class='crew-info-form'>
	<div class='heading'>
		<img alt='' border='0' src='/theme/younited-nations-3/img/crew-info-heading.jpg' />
	</div>
	<div class='info-form'>
	<?php 
	
		echo $this->Form->input("name",array("label"=>"CREW NAME"));
		echo $this->Form->input("contact_email",array("label"=>"CONTACT EMAIL"));
		echo $this->Form->input("phone_number",array("label"=>"PHONE NUMBER"));
		echo $this->Form->input("facebook_fanpage_url",array("label"=>"FACEBOOK FANPAGE"));
		echo $this->Form->input("bio",array("label"=>"BIO"));	
		
	?>
	</div>
	<div id='map' class='map'>
	
	</div>
	<div style='clear:both;'></div>
</div>