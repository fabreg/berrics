<script>
$(document).ready(function() { 

	$("#convert-currency-button").click(function() { 

		var val = $('input[name=amount_left]').val();
		var from = $('select[name=currency_left]').val();
		var to = $('select[name=currency_right]').val();
		//alert(val);
		val = val.replace(/[^0-9\.]/,'');
		
		if(val>0) {

			$.get("/currencies/ajax_convert/"+from+"/"+to+"/"+val,function(d) { 

				$('input[name=amount_right]').val(d);
				
			});
			
		} else {

		}

	});

	$('select[name=currency_left] option[value=USD]').attr({
		"selected":"selected"
	});
	
});
</script>
<style>
#currency-converter {

	position:fixed;
	top:200px;

}
#currency-converter .select select {

	width:200px;

}
</style>
<div>

	<div style='float:left; width:40%;  margin-right:5%;'>
	<?php
	
		foreach($this->data['CanteenProductPrice'] as $k=>$price) {
			
			echo $this->Form->input("CanteenProductPrice.{$k}.price",array("label"=>$price['Currency']['name']));
			echo $this->Form->input("CanteenProductPrice.{$k}.id");
		}
		echo $this->Form->input("auto_calc_currencies",array("type"=>"checkbox"));
		echo $this->Form->submit("Update Pricing");
	?>
	</div>
	<div style='float:left; width:40%;'>
	
	<div id='currency-converter'>
		<h3>Currency Conversion</h3>
		<div>
			<div style='float:left; width:45%;'>
				<?php 
				
					echo $this->Form->input("currency_left",array("options"=>$currencies,"label"=>"Currency","name"=>"currency_left"));
					echo $this->Form->input("amount_left",array("name"=>"amount_left","label"=>"Amount"))
				
				?>
			</div>
			<div style='float:right; width:45%;'>
			<?php 
				
					echo $this->Form->input("currency_right",array("options"=>$currencies,"label"=>"Result Currency","name"=>"currency_right"));
					echo $this->Form->input("amount_right",array("name"=>"amount_right","label"=>"Result Amount"))
				
				?>
			</div>
			<div style='clear:both;'>
				<input type='button' value='Convert' id='convert-currency-button' />
			</div>
		</div>
	</div>
	</div>
<div style='clear:both;'></div>
</div>	
