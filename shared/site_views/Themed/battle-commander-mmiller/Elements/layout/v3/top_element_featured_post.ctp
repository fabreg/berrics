<?php 

	echo $this->Html->css(array("mm-dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>6806),1);


?>
<div class="row-fluid">
	<div class="span2 hidden-phone" id='shoe'>
		
	</div>
	<div class="span8" id='bc-post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="span2 hidden-phone" id='deck'>
	
	</div>
</div>
<div class="row-fluid column-shadow">
	<div class="span12">
			<table cellspacing='0' width='100%'>
				<tr>
					<td>
						<a href='/canteen/item/expedition-one-battle-commander-matt-miller-79-x-315.html'>
							<img src="/theme/battle-commander-mmiller/img/deck.jpg" alt="" border='0' />
						</a>
					</td>
					<td > 
						<a href='/canteen/item/dc-footwear-matt-miller-landau-s-bc-blackolive.html'>
							<img src="/theme/battle-commander-mmiller/img/shoe.jpg" alt="" border='0' />
						</a>
					</td>
				</tr>
			</table>
	</div>
</div>