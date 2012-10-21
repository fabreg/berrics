<?php 

$model = $this->request->params['pass'][1];

?>
<div class='page-header'>
	<h1>Attach Media <small><?php echo $post['Dailyop']['name']; ?> - <?php echo $post['Dailyop']['sub_title']; ?></small> <a href='/dailyops/edit/<?php echo $post['Dailyop']['id']; ?>?tab=media' class='btn btn-primary'>Back to post</a></h1>
</div>
<div class='index'>
	<h3>Selected Files</h3>
	<?php echo $this->Form->create("AttachMedia",array("url"=>array("action"=>"handle_attach_media","controller"=>"dailyops"))); ?>
	<div id='selected-files' class='clearfix'>
	
	</div>
	<div class='form-actions '>
		<button class='btn btn-primary'>Attach Files</button>
		<?php 

			echo $this->Form->input("dailyop_id",array("value"=>$post['Dailyop']['id'],"type"=>"hidden"));
			
			if(isset($this->request->params['pass'][2])) {
				
				echo $this->Form->input("extra_id",array("value"=>$this->request->params['pass'][2],"type"=>"hidden"));
				
			}
			
			echo $this->Form->input("model",array("value"=>$model,"type"=>"hidden"));
			
		?>
		
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div class='index' id='ajax'>
	<?php echo $this->element("dailyops/attach_media_index"); ?>
</div>