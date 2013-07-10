<?php 

$this->layout = "canteen_printer";

?>
<div>
	<div style='height:415px; overflow:hidden;'>
		<!--  Image  -->
		<img border='0' src='http://img01.theberrics.com/shipping/<?php echo $record['CanteenShippingRecord']['id']; ?>.png' style='margin-top:-35px;' width='762' height='918' />
	</div>
	<div style='height:20px;'></div>
	<div>
		<!-- Packing List -->
		<?php echo $this->element("canteen_printing/shipping-record"); ?>
	</div>
</div>