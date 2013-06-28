<?php 

$days = array(
		1=>1,
		2=>2,
		3=>3
	);

echo $this->Form->create('DailyopsConfig',array(
	"id"=>'DailyopsConfigForm',
	"url"=>$this->request->here,
	"class"=>"dailyops-config-form"
));	

ClassRegistry::init("Dailyop");		

 ?>
 <h4>Page Config</h4>
 <?php echo $this->Session->flash(); ?>
<div class="row-fluid">
	<div class="span12">
		<?php echo $this->Form->input("post_frequency",array("options"=>$days,"label"=>"# of days to show")); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php echo $this->Form->input("theme_override",array("options"=>Dailyop::returnThemes(),"empty"=>true)); ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<?php echo $this->Form->input("disable_themes"); ?>
	</div>
</div>
<button class="btn btn-primary btn-mini submit-config-btn">
	Update
</button>
<div class="progress progress-striped active hidden config-progress">
  <div class="bar" style="width: 100%;"></div>
</div>
<?php 

	echo $this->Form->input("id");
	echo $this->Form->end(); 

?>