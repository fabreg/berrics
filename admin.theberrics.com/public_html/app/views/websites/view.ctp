<div class="websites view">
<h2><?php  __('Website');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $website['Website']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $website['Website']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $website['Website']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $website['Website']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Website', true), array('action' => 'edit', $website['Website']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Website', true), array('action' => 'delete', $website['Website']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $website['Website']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Websites', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Website', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
