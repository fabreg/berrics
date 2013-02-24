<script>
	jQuery(document).ready(function($) {
			
		$("#time").timepicker({
			showPeriod:true
		});

	});

	function addStoreHourEntry() {

		$('body').append("<div id='add-store-hour' class='modal hide'><div class='alert'>Loading.....</div></div>");

		var $modal = $("#add-store-hour");

		var url = "";

		if(arguments[0]) {
	
	
		}

		$modal.on('shown',function() { 
			
			$.ajax({

				url:url,
				success:function(d) {

					$modal.html(d);

				}

			});

		});

		$modal.on('hidden',function() { 
			$modal.remove();
		});

		$modal.modal({
	
			"backdrop":"static"

		});

		$mdoal.modal('show');

	}
</script>
<div style='padding:8px;'>
	<button class="btn btn-success"><i class="icon icon-white icon-plus-sign"></i> Add New Entry</button>
</div>
<div class="row-fluid">
	<div class="span6">
		<table cellspacing='0'>
			<tr>
				<td><input type='text' id='time' /></td>
				<td></td>
			</tr>
		</table>
	</div>
</div>