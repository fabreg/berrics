<script>

var check = false;
var request = false;

$(document).ready(function() { 

	
	$("#CanteenShippingRecordLookup").bind('keyup change',function() { 

		check = setTimeout("lookupNumber()",700);
		
		
	});

	
});

function lookupNumber() {

	if(request) request.abort();
	
	$("#result").html("<div style='text-align:center;'>Processing your request.....</div>");

	request = $.ajax({

		"url":"/canteen_shipping_records/ajax_lookup",
		"type":"post",
		"success":function(d) {

			$("#result").html(d);

		},
		"data":{
			"data":{
				"lookup":$("#CanteenShippingRecordLookup").val()
			}
		}

	});
	
}
</script>
<div class='form index'>
	<fieldset>
		<legend>Lookup a shipping record</legend>
		<?php
		
			echo $this->Form->create("CanteenShippingRecord");
			echo $this->Form->input("lookup");
			echo $this->Form->end();
		
		?>
	</fieldset>
	<div style='height:20px;'></div>
	<fieldset>
		<legend>Result</legend>
		<div id='result'>
		
		</div>
	</fieldset>
</div>
