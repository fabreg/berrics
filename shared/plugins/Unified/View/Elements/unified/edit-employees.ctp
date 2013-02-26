<script>
	jQuery(document).ready(function($) {
		
	
		$("#employee-table tbody").sortable({
			axis:"y"
		});
		$("#employee-table tbody").disableSelection();

		$("#employee-table tbody").on('sortupdate',function(e,u) { 

			$("#employee-table tbody tr").each(function() { 

				$(this).find("input[name*=display_weight]").val($(this).index()+1);

			});
			showFormChangeAlert();
		});

	});


	function addUnifiedEmployee() {

		$('body').append("<div class='modal hide' id='add-new-employee'><div class='alert'>Loading.....</div></div>");
		
		var $modal = $("#add-new-employee");
		
		var url = "<?php echo $this->Html->url(array('controller'=>'employees','action'=>'add',$this->request->data['UnifiedStore']['id'])) ?>";
		
		if(arguments[0]) {

			url = "<?php echo $this->Html->url(array('controller'=>'employees','action'=>'edit')) ?>/"+arguments[0];

		}

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

	function setIndex() {

		$("#employee-table tbody tr:eq(2)").index(1);

		alert($("#employee-table tbody tr:eq(2)").index(1));		

	}

</script>
<style>

</style>
<h3>
	Employee's 
	<div>
		<button class="btn btn-success btn-mini" type='button' onclick='addUnifiedEmployee(); return false;'><i class="icon icon-white icon-plus-sign"></i> Add New Employee</button>
	</div>
</h3>
<?php if (count($this->request->data['UnifiedStoreEmployee'])>0): ?>
	
<small>
	<em><strong>* Drag and drop to re-order</strong></em>
</small>
<div class="row-fluid">
	<div class="span12">
		<table cellspacing="0" id='employee-table'>
			<thead>
				<tr>
					<th>
						<i class="icon icon-reorder"></i>
					</th>
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
					<td width='1%'>
						<i class="icon icon-reorder"></i>
					</td>
					<td width='4%'>
						<?php echo $this->Media->unifiedEmployeeThumb(array(

										"UnifiedStoreEmployee"=>$v,
										"w"=>80,
										"h"=>80,
										"zc"=>1
									)); ?>
					</td>
					<td><?php echo $v['name']; ?></td>
					<td><?php echo $v['title']; ?></td>
					<td>
						<div></div>
						<div></div>
						<div></div>
					</td>
					<td>
						<div class='btn-group'>
							<button class="btn btn-primary" type='button' onclick='addUnifiedEmployee(<?php echo $v['id']; ?>); return false;'><i class="icon icon-white icon-edit"></i> Edit</button>
							<button class="btn btn-danger" name='submit-btn[delete-employee]' value='<?php echo $v['id']; ?>' onclick='return confirm("Are you sure you want to delete this employee?");'>
								<i class="icon icon-white icon-remove-sign"></i> Delete
							</button>
						</div>
						<?php 
							echo $this->Form->input("UnifiedStoreEmployee.{$k}.display_weight",array("type"=>"hidden"));
							echo $this->Form->input("UnifiedStoreEmployee.{$k}.id");
						?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<?php else: ?>
<div class="alert alert-important">
	No Employees Have Been Added
</div>
<?php endif ?>
