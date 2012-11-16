<div class="page-header">
	<h1>Video Tasks</h1>
</div>
<div class="well">
	<?php 
		echo $this->Form->create('VideoTask',array(
			"id"=>'VideoTaskForm',
			"url"=>array("action"=>"search")
		));	

		echo $this->Form->input("task_status",array("options"=>$statusSelect,"empty"=>true));
		echo $this->Form->input("task",array("options"=>$taskSelect,"empty"=>true));
		echo $this->Form->input("server",array("options"=>$serverSelect,"empty"=>true));
		echo $this->Form->end("Filter")
	 ?>
	
</div>
<?php echo $this->Admin->adminPaging(); ?>
<div class="videoTasks index">

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('priority'); ?></th>
			<th><?php echo $this->Paginator->sort('task_status'); ?></th>
			<th><?php echo $this->Paginator->sort('model'); ?></th>
			<th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
			<th><?php echo $this->Paginator->sort("User.first_name") ?></th>
			<th><?php echo $this->Paginator->sort('task'); ?></th>
			<th><?php echo $this->Paginator->sort('server'); ?></th>
		
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($videoTasks as $videoTask): ?>
	<tr>
		<td><?php echo h($videoTask['VideoTask']['id']); ?>&nbsp;</td>
		<td><?php echo h($this->Time->niceShort($videoTask['VideoTask']['created'])); ?>&nbsp;</td>
		<td><?php echo h($this->Time->niceShort($videoTask['VideoTask']['modified'])); ?>&nbsp;</td>
		<td>
			<?php 
				switch ($videoTask['VideoTask']['priority']) {
					case 1:
						echo "<span class='label label-important'>YES</span>";
						break;
					
					default:
						echo "<span class='label label-info'>NO</span>";
						break;
				}
			 ?>
		</td>
		<td>
			<span class="label label-info"><?php echo strtoupper($videoTask['VideoTask']['task_status']);  ?></span>
		</td>
		<td><?php echo h($videoTask['VideoTask']['model']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['foreign_key']); ?>&nbsp;</td>
		
		<td><?php if (isset($videoTask['User']['id'])): ?>
			<?php echo $videoTask['User']['first_name']; ?> <?php echo $videoTask['User']['last_name']; ?>
		<?php endif ?></td>
		<td><?php echo h($videoTask['VideoTask']['task']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['server']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $videoTask['VideoTask']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $videoTask['VideoTask']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $videoTask['VideoTask']['id']), null, __('Are you sure you want to delete # %s?', $videoTask['VideoTask']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php echo $this->Admin->adminPaging(); ?>
