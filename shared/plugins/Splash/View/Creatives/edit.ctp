<style>

#SplashCreativeBodyContent,
#SplashCreativeHeadContent {

	min-height:225px;

}

</style>
<div class='page-header'>
	<h1>Edit Splash Creative</h1>
	<div>
	
	<?php 
	
		$back =  $this->Html->url(array("plugin"=>"splash","controller"=>"creatives","action"=>"index"));
	
		if(isset($this->request->params['named']['cb'])) $back = base64_decode($this->request->params['named']['cb']);
		
	?>
	<a href='<?php echo $back; ?>' class='btn btn-primary'>Back To listings</a>
	
	</div>
</div>
<?php echo $this->Form->create("SplashCreative",array("url"=>$this->here));?>
<div class='row-fluid'>
	<div class='span6'>
		<?php echo $this->Form->input("head_content"); ?>
<strong>Custom Tags</strong>		
<pre>
<strong>Insert Post</strong><small></small>
&lt;berrics type="post" post_id="5129" /&gt;
</pre>
		<?php echo $this->Form->input("body_content"); ?>
	</div>
<div class='span6'>
		<?php 
		
			echo $this->Form->input("id");
			echo $this->Form->input("active");
			echo $this->Form->input("page_title");
			echo $this->Form->input("meta_k",array("label"=>"Keywords"));
			echo $this->Form->input("meta_d",array("label"=>"Description"));
			echo $this->Form->input("directive",array("help"=>"<small>Controller::directive</small>"));
		?>
		
		
	</div>

</div>
<div class='form-actions'>
			<a href='http://dev.theberrics.com/splash/<?php echo $this->request->data['SplashCreative']['hash_key']; ?>' class='btn btn-success' target='_blank'>Preview</a>
			<button type='submit' class='btn btn-primary'>Update Creative</button>
</div>