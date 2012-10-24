<script>
$(document).ready(function() { 

	$('#dom-rate-form').ajaxForm(function(d) { 

		$("#dom-result").html(d);
		
	});

	$('#int-rate-form').ajaxForm(function(d) { 

		$("#dom-result").html(d);
		
	});
	
});
</script>
<div class='form index'>
	
	<div style='float:left; width:45%;'>
		<fieldset>
			<legend>
				Domestic Rate
			</legend>
			<?php 
					echo $this->Form->create("CalcRate",array("url"=>"/canteen_shipping_records/usps_rate_calculator",'id'=>'dom-rate-form'));
					echo $this->Form->input("origin_zip");
					echo $this->Form->input("dest_zip");
					echo $this->Form->input("weight",array("label"=>"Weight ( IN LBS )"));
					echo $this->Form->input("command",array("type"=>"hidden","value"=>"dom"));
					echo $this->Form->end("Calculate");
				?>
		</fieldset>
		<fieldset>
			<legend>
				International Rate
			</legend>
			<?php 
					echo $this->Form->create("CalcRate",array("url"=>"/canteen_shipping_records/usps_rate_calculator",'id'=>'int-rate-form'));
					echo $this->Form->input("origin_zip");
					echo $this->Form->input("country",array("options"=>Arr::countries()));
					echo $this->Form->input("weight",array("label"=>"Weight ( IN LBS )"));
					echo $this->Form->input("command",array("type"=>"hidden","value"=>"int"));
					echo $this->Form->end("Calculate");
				?>
		</fieldset>
	</div>
	<div style='float:right; width:45%;'>
		<fieldset>
			<legend>Rate Results</legend>
			<div id='dom-result'>
			
			</div>
		</fieldset>
	</div>
	<div style='clear:both;'></div>
</div>