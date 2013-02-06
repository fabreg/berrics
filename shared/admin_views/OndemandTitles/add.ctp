<div class="page-header">
	<h1>Add New OnDemand Title</h1>
</div>
<div class="row-fluid">
	<div class="span6">
		<?php echo $this->Form->create('OndemandTitle',array(
			"id"=>'OndemandTitleForm',
			"url"=>$this->request->here
		)); ?>
		<?php 

			echo $this->Form->input("title");

		?>
		<div class="form-actions">
			<button class="btn btn-primary">
				Add New Title
			</button>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>