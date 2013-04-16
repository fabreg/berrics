<div class="dailyopsConfigs view">
<h2><?php  echo __('Dailyops Config'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dailyopsConfig['DailyopsConfig']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($dailyopsConfig['DailyopsConfig']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Dailyops Date'); ?></dt>
		<dd>
			<?php echo h($dailyopsConfig['DailyopsConfig']['dailyops_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Post Frequency'); ?></dt>
		<dd>
			<?php echo h($dailyopsConfig['DailyopsConfig']['post_frequency']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Disable Themes'); ?></dt>
		<dd>
			<?php echo h($dailyopsConfig['DailyopsConfig']['disable_themes']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dailyops Config'), array('action' => 'edit', $dailyopsConfig['DailyopsConfig']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dailyops Config'), array('action' => 'delete', $dailyopsConfig['DailyopsConfig']['id']), null, __('Are you sure you want to delete # %s?', $dailyopsConfig['DailyopsConfig']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dailyops Configs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dailyops Config'), array('action' => 'add')); ?> </li>
	</ul>
</div>
