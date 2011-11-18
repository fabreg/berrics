<div class='crew-info-form'>
	<div class='heading'>
		<img alt='' border='0' src='/theme/younited-nations-3/img/crew-info-heading.jpg' />
	</div>
	<div class='info-form'>
	<?php 
	
		echo $this->Form->input("name",array("label"=>"CREW NAME"));
		echo $this->Form->input("country",array("label"=>"COUNTRY","options"=>Arr::countries()));
		echo $this->Form->input("city_state_postal",array("label"=>"CITY, STATE OR POSTAL CODE"));	
		echo $this->Form->input("contact_email",array("label"=>"CONTACT EMAIL","value"=>$this->Session->read("Auth.User.email"),"disabled"=>true));
		echo $this->Form->input("phone_number",array("label"=>"PHONE NUMBER"));
		//echo $this->Form->input("facebook_fanpage_url",array("label"=>"FACEBOOK FANPAGE"));
		echo $this->Form->input("longitude",array("type"=>"hidden"));
		echo $this->Form->input("latitude",array("type"=>"hidden"));
		
	?>
	<input type='button' id='tester' value='testing' />
	</div>
	<div id='map' class='map'>
		
	</div>
	<div style='clear:both;'></div>
</div>