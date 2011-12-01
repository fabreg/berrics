<div id='theotis-found'>
	<div>
		<img alt='' border='0' src='/theme/31-days-of-theotis/img/found-top.png' />
	</div>
	<div>
		<img alt='' border='0' src='/theme/31-days-of-theotis/img/found-middle-top.jpg' />
	</div>
	<div>
	<?php 
	
		echo $this->Form->create("UserContest",array("style"=>"float:left;","url"=>"/31-days-of-theotis/handle_fb"));
	?>
		<img alt='' border='0' src='/theme/31-days-of-theotis/img/found-middle-bottom.jpg' onclick='$(this).parent().submit();' />
	<?php
		//make the cipher
		echo $this->Form->input($this->Session->id(),array("type"=>"hidden","value"=>base64_encode(serialize(Array("session_id"=>$this->Session->id(),"dailyop_id"=>$cipher['dailyop_id'])))));
		echo $this->Form->end();
	
	?>
	</div>
	<div>
		<img alt='' border='0' src='/theme/31-days-of-theotis/img/found-bottom.png' />
	</div>
</div>