<script>
$(document).ready(function() { 

	$("#GatewayAccountDateStart,#GatewayAccountDateEnd").datepicker({"dateFormat":"yy-mm-dd"});

	
});
</script>
<div class='form'>
	<fieldset>
		<legend>Gateway Reporting</legend>
			<div>
				<?php 
					echo $this->Form->create("GatewayAccount",array("url"=>"/gateway_reports/view/"));
					echo $this->Form->input("GatewayAccount.id",array("options"=>$gatewayAccounts,"label"=>"Gateway Account"));
					echo $this->Form->input("date_start");
					echo $this->Form->input("date_end");
					echo $this->Form->end("Run Report");
				?>
			</div>
	</fieldset>
</div>