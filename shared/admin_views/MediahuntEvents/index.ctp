<div class="mediahuntEvents index">
	<h2><?php echo __('Mediahunt Events');?></h2>
	<div>
		<div>
				<p>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
				));
				?>	</p>
			
				<div class="paging">
					<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
				 | 	<?php echo $this->Paginator->numbers();?>
			 |
					<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
				</div>
		</div>
		<div style='clear:both;'></div>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mediahuntEvents as $mediahuntEvent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $mediahuntEvent['MediahuntEvent']['id']; ?>&nbsp;</td>
		<td><?php echo $mediahuntEvent['MediahuntEvent']['created']; ?>&nbsp;</td>
		<td><?php echo $mediahuntEvent['MediahuntEvent']['name']; ?>&nbsp;</td>
		<td align='center'>
			<?php 
			
				switch($mediahuntEvent['MediahuntEvent']['active']) {
					
					case 1:
						echo "<span style='color:green;'>Active</span>";
					break;
					default:
						echo "<span style='color:red;'>In-Active</span>";
					break;
					
				}
			
			?>
		</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $mediahuntEvent['MediahuntEvent']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $mediahuntEvent['MediahuntEvent']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $mediahuntEvent['MediahuntEvent']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediahuntEvent['MediahuntEvent']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
