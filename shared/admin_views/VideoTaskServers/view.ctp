<div class="videoTaskServers view">
<h2><?php  echo __('Video Task Server'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($videoTaskServer['VideoTaskServer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($videoTaskServer['VideoTaskServer']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Server'); ?></dt>
		<dd>
			<?php echo h($videoTaskServer['VideoTaskServer']['server']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($videoTaskServer['VideoTaskServer']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Max Tasks'); ?></dt>
		<dd>
			<?php echo h($videoTaskServer['VideoTaskServer']['max_tasks']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Video Task Server'), array('action' => 'edit', $videoTaskServer['VideoTaskServer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Video Task Server'), array('action' => 'delete', $videoTaskServer['VideoTaskServer']['id']), null, __('Are you sure you want to delete # %s?', $videoTaskServer['VideoTaskServer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Video Task Servers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Video Task Server'), array('action' => 'add')); ?> </li>
	</ul>
</div>
