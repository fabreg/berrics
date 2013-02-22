<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		var h = getQueryVariable("tab");

		if(h.length <= 0) h = "general";

		$('.nav-tabs a[href="#'+h+'"]').tab('show');
		

		//tab events
		$('ul li a[data-toggle=tab]').on('shown',function(e) { 
	
			var $id = $(e.target).attr("href");

			$id = $id.replace(/#/,'');
			
			$('input[name=tab]').val($id);

		});

	});
</script>
<div class="page-header">
	<h1>Edit Unified Store</h1>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#general" data-toggle="tab">General Info</a></li>
		<li><a href="#hours" data-toggle="tab">Store Hours</a></li>
		<li><a href="#employees" data-toggle="tab">Employees</a></li>
		<li><a href="#media-items" data-toggle="tab">Media Items</a></li>
		<li><a href="#billing" data-toggle="tab">Billing Info</a></li>
	</ul>
	<?php echo $this->Form->create('UnifiedStore',array(
		"id"=>'UnifiedStoreForm',
		"url"=>$this->request->here,
		"enctype"=>"multipart/form-data"
	)); ?>
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<h3>General Info</h3>
			<?php echo $this->element("unified/edit-general"); ?>
		</div>
		<div class="tab-pane" id="hours">
			<h3>Store Hours</h3>
			<?php echo $this->element("unified/edit-store-hours"); ?>
		</div>
		<div class="tab-pane" id="employees">
			<h3>Employees</h3>
			<?php echo $this->element("unified/edit-employees") ?>
		</div>
		<div class="tab-pane" id="media-items">
			<h3>Media Items</h3>
			<?php echo $this->element("unified/edit-media"); ?>
		</div>
		<div class="tab-pane" id="billing">
			<h3>Billing</h3>
			<?php echo $this->element("unified/edit-media"); ?>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn btn-primary" name='submit-btn'>
			Update Store
		</button>
	</div>
	<input type="hidden" value='general' name='tab' />
	<?php echo $this->Form->end(); ?>
</div>
<pre>
<?php print_r($this->request->data) ?>
</pre>

