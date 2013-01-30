<?php echo $this->Session->flash(); ?>
<?php echo $this->Form->create("Dailyop",array("url"=>array("action"=>"handle_tab_save",$this->request->data['Dailyop']['id']))); 
echo $this->Form->input("element",array("type"=>"hidden","value"=>"edit-text"));
echo $this->Form->input("id");
?>

<div class='row-fluid'>
	<div class='span6'>
		<h3>Text Content</h3>
		<?php 
		echo $this->Form->input('text_content');
		echo $this->Form->input('html_content');
		
		?>
	</div>
	<div class='span6'>
		<h3>Linking</h3>
		<?php 
		echo $this->Form->input("fb_like_uri_override",array("label"=>"FB Like URI Override (URI that will be used for Facebook) ** must start with a FORWARD SLASH / **"));
		echo $this->Form->input("url",array("help"=>"<small>** Post will click through to this URL</small>"));
		echo $this->Form->input("window_target");
		
		?>
	</div>
</div>
<div class='form-actions'>
	<?php echo $this->Form->submit("Update"); ?>
</div>
<?php echo $this->Form->end(); ?>