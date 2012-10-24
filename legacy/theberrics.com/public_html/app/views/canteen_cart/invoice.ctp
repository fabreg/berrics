

<div style='width:728px; float:left;'>
<?php 

$invoice = $this->element("canteen/invoice");

echo $this->element("paper1",array("content"=>$invoice));

?>
</div>
<div style='float:right; width:300px;'>
	<?php echo $this->element("layout/right-banners"); ?>
</div>
<div style='clear:both;'></div>