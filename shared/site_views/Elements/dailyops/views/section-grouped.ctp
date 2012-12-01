<?php 

$grouped = array();

foreach ($posts as $k => $v) {
	
	$d = date('Y-m-01',strtotime($v['Dailyop']['publish_date']));

	$grouped[$d][] = $v;

}

?>
<?php 
	foreach ($grouped as $k => $v): 
	$v = array_reverse($v);
?>
	<h3><?php echo date('F Y',strtotime($k)) ?></h3>
	<div class="thumb-collection clearfix">
		<?php foreach ($v as $key => $val): ?>
			<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$val)); ?>
		<?php endforeach ?>
	</div>
<?php endforeach ?>