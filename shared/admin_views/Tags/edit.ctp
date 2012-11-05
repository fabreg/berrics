<div class="page-header">
	<h1>Edit Tag</h1>
	<?php 

		$cb = $this->Html->url(array("action"=>"index"));

		if(isset($this->request->params['named']['cb'])) $cb = base64_decode($this->request->params['named']['cb']);

	?>
	<a href="<?php echo $cb; ?>" class="btn btn-primary">Back To Listing</a>
</div>
<div class="tags form">
<?php echo $this->Form->create('Tag');?>
	
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	<div class="well">
		<fieldset>
			<legend>User <a href="<?php echo $this->Admin->url(array("action"=>"attach_user",$this->request->data['Tag']['id'])); ?>" class="btn btn-primary btn-small">Attach User</a></legend>
			<div class="row-fluid">
				<div class="span12">
					<?php if(!empty($this->request->data['User']['id'])): ?>
					<span><i class="icon icon-user"></i>&nbsp;
						<?php echo $this->request->data['User']['first_name']; ?> 
						<?php echo $this->request->data['User']['last_name']; ?> 
						(<em><?php echo $this->request->data['User']['email']; ?></em>)
						<a href="<?php echo $this->Admin->url(array("action"=>"remove_user",$this->request->data['Tag']['id'])); ?>" class="btn btn-danger">
							<i class="icon icon-white icon-remove"></i> Remove User
						</a>
					</span>
					<?php else: ?>
					<span class="label label-important">No User Attached</span>
					<?php endif; ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class="well">
		<fieldset>
			<legend>Brand <a href="<?php echo $this->Admin->url(array("controller"=>"brands","action"=>"attach_brand")); ?>" class="btn btn-primary btn-small">Attach Brand</a> </legend>
			<div class="row-fluid">
				<div class="span12">
					<?php if (!empty($this->request->data['Tag']['brand_id'])): ?>
						<div class='clearfix'>
							<div style="float:left;">
								<?php echo $this->Media->brandLogoThumb(array(
									"Brand"=>$this->request->data['Brand'],
									"w"=>75
								)); ?>
							</div>
							<div style='float:left;'>
								<h2><?php echo $this->request->data['Brand']['name'];  ?></h2>
							</div>
						</div>	
					<?php else: ?>
						<span class="label label-important">No Brand Attached</span>
					<?php endif ?>
				</div>
			</div>
		</fieldset>	
	</div>

	<fieldset>
		<legend>Unified Store</legend>
		<div class="row-fluid">
			<div class="span12">
				<?php if (!empty($this->request->data['Tag']['unified_store'])): ?>
					
				<?php else: ?>
					<span class="label label-important">No Store Attached</span>
				<?php endif ?>
			</div>
		</div>
	</fieldset>	
<div class="form-actions"><button class="btn btn-primary" type="submit">Update Tag</button></div>
<?php echo $this->Form->end();?>
</div>
<pre>
<?php 
print_r($this->request->data);
?>
</pre>