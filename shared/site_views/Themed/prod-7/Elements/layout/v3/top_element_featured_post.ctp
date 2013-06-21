<script>
	jQuery(document).ready(function($) {
		
		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1000px, initial-scale=0"

		});


	});
</script>
<?php 

	echo $this->Html->css(array("dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>7216),1);


?>
<div class="row-fluid" id='ek2-top-row'>
	<div class="span2 hidden-phone">
		
	</div>
	<div class="span8" id='bc-post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="span2 hidden-phone">
		
	</div>
</div>
<img src='http://view.atdmt.com/AVE/view/448832600/direct;wi.1;hi.1/01/' border='0' width='1' height='1' />