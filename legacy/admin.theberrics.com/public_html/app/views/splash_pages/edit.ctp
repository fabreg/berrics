
<script>


$(document).ready(function() { 


	$( "#SplashPagePubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#SplashPagePubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

	
});

</script>
<style>
#SplashPageCss,#SplashPageJavascript,#SplashPageBodyContent,#SplashPageHeadContent {

	height:300px;

}
</style>
<div class="splashPages form">
<?php echo $this->Form->create('SplashPage');?>
	<fieldset>
 		<legend><?php __('Edit Splash Page'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('active');
		echo $this->Form->input('promo');
		echo $this->Form->input('pub_date',array("type"=>"text","label"=>"Publish Date"));
		echo $this->Form->input('pub_time',array("type"=>"text","label"=>"Publish Time"));
		echo $this->Form->input('page_title');
		echo $this->Form->input('meta_keywords');
		echo $this->Form->input('meta_description');
		echo $this->Form->input('css');
		echo $this->Form->input('javascript');
		echo $this->Form->input('body_content');

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
