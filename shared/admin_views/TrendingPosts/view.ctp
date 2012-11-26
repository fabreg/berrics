<div class="trendingPosts view">
<h2><?php  echo __('Trending Post'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dailyop Id'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['dailyop_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Weight'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['display_weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Section'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['section']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Date'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['end_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($trendingPost['TrendingPost']['active']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Trending Post'), array('action' => 'edit', $trendingPost['TrendingPost']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Trending Post'), array('action' => 'delete', $trendingPost['TrendingPost']['id']), null, __('Are you sure you want to delete # %s?', $trendingPost['TrendingPost']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Trending Posts'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Trending Post'), array('action' => 'add')); ?> </li>
	</ul>
</div>
