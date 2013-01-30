<div class="systemMessages index">
	<h2><?php echo __('System Messages');?></h2>
	<div class='form'>
		<fieldset>
			<legend>Filter Messages</legend>
			<?php 
				echo $this->Form->create("SystemMessage",array("url"=>"/system_messages/search"));
				echo $this->Form->input("category",array("options"=>$catSelect));
				echo $this->Form->end("Go");
			?>
		</fieldset>
	</div>
	<?php echo $this->Admin->adminPaging(); ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('category');?></th>
			<th><?php echo $this->Paginator->sort('from');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('crontab');?></th>
			<th><?php echo $this->Paginator->sort('alert');?></th>
			
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($systemMessages as $systemMessage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $systemMessage['SystemMessage']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($systemMessage['SystemMessage']['created']); ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['category']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['from']; ?>&nbsp;</td>
		<td><?php echo $systemMessage['SystemMessage']['title']; ?>&nbsp;</td>
		<td style='text-align:center;'>
		<?php 
			switch($systemMessage['SystemMessage']['crontab']) {
				
				case 1:
					echo "<span style='color:green; font-weight:bold'>Yes</span>";
					break;
				default:
					echo "<span style='color:red;'>No</span>";
					break;
				
				
			}
		?>
		</td>
		<td style='text-align:center;'><?php 
			
			switch($systemMessage['SystemMessage']['alert']) {
				
				case 1:
					echo "<span style='color:red; font-weight:bold'>Yes</span>";
					break;
				default:
					echo "<span style='color:green;'>No</span>";
					break;
				
			}
		
		?></td>
		
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $systemMessage['SystemMessage']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $systemMessage['SystemMessage']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $systemMessage['SystemMessage']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $systemMessage['SystemMessage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	
</div>
<?php echo $this->Admin->adminPaging(); ?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('New System Message'), array('action' => 'add')); ?></li>
	</ul>
</div>