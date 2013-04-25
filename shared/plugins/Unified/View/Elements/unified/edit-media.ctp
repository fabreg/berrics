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
				<a href="<?php echo $this->Admin->attachMediaUrl("UnifiedStoreMediaItem","unified_store_id",$this->request->data['UnifiedStore']['id'],$this->here."?tab=media-items",array("category"=>$k)); ?>" class="btn btn-mini btn-success">
					<i class="icon icon-white icon-plus-sign"></i> Attach Media
				</a>
				<a href="<?php echo $this->Admin->attachPostUrl("UnifiedStoreMediaItem","unified_store_id",$this->request->data['UnifiedStore']['id'],$this->here."?tab=media-items",array("category"=>$k)); ?>" class="btn btn-success btn-mini">
					<i class="icon icon-white icon-plus-sign"></i> Attach Post
				</a>
				<a href="" class="btn btn-success btn-mini">
					<i class="icon icon-white icon-upload-alt"></i> Upload Video
				</a>
			</div>
			<?php 
				//check to see if there are any media items attached to this category
				$mediaItems = Set::extract("/UnifiedStoreMediaItem[category={$k}]",$this->request->data);

			?>
			<?php if (count($mediaItems)<=0): ?>
				<div class="alert alert-info">No media attached to this category</div>
			<?php else: ?>
				<?php foreach ($mediaItems as $k => $v): ?>
					
					<div class="media-item-thumb">
						<?php if (!empty($v['UnifiedStoreMediaItem']['dailyop_id'])): ?>
							<?php 

								$item = $v['UnifiedStoreMediaItem']['Dailyop']['DailyopMediaItem'][0]['MediaFile'];

								echo $this->Media->mediaThumb(array(
												"MediaFile"=>$item,
												"w"=>100,
												"h"=>75
											));
								pr($v);
							?>
						<?php else: ?>
							
						<?php endif ?>
					</div>

				<?php endforeach ?>
			<?php endif ?>

		</div>
	</div>
	<?php endforeach ?>
	</div>
</div>