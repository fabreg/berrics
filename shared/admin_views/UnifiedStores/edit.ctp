<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		var h = document.location.hash;

		h = h.replace(/#/,'');

		if(h.length <= 0) h = "general";

		$('.nav-tabs a[href="#'+h+'"]').tab('show');

	});
</script>
<div class="page-header">
	<h1>Edit Unified Store</h1>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#general" data-toggle="tab">General Info</a></li>
		<li><a href="#images" data-toggle="tab">Images</a></li>
		<li><a href="#hours" data-toggle="tab">Store Hours</a></li>
		<li><a href="#billing" data-toggle="tab">Billing Info</a></li>
		<li><a href="#2" data-toggle="tab">Address &amp; Mapping</a></li>
	</ul>
	<?php echo $this->Form->create('UnifiedStore',array(
		"id"=>'UnifiedStoreForm',
		"url"=>$this->request->here
	)); ?>
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<h3>General Info</h3>
			<?php echo $this->element("unified/edit-general"); ?>
		</div>
		<div class="tab-pane" id="images">
			<h3>Images</h3>
		</div>
		<div class="tab-pane" id="hours">
			<h3>Billing Info</h3>
		</div>
		<div class="tab-pane" id="billing">
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
