<?php 

$this->Html->script(array("https://maps.googleapis.com/maps/api/js?sensor=true"),array("inline"=>false));


?>
<script type='text/javascript'>
var map,geocoder,marker = false;
$(document).ready(function() { 


	
});

</script>
<div id='younited-nations-entry'>
	<div class='entry-form-div'>
		<div class='inner'>
			<div class='container'>
				<div class='container-top'>
					<?php echo $this->Form->create("YounitedNationsEntry",array("url"=>$this->here));?>
					<div class='form-content'>
						<div class='rules'>
							<div class='heading'>RULES</div>
							<p>	
								Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah
							</p>
						</div>
						<div id='entry-form'>
							<div class='form-header'>
								
							</div>
							<div class='inner'>
								<?php echo $this->element("younited-nations-3/crew-info-form"); ?>
							</div>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
	<div></div>
	<div style='clear:both;'></div>
</div>