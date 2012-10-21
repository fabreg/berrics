<script type='text/javascript'>
$(document).ready(function() { 

	$("#inventory-search form").ajaxForm({

		success:function(d) { 

			$("#search-results").html(d);

		},
		beforeSubmit:function() { 
			$("#search-results").html("Searcing Users.....");
		}
		
	});

	
});
</script>
<div class='index form'>
	<div style='text-align:right; padding:10px;'><a href='javascript:InventorySearch.closeModal();' style='color:black;'>[X] Close</a></div>

	<fieldset>
		<legend>Search Inventory Records</legend>
		<div id='inventory-search'>
			<?php 
				echo $this->Form->create("CanteenInventoryRecord",array("url"=>"/canteen_inventory_records/inventory_modal_search_results"));
				echo $this->Form->input("name");
				echo $this->Form->input("foreign_key");
				echo $this->Form->end("Search");
			?>
		</div>
	</fieldset>
		<div style='text-align:right; padding:10px;'><a href='javascript:InventorySearch.closeModal();' style='color:black;'>[X] Close</a></div>
	
	<div id='search-results'>
	
	</div>
	
</div>