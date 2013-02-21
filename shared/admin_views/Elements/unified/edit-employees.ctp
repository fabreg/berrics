<script>
	jQuery(document).ready(function($) {
		
	
	

	});


	function addUnifiedEmployee() {

		$('body').append("<div class='modal hide' id='add-new-employee'><div class='alert'>Loading.....</div></div>");
		
		var $modal = $("#add-new-employee");

		

		$modal.on('shown',function() {

			$.ajax({

				"url":"<?php echo $this->Html->url(array('action'=>'add_new_employee',$this->request->data['UnifiedStore']['id'])) ?>",
				success:function(d) {
			
					$modal.html(d);

				}

			});

		});

		$modal.on('hidden',function(e) { 
			$modal.remove();
		});

		$modal.modal({

			backdrop:'static'

		});

		$modal.modal('show');

	}
</script>
<div class="row-fluid">
	<div class="span12">
		<button class="btn btn-success" type='button' onclick='addUnifiedEmployee(); return false;'>Add New Employee</button>
	</div>
</div>
