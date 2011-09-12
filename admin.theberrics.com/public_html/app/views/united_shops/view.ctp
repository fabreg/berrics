<div class="unitedShops view">
<h2><?php  __('United Shop');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit United Shop', true), array('action' => 'edit', $unitedShop['UnitedShop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete United Shop', true), array('action' => 'delete', $unitedShop['UnitedShop']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $unitedShop['UnitedShop']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List United Shops', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New United Shop', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
