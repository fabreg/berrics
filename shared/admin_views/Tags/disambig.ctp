<div class="page-header">
	<h1>Disambiguate User ID</h1>
</div>
<div>
	<?php 
		echo $this->Form->create('Tag',array(
			"id"=>'TagForm',
			"url"=>$this->request->here
		));
	 ?>
	 	<?php echo $this->Form->input("user_id",array("type"=>"text")) ?>
		<div class="form-actions"><button class="btn btn-primary">Run Report</button></div>

		<?php 

			echo $this->Form->end();

		 ?>
	
</div>
<div>
<pre>
<?php if (isset($res)): ?>
	<?php print_r($res); ?>
<?php endif ?>
</pre>
</div>