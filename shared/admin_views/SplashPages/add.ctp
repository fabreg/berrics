<div class="splashPages form">
<?php echo $this->Form->create('SplashPage');?>
	<fieldset>
 		<legend><?php echo __('Add Splash Page'); ?></legend>
	<?php
		echo $this->Form->input('page_title');
		echo $this->Form->input('meta_keywords');
		echo $this->Form->input('meta_description');
		echo $this->Form->input('css');
		echo $this->Form->input('javascript');
		echo $this->Form->input('body_content');
		echo $this->Form->input('publish_date');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Splash Pages'), array('action' => 'index'));?></li>
	</ul>
</div>