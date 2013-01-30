<div class="unitedShops view">
<h2><?php echo __('United Shop');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $unitedShop['UnitedShop']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit United Shop'), array('action' => 'edit', $unitedShop['UnitedShop']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete United Shop'), array('action' => 'delete', $unitedShop['UnitedShop']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $unitedShop['UnitedShop']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List United Shops'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New United Shop'), array('action' => 'add')); ?> </li>
	</ul>
</div>
