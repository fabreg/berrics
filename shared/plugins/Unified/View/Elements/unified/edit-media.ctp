<?php 

$categories = UnifiedStoreMediaItem::categories();

?>
<script>
jQuery(document).ready(function($) {

		$(".media-tbody").sortable({
			axis:"y"
		});
		$(".media-tbody").disableSelection();

		$(".media-tbody").on('sortupdate',function(e,u) { 

			$(this).parent().find("tr").each(function() { 

				$(this).find("input[name*=display_weight]").val($(this).index()+1);

			});
			showFormChangeAlert();
		});
	

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
	<?php 
	$key = 0;
	foreach ($categories as $k => $v): ?>
	<div class="row-fluid">
		<div class="span12">
			<h5><?php echo $v ?></h5>
			<div class="well well-small">
				<a href="<?php echo $this->Admin->attachMediaUrl("UnifiedStoreMediaItem","unified_store_id",$this->request->data['UnifiedStore']['id'],$this->here."?tab=media-items",array("category"=>$k)); ?>" class="btn btn-mini btn-success">
					<i class="icon icon-white icon-plus-sign"></i> Attach Media
				</a>
				<a href="<?php echo $this->Admin->attachPostUrl("UnifiedStoreMediaItem","unified_store_id",$this->request->data['UnifiedStore']['id'],$this->here."/?tab=media-items",array("category"=>$k)); ?>" class="btn btn-success btn-mini">
					<i class="icon icon-white icon-plus-sign"></i> Attach Post
				</a>
				
			</div>
			<?php 
				//check to see if there are any media items attached to this category
				$mediaItems = Set::extract("/UnifiedStoreMediaItem[category={$k}]",$this->request->data);

				$mediaItems = Set::sort($mediaItems,"{n}.UnifiedStoreMediaItem.display_weight","asc");

			?>
			<?php if (count($mediaItems)<=0): ?>
				<div class="alert alert-info">No media attached to this category</div>
			<?php else: ?>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>Thumb</th>
							<th>Name</th>
							<th>Type</th>
							<th></th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody class='media-tbody'>
				<?php 
						
					foreach ($mediaItems as $k => $v): ?>
					
					
						<tr>
							<td width='5%'>
								<?php if (!empty($v['UnifiedStoreMediaItem']['dailyop_id'])): ?>
									<?php 

										$item = $v['UnifiedStoreMediaItem']['Dailyop']['DailyopMediaItem'][0]['MediaFile'];

										echo $this->Media->mediaThumb(array(
														"MediaFile"=>$item,
														"w"=>175,
														"h"=>100
													));
										
									?>
								<?php else: ?>
									<?php 

										echo $this->Media->mediaThumb(array(
														"MediaFile"=>$v['UnifiedStoreMediaItem']['MediaFile'],
														"w"=>175,
														"h"=>100
													));

									 ?>
								<?php endif ?>
							</td>
							<td>
								<?php if (!empty($v['UnifiedStoreMediaItem']['dailyop_id'])): ?>
									<?php echo $v['UnifiedStoreMediaItem']['Dailyop']['name']; ?>
									<?php if (!empty($v['UnifiedStoreMediaItem']['Dailyop']['sub_title'])): ?>
										<div><small>
											<?php echo $v['UnifiedStoreMediaItem']['Dailyop']['sub_title'] ?>
										</small></div> 
									<?php endif ?>	
								<?php else: ?>

								<?php endif; ?>
							</td>
							<td>
								
							</td>
							<td></td>
							<td class='actions'>
								<button class="btn btn-mini btn-danger" name='data[submit-btn][delete-media-item]' value='<?php echo $v['UnifiedStoreMediaItem']['id']; ?>'>
									<i class="icon icon-remove-sign"></i>

								</button>
								<?php 
										echo $this->Form->input("UnifiedStoreMediaItem.{$key}.display_weight",array("type"=>"text"));
										echo $this->Form->input("UnifiedStoreMediaItem.{$key}.id",array("type"=>"hidden")); 
									?>
							</td>
						</tr>
					

				<?php 
					$key++;
					endforeach; ?>
					</tbody>
				</table>
			<?php endif ?>

		</div>
	</div>
	<?php endforeach ?>
	</div>
</div>