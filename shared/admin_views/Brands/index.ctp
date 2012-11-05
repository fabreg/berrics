<?php if (!$this->request->is("ajax")): ?>
<div class="page-header">
	<h1>Brands</h1>
</div>
<?php endif ?>

<div class="tabbable">
	<ul class="nav nav-tabs">
		<li><a href="#1" rel='noAjax' data-toggle="tab">Search</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane" id="1">
			<div class="well well-small">
				<?php 

					echo $this->Form->create('Brand',array(
						"id"=>'BrandForm',
						"url"=>array("action"=>"search")
					));

					echo $this->Form->input("name");



				?>
				<button class="btn btn-primary" type="submit">Search Brands</button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<div class="brands index form">

	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('featured');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			
			<th><?php echo $this->Paginator->sort('image_logo');?></th>
			<th><?php echo $this->Paginator->sort('canteen_logo');?></th>
			<th><?php echo $this->Paginator->sort('website_url');?></th>
			
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($brands as $brand):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $brand['Brand']['id']; ?>&nbsp;</td>
		<td align='center'><?php
			
			switch($brand['Brand']['active']) {
				
				case 1:
					echo "<span style='color:green;'>Yes</span>";
					break;
				default:
					echo "<span style='color:red;'>No</span>";
					break;
			}
		
		?>&nbsp;</td>
		<td align='center'>
		<?php
			
			switch($brand['Brand']['featured']) {
				
				case 1:
					echo "<span style='color:green;'>Yes</span>";
					break;
				default:
					echo "<span style='color:red;'>No</span>";
					break;
			}
		
		?>&nbsp;
		</td>
		<td style='font-size:24px;'><?php echo $brand['Brand']['name']; ?>&nbsp;</td>
		<td style='height:75px;' valign='middle'>
			<?php 
				echo $this->Media->brandLogoThumb(array(
				
					"Brand"=>$brand['Brand'],
					"h"=>70
				
				)); 
			?>
		</td>
		<td style='height:75px;' valign='middle'>
			<?php 
				echo $this->Media->brandLogoThumb(array(
				
					"Brand"=>$brand['Brand'],
					"h"=>70,
					"canteen"=>true
				
				)); 
			?>
		</td>
		<td><?php echo $brand['Brand']['website_url']; ?>&nbsp;</td>
		<td class="actions">
			<?php if ($this->request->is("ajax")): ?>
				<?php echo $this->Form->create('Tag',array(
					"id"=>'TagForm',
					"url"=>$this->request->here
				));
					echo $this->Form->input("brand_id",array("type"=>"hidden","value"=>$brand['Brand']['id']));
					echo $this->Form->input("id",array("type"=>"hidden","value"=>$tag['Tag']['id']));
					echo $this->Form->button("Attach Brand");
					echo $this->Form->end();

				 ?>
			<?php else: ?>
				<?php echo $this->Html->link(__('View', true), array('action' => 'view', $brand['Brand']['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $brand['Brand']['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $brand['Brand']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $brand['Brand']['id'])); ?>
			<?php endif ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Brand', true), array('action' => 'add')); ?></li>
	</ul>
</div>