<script>
jQuery(document).ready(function($) {
	
	loadAttachedStores();

	$("#attach-store-btn").click(function() { 

		$product_id = $(this).val();

		$store_id = $("#CanteenProductStoreId").val();

		$.ajax({

			"url":"/canteen_products/attach_store",
			"type":"POST",
			data:{

				"data":{

					"canteen_product_id":$product_id,
					"unified_store_id":$store_id

				}

			},
			"success":function() {

				loadAttachedStores();

			}

		});


	});

});

function removeStoreItem($id) {

	$.ajax({
		type:"POST",
		"url":"/canteen_products/remove_store/",
		data:{

			"data":{

				id:$id

			}

		},
		success:function() {

			loadAttachedStores();

		}

	});

}

function loadAttachedStores() {

	$("#attached-store-container").html("<div class='alert'>Loading.....</div>");

	var $product_id = <?php echo $this->request->data['CanteenProduct']['id']; ?>;

	$.ajax({

		"url":"/canteen_products/attached_stores/"+$product_id,
		"success":function(d) {

			$("#attached-store-container").html(d);
			initBootstrap();
		}

	});

}
</script>
<div class="row-fluid" id='unified-stores-div'>
	<div class="span6">
		<h3>Unified Stores</h3>
		<?php echo $this->Form->input("store_id",array("options"=>$unifiedStores)); ?>
		<button class='btn btn-success' id='attach-store-btn' type='button' value='<?php echo $this->request->data['CanteenProduct']['id']; ?>'>Attach Store</button>
	</div>
	<div class="span6">
		<h3>Attached Stores</h3>
		<div id="attached-store-container">
			
		</div>
	</div>
</div>