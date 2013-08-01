<div id="rg-body">
	<?php echo $content_for_layout; ?>
</div>
<?php 
if (preg_match('/(dailyops)/',$this->here)): 

$link = date("Y/m/d",strtotime("-1 Days",strtotime($dateIn)));

if(strtoupper(date("D"),strtotime($dateIn)) == "SUN") {

	$link = date("Y/m/d",strtotime("-2 Days",strtotime($dateIn)));

}

?>
<div class="load-more-button">
	<a href="<?php echo $link; ?>">
		<img src="/theme/run-and-gun/img/load-more.png" border='0' alt="">
	</a>
</div>
<?php endif; ?>