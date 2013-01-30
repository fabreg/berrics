<?php foreach ($posts as $k => $v): ?>
	<?php echo $this->element("layout/v3/trending-tr",array("post"=>$v)); ?>
<?php endforeach ?>