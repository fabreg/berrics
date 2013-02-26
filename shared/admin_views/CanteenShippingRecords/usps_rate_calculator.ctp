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

<div class="page-header">
	<h1>USPS Rate Calculator</h1>
</div>
<div class="row-fluid">
	<div class="span6">
	<div class="well well-small">
							<h3>
				Domestic Rate
			</h3>
			<?php 
					echo $this->Form->create("CalcRate",array("url"=>"/canteen_shipping_records/usps_rate_calculator",'id'=>'dom-rate-form'));
					echo $this->Form->input("origin_zip");
					echo $this->Form->input("dest_zip");
					echo $this->Form->input("weight",array("label"=>"Weight ( IN LBS )"));
					echo $this->Form->input("command",array("type"=>"hidden","value"=>"dom"));
					echo $this->Form->end("Calculate");
				?>
	</div>
	<div class="well well-small">
					<h3>
				International Rate
			</h3>
			<?php 
					echo $this->Form->create("CalcRate",array("url"=>"/canteen_shipping_records/usps_rate_calculator",'id'=>'int-rate-form'));
					echo $this->Form->input("origin_zip");
					echo $this->Form->input("country",array("options"=>Arr::countries()));
					echo $this->Form->input("weight",array("label"=>"Weight ( IN LBS )"));
					echo $this->Form->input("command",array("type"=>"hidden","value"=>"int"));
					echo $this->Form->end("Calculate");
				?>
	</div>
	</div>
	<div class="span6">
					<h3>Rate Results</h3>
			<div id='dom-result'>
			
			</div>
	</div>
</div>
