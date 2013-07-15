<?php 
ClassRegistry::init("UnifiedStoreHour");
$dow = UnifiedStoreHour::daysOfWeek();

?>
<script>
	jQuery(document).ready(function($) {
			
		$("#time").timepicker({
			showPeriod:true
		});
		
		initTimeRows();

	});

	function initTimeRows() {

		var $table = $("#store-hours-table tbody");

		$table.find("tr").each(function() { 
		
			var $row = $(this);

			var $check = $row.find("input[type=checkbox]:eq(0)");
			
			if($check.is(":checked")) {

				$row.find('select').each(function() { 
					$(this).attr("disabled",false);
				});
				
			} else {
				
				$row.find('select').each(function() { 
					$(this).attr("disabled","disabled");
				});

			}

			$check.unbind().bind('change',function() {

				initTimeRows();

			});

		});

	}

	function addCustom() {

		$('body').append("<div id='add-store-hour' class='modal hide'><div class='alert'>Loading.....</div></div>");

		var $modal = $("#add-store-hour");

		var url = "<?php echo $this->Html->url(array("action"=>"add_custom","controller"=>"hours",$this->request->data['UnifiedStore']['id'])); ?>";

		$modal.on('shown',function() { 
			
			$.ajax({

				url:url,
				success:function(d) {

					$modal.html(d);
					initBootstrap();
				}

			});

		});

		$modal.on('hidden',function() { 
			$modal.remove();
		});

		$modal.modal({
	
			"backdrop":"static"

		});

		$modal.modal('show');

	}
</script>
<style>
#store-hours-table {

	

}
#store-hours-table .control-group {

	margin:0;

}

.time-input {


}

.time-input .help-block {

	display:none;

}

.time-input .control-group .controls select {

	width:30%;
	margin:0;

}
</style>
<div class="row-fluid">
	<div class="span6">
		<h3>Store Hours</h3>
		<?php 

			echo $this->Form->input("store_hours_text",array("help"=>"<small>(Line Breaks Are Preserved)</small>"));

		 ?>
		<table cellspacing='0' id='store-hours-table' class='table table-bordered table-rounded table-striped'>
			<tr>
				<th>Open?</th>
				<th>Day</th>
				<th>Open Time</th>
				<th>Close Time</th>
			</tr>
			<tbody>
			<?php 
				$i = 0;
				$seed = $dow;
				if(count($this->request->data['UnifiedStoreHour'])>0) $seed = $this->request->data['UnifiedStoreHour'];
				foreach ($seed as $k => $v):
				if(is_array($v) && !array_key_exists($v['day_of_week'], $dow)) continue; 
			?>
			<tr>
				<td width='1%' style='text-align:center;'>
					<?php echo $this->Form->input("UnifiedStoreHour.{$i}.open",array("label"=>false)); ?>
				</td>
				<td width='1%'>
					<?php 
						if(is_array($v)) {

							echo $dow[$v['day_of_week']];
							echo $this->Form->input("UnifiedStoreHour.{$i}.id");

						} else {

							echo $v;
							echo $this->Form->input("UnifiedStoreHour.{$i}.day_of_week",array("value"=>$k,"type"=>"hidden"));

						}	
					?>
				</td>
				<td class='time-input'>
					<?php echo $this->Form->input("UnifiedStoreHour.{$i}.hours_open",array("label"=>false)); ?>
				</td>
				<td class='time-input'>
					<?php echo $this->Form->input("UnifiedStoreHour.{$i}.hours_close",array("label"=>false)); ?>
				</td>
			</tr>
			<?php 
				$i++;
				endforeach;
			?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<h3>Custom Dates
		<div>
			<button class="btn btn-success btn-mini" type='button' onclick='addCustom();'>
			<i class="icon icon-white icon-plus-sign"></i> New Custom Date
		</button>
		</div>
		</h3>
		
		<div>
			<small>
					* Use this for holiday's and special occasions.
					IE: Christmas Eve, Christmas Day
			</small>
		</div>
		<?php 

			//extract all the custom labels
			$customLabels = array();
			foreach($this->request->data['UnifiedStoreHour'] as $k=>$v) if(empty($v['day_of_week'])) $customLabels[] = $v;

		?>
		<?php if (count($customLabels)<=0): ?>
			<div class="alert">No Custom Labels Have Been Entered</div>
		<?php else: ?>
			<table cellspacing="0">
				<thead>
					<tr>
						<th>Open?</th>
						<th>Label</th>
						<th>Date</th>
						<th>Open Time</th>
						<th>Close Time</th>
						<th>-</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($customLabels as $k => $v): ?>
					<tr>
						<td width='1%'>
							<?php if ($v['open']): ?>
							<span class="label label-success">
								Open
							</span>
							<?php else: ?>
							<span class="label label-important">
								Closed
							</span>
							<?php endif ?>
						</td>
						<td>
							<?php echo $v['custom_label']; ?>
						</td>
						<td>
							<?php echo $this->Time->niceShort($v['custom_date']); ?>
						</td>
						<td>
							<?php echo $this->Berrics->unifiedStoreTime($v['hours_open']) ?>
						</td>
						<td>
							<?php echo $this->Berrics->unifiedStoreTime($v['hours_close']) ?>
						</td>
						<td>
							<button class="btn btn-danger" name='submit-btn[delete-store-hour-label]' value='<?php echo $v['id']; ?>' onclick='return confirm("Are you sure you want to delete this label?");'>
								<i class="icon icon-white icon-remove-sign"></i> Delete
							</button>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		<?php endif ?>
	</div>
</div>