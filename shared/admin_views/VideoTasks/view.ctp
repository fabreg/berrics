<div class="videoTasks view">
<h2><?php  echo __('Video Task'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Task Status'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['task_status']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Model'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['model']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Foreign Key'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['foreign_key']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Task'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['task']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Parameter Data'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['parameter_data']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Working'); ?></dt>
		<dd>
			<?php echo h($videoTask['VideoTask']['working']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Video Task'), array('action' => 'edit', $videoTask['VideoTask']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Video Task'), array('action' => 'delete', $videoTask['VideoTask']['id']), null, __('Are you sure you want to delete # %s?', $videoTask['VideoTask']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Video Tasks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Video Task'), array('action' => 'add')); ?> </li>
	</ul>
</div>
