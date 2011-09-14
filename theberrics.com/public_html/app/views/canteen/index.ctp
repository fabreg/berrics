<div id='canteen-product-thumbs'>
<?php foreach($products as $p): ?>
<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
<?php endforeach; ?>
</div>
<div>

<?php foreach($products as $p): ?>

<div><a href='/canteen/item/<?php echo $p['CanteenProduct']['uri']; ?>'><?php echo $p['CanteenProduct']['name']; ?></a></div>

<?php endforeach; ?>
</div>
<pre>
<?php print_r($this->Session->read()); ?>
</pre>