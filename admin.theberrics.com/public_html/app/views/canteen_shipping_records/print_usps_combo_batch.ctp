<?php 

	foreach($records as $record):
	$this->set(compact("record"));
	echo $this->element("canteen_printing/usps-combo-label");
?>
<div style='page-break-after:always;'></div>
<?php endforeach; ?>