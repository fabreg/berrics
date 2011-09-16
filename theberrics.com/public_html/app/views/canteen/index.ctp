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