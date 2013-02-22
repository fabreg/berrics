<script>
	jQuery(document).ready(function($) {
		
	
	

	});


	function addUnifiedEmployee() {

		$('body').append("<div class='modal hide' id='add-new-employee'><div class='alert'>Loading.....</div></div>");
		
		var $modal = $("#add-new-employee");
		
		var url = "<?php echo $this->Html->url(array('action'=>'add_new_employee',$this->request->data['UnifiedStore']['id'])) ?>";
		

		$modal.on('shown',function() {

			$.ajax({

				"url":url,
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
<div style='padding:15px;'>
	<button class="btn btn-success" type='button' onclick='addUnifiedEmployee(); return false;'>Add New Employee</button>
</div>
<div class="row-fluid">
	<div class="span12">
		<table cellspacing="0">
			<thead>
				<tr>
					<th>Image</th>
					<th>Name</th>
					<th>Title</th>
					<th>Social Networking</th>
					<th>-</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->request->data['UnifiedStoreEmployee'] as $k => $v): ?>
				<tr>
					<td></td>
					<td><?php echo $v['name']; ?></td>
					<td><?php echo $v['title']; ?></td>
					<td>
						<div></div>
						<div></div>
						<div></div>
					</td>
					<td></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
