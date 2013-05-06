<script type="text/javascript">
jQuery(document).ready(function($) {
	var uri = document.location.href;
	if (uri.match(/search:/)) {

		$('.tabbable a[href=#2]').tab('show');

	};
});

</script>
<div class="page-header">
	<h1>Unified Stores</h1>
</div>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class='dropdown'>
			<a href="#" data-toggle="dropdown">Actions <b class='caret'></b></a>
			<ul class="dropdown-menu">
				<li>
					<a href="<?php echo $this->Admin->url(array("action"=>"add")); ?>"><i class="icon icon-plus-sign"></i>  Add New Store</a>
				</li>
			</ul>
		</li>
		<li><a href="#2" data-toggle="tab">Search</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="2">
			<div class="well well-small">
				<?php 
					echo $this->Form->create('UnifiedStore',array(
						"id"=>'UnifiedStoreForm',
						"url"=>array("action"=>"search","controller"=>"store","plugin"=>"unified")
					));
				 	echo $this->Form->input("shop_name");
					
				 ?>
				 <div class="form-actons">
				 	<button class="btn btn-primary">Search</button>
				 	<a href="<?php echo $this->Html->url(array("action"=>"index")); ?>" class="btn btn-success">Reset Search</a>
				 </div>
				 <?php 
				 	echo $this->Form->end();
				  ?>
			</div>
		</div>
	</div>
</div>
<div class="unifiedStores index">

	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo  $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort('shop_name');?></th>
			<th>Image Logo</th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($unifiedStores as $unifiedStore):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $unifiedStore['UnifiedStore']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($unifiedStore['UnifiedStore']['modified']);?></td>
		<td><?php echo $unifiedStore['UnifiedStore']['shop_name']; ?>&nbsp;</td>
		
		<td>
			<?php 
				if(!empty($unifiedStore['UnifiedStore']['image_logo'])):
			?>
			<img src='http://img.theberrics.com/i.php?src=/unified-logos/<?php echo $unifiedStore['UnifiedStore']['image_logo']; ?>&w=100' />
			<br />
			<a href='http://img.theberrics.com/unified-logos/<?php echo $unifiedStore['UnifiedStore']['image_logo']; ?>' target='_blank'>FULL SIZE</a>
			<?php 
				endif;
			?>
		</td>
		<td class="actions">
			
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $unifiedStore['UnifiedStore']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $unifiedStore['UnifiedStore']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $unifiedStore['UnifiedStore']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php echo $this->Admin->adminPaging(); ?>