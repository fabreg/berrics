<div class="page-header">
	<h1>Edit Unified Store</h1>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#1" data-toggle="tab">General Info</a></li>
		<li><a href="#2" data-toggle="tab">Images</a></li>
		<li><a href="#3" data-toggle="tab">Store Hours</a></li>
		<li><a href="#4" data-toggle="tab">Billing Info</a></li>
		<li><a href="#2" data-toggle="tab">Address &amp; Mapping</a></li>
	</ul>
	<?php echo $this->Form->create('UnifiedStore',array(
		"id"=>'UnifiedStoreForm',
		"url"=>$this->request->here
	)); ?>
	<div class="tab-content">
		<div class="tab-pane active" id="1">
			<h3>General Info</h3>
			<?php echo $this->element("unified/edit-general"); ?>
		</div>
		<div class="tab-pane" id="2">
			<h3>Images</h3>
		</div>
		<div class="tab-pane" id="3">
			<h3>Billing Info</h3>
		</div>
		<div class="tab-pane" id="4">
			<h3>Address & Mapping</h3>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn btn-primary">
			Update Store
		</button>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
