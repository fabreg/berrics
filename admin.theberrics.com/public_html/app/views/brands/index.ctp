<div class="brands index form">
	<h2><?php __('Brands');?></h2>
	<div>
		<fieldset>
			<legend>Search</legend>
			<div>
				<?php 
				
					echo $this->Form->create("Brand",array("url"=>"/brands/search"));
					echo $this->Form->input("name");
					echo $this->Form->end("Search");
				?>
			</div>
		</fieldset>
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
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
		<td><?php echo $brand['Brand']['website_url']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $brand['Brand']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $brand['Brand']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $brand['Brand']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $brand['Brand']['id'])); ?>
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