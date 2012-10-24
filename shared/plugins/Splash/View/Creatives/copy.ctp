<div class="page-header">
	<h1>Copy Splash Creative</h1>
</div>
<div>
	<h3>
		<?php echo $creative['SplashCreative']['page_title'] ?>
	</h3>
</div>
<?php echo $this->Form->create('SplashCreative'); ?>
	<?php 
		echo $this->Form->input("page_title",array("label"=>"New Page Title"));
		echo $this->Form->input("copy_id",array("type"=>"hidden","value"=>$creative['SplashCreative']['id']));
	 ?>
<div class="form-actions"><button class="btn btn-primary" type="submit">Create a copy</button></div>
<?php echo $this->Form->end(); ?>