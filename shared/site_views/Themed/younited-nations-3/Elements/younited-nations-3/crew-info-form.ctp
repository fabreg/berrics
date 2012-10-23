<div class='crew-info-form'>
	<div class='heading'>
		<img alt='' border='0' src='/theme/younited-nations-3/img/crew-info-heading.jpg' />
	</div>
	<div class='form-help'>
		* Your Crew's Basic Info. <br />* You may update this info anytime during the contest.<br />* Fix all fields marked with a red "x"
	</div>
	<div class='info-form'>
	<?php 
	
		echo $this->Form->input("YounitedNationsPosse.name",array("label"=>"CREW NAME"));
		echo $this->Form->input("YounitedNationsPosse.country",array("label"=>"COUNTRY","options"=>Arr::countries()));
		echo $this->Form->input("YounitedNationsPosse.city_state_postal",array("label"=>"CITY, STATE OR POSTAL CODE <span class='update-map-span'>(Update Map)</span>"));	
		echo $this->Form->input("YounitedNationsPosse.phone_number",array("label"=>"PHONE NUMBER"));
		echo $this->Form->input("contact_email",array("label"=>"CONTACT EMAIL","value"=>$this->Session->read("Auth.User.email")));
		//echo $this->Form->input("facebook_fanpage_url",array("label"=>"FACEBOOK FANPAGE"));
		echo $this->Form->input("YounitedNationsPosse.geo_longitude",array("type"=>"hidden"));
		echo $this->Form->input("YounitedNationsPosse.geo_latitude",array("type"=>"hidden"));
		echo $this->Form->input("YounitedNationsPosse.geo_city",array("type"=>"hidden"));
		echo $this->Form->input("YounitedNationsPosse.geo_province",array("type"=>"hidden"));
		echo $this->Form->input("YounitedNationsPosse.geo_formatted",array("type"=>"hidden"));
		echo $this->Form->input("YounitedNationsPosse.user_id",array("type"=>"hidden"));
		
	?>
	<!-- <input type='button' id='tester' value='testing' /> -->
	</div>
	<div class='map-holder'>
		<div id='map' class='map'>
			
		</div>
		<div class='map-result'>
		
		</div>
	</div>
	<div style='clear:both;'></div>
	<div class='submit-holder'>
		
	</div>
</div>