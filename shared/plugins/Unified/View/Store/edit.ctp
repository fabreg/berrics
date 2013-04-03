<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOIaopnOYjAM917jmPKLK5Z8Spw58yIKM&sensor=false">
</script>
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
				
			if(map) {

				google.maps.event.trigger(map, 'resize');

				if(markers.length > 0) {

					map.setCenter(markers[0].getPosition());

				}

			}	
			
	
		});

		$("#UnifiedStoreForm").find('input,select').bind('change',function() { 
		
			showFormChangeAlert();

		});

	});
	function showFormChangeAlert () {
		$("#changes-alert").show();
	}
	
	function getQueryVariable(variable)
	{
	       var query = window.location.search.substring(1);
	       var vars = query.split("&");
	       for (var i=0;i<vars.length;i++) {
	               var pair = vars[i].split("=");
	               if(pair[0] == variable){return pair[1];}
	       }
	       return(false);
	}

</script>
<style>
#changes-alert {

	display: none;

}
</style>
<div class="page-header">
	<h1>Edit Unified Store</h1>
	<div>
		<?php echo $this->request->data['UnifiedStore']['shop_name']; ?>
	</div>
</div>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#general" data-toggle="tab">General Info</a></li>
		<li><a href="#location" data-toggle="tab">Location</a></li>
		<li><a href="#hours" data-toggle="tab">Store Hours</a></li>
		<li><a href="#employees" data-toggle="tab">Employees <span class="badge"><?php echo count($this->request->data['UnifiedStoreEmployee']); ?></span></a></li>
		
		<li><a href="#media-items" data-toggle="tab">Media Items <span class="badge"><?php echo count($this->request->data['UnifiedStoreMediaItem']); ?></span></a></li>
		<li><a href="#brands" data-toggle="tab">Brands <span class="badge"><?php echo count($this->request->data['UnifiedStoreBrand']) ?></span></a></li>
		<li><a href="#billing" data-toggle="tab">Billing Info</a></li>
	</ul>
	<?php echo $this->Form->create('UnifiedStore',array(
		"id"=>'UnifiedStoreForm',
		"url"=>$this->request->here,
		"enctype"=>"multipart/form-data"
	)); ?>
	<div class="row-fluid" id='changes-alert'>
		<div class="span12">
			<div class="alert alert-danger">
				Changes Have Been Detected
				<div style='padding:8px;'>
					<button class="btn btn-primary btn-mini"><i class="icon icon-white icon-edit"></i>Click Here To Save</button> 
					<a class="btn btn-danger btn-mini" href='<?php echo $this->request->here ?>'><i class="icon icon-white icon-remove-sign"></i> Cancel Changes</a>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-content">
		<div class="tab-pane active" id="general">
			<h3>General Info</h3>
			<?php echo $this->element("unified/edit-general"); ?>
		</div>
		<div class="tab-pane" id="location">
			<?php echo $this->element("unified/edit-location"); ?>
		</div>
		<div class="tab-pane" id="hours">
			<?php echo $this->element("unified/edit-store-hours"); ?>
		</div>
		<div class="tab-pane" id="employees">
			<?php echo $this->element("unified/edit-employees") ?>
		</div>
		
		<div class="tab-pane" id="media-items">
			<?php echo $this->element("unified/edit-media"); ?>
		</div>
		<div class="tab-pane" id="brands">
			<?php echo $this->element("unified/edit-brands"); ?>
		</div>
		<div class="tab-pane" id="billing">
			<h3>Billing</h3>
			<?php echo $this->element("unified/edit-media"); ?>
		</div>
	</div>
	<div class="form-actions">
		<button class="btn btn-primary" name='submit-btn[default]'>
			Update Store
		</button>
	</div>
	<input type="hidden" value='<?php echo (!isset($_GET['tab'])) ? "general":$_GET['tab'] ?>' name='tab' />
	<input type="hidden" name='submit-btn[default]' />
	<?php echo $this->Form->end(); ?>
</div>
<pre>
<?php print_r($this->request->data) ?>
</pre>

