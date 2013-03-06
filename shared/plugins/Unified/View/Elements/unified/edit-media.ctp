<?php 

$categories = UnifiedStoreMediaItem::categories();

?>
<script>
jQuery(document).ready(function($) {


	

});


function uploadImage() {

	$('body').append("<div class='modal hide' id='add-new-image'><div class='alert'>Loading.....</div></div>");
	
	var $modal = $("#add-new-image");
	
	var url = "<?php echo $this->Html->url(array('controller'=>'media_item','action'=>'add_image','plugin'=>'unified',$this->request->data['UnifiedStore']['id'])) ?>";
	
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


function uploadVideo() {

	

}

function attachMediaItem() {

	

}

</script>
<style>
	
</style>
<h3>Media Items</h3>

<div class="row-fluid">
	<div class="span12">
	<?php foreach ($categories as $k => $v): ?>
	<div class="row-fluid">
		<div class="span12">
			<h5><?php echo $v ?></h5>
			<div class="well well-small">
				<button class="btn btn-success btn-mini" type='button' onclick='uploadImage();'>
					<i class="icon icon-white icon-plus-sign"></i> Upload image
				</button>
				<?php if (CakeSession::read("is_admin") == 1): ?>
				<a href="" class="btn btn-success btn-mini">
					<i class="icon icon-white icon-plus-sign"></i> Attach Video
				</a>
				<?php endif ?>
				<a href="" class="btn btn-success btn-mini">
					<i class="icon icon-white icon-upload-alt"></i> Upload Video
				</a>
			</div>
			<?php 
				//check to see if there are any media items attached to this category
				$mediaItems = Set::extract("/UnifiedStoreMediaItem[category={$k}]",$this->request->data['UnifiedStoreMediaItem']);

			?>
			<?php if (count($mediaItems)<=0): ?>
				<div class="alert alert-info">No media attached to this category</div>
			<?php else: ?>
				
			<?php endif ?>

		</div>
	</div>
	<?php endforeach ?>
	</div>
</div>