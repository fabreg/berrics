<?php 

$this->set("title_for_layout","The Berrics - MTN DEW");


 ?>
<div id="mtn-dew">
	<div class='dailyops-day' data-date='<?php echo date('Y-m-d',strtotime($dateIn)) ?>' data-next-uri='<?php echo date("/Y/m/d",strtotime("-1 Day",strtotime($dateIn))); ?>' data-timestamp='<?php echo strtotime($dateIn)*1000; ?>'>
<?php echo $this->element("banners/728") ?>
<?php 
	$lazy = true;

	foreach ($posts as $k => $v): 
?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php if ($k==2): ?>
			<?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
	<?php endif ?>
	<?php endforeach ?>
	<?php 
		$lazy = true;
		foreach ($posts['news'] as $k => $v):
	 ?>
		<?php if ($k==2): ?>
			<?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
		<?php endif ?>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php endforeach ?>
</div>
</div>