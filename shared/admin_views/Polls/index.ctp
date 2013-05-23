<div class="page-header">
	<h1>Polls</h1>
</div>
<?php echo $this->Admin->adminPaging(); ?>
<div>
	<ul class='nav nav-tabs'>
		<li class='dropdown'>
			<a href='#' rel='noAjax' data-toggle='dropdown' class="dropdown-toggle">Actions <b class='caret'></b></a>
			<ul class='dropdown-menu'>
				<li>
					<a rel='noAjax'  href='<?php echo $this->Html->url(array("action"=>"add","controller"=>"polls","plugin"=>"")); ?>'><i class='icon icon-plus-sign'></i> Add New Poll</a>
				</li>
			</ul>
		</li>
	
	</ul>
	<div class='tab-content'>
		
	</div>
</div>
<div class="polls index">

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('website_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($polls as $poll): ?>
	<tr>
		<td><?php echo h($poll['Poll']['id']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['modified']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['end_date']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['name']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['active']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($poll['Website']['name'], array('controller' => 'websites', 'action' => 'view', $poll['Website']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $poll['Poll']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $poll['Poll']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $poll['Poll']['id']), null, __('Are you sure you want to delete # %s?', $poll['Poll']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Admin->adminPaging(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Poll'), array('action' => 'add')); ?></li>
		
	</ul>
</div>
