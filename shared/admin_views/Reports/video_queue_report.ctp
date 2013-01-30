<script type="text/javascript">
	jQuery(document).ready(function($) {
		$( "#ReportStartDate,#ReportEndDate").datepicker({
			"dateFormat":"yy-mm-dd"
		});
	});
</script>
<?php if (count($videos)<=0): ?>
	<div class="label label-important label-large">No Videos</div>
<?php else: ?>
	<div class="well">
		<?php echo $this->Form->create('Report',array(
			"id"=>'ReportForm',
			"url"=>$this->request->here
		)); ?>
		<?php 

			echo $this->Form->input("title");
			echo $this->Form->input('start_date',array("value"=>date("Y-m-01")));
			echo $this->Form->input('end_date',array("value"=>date("Y-m-d",strtotime("-1 Day"))));

		 ?>
		<div class="form-actions">
			<button class="btn btn-primary">Submit Report</button>
			<a href='/media_files/clear_report_queue/<?php echo base64_encode($this->here); ?>' class="btn btn-warning">Clear Queue</a>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
	
	<table cellspacing="0">
		<?php foreach ($videos as $key => $v): ?>
		<tr>
			<td><?php echo $v['MediaFile']['name']; ?></td>
		</tr>
		<?php endforeach ?>
		
	</table>		
<?php endif ?>