<?php 

$categories = UnifiedStoreMediaItem::categories();

?>
<script>
	
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
				<button class="btn btn-success btn-mini">
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