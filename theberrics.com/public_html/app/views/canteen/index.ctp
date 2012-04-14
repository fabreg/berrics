<div id='canteen-home'>
	<div>
	
	
	</div>
	<div class='featured-brands'>
		
	</div>
	<div class='featured-products'>
		<?php foreach($featured as $v): ?>
		<?php echo $this->element("canteen/product-thumb",array("product"=>$v)); ?>
		<?php endforeach; ?>
	</div>
</div>
<div id='canteen-product-thumbs'>
	<dl>
	<?php foreach($cats as $c): ?>
		<?php if($c['CanteenCategory']['parent_id'] == 0): ?>
		<dt><?php echo $c['CanteenCategory']['name']; ?></dt>
		<?php else:?>
		<dd>-<a href='/canteen/<?php echo $c['CanteenCategory']['uri']; ?>'><?php echo $c['CanteenCategory']['name']; ?></a></dd>
		<?php endif;?>
	<?php endforeach; ?>
	</dl>
<pre>
<?php print_r($this->Session->read()); ?>
</pre>