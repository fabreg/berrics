<style>

.featured-brand {


}

.featured-brand .logo {

	float:left;

}

.featured-brand .canteen-product-thumb {

	float:left;
	margin-right:5px;

}

</style>
<div id='canteen-home'>
	<div>
	
	
	</div>
	<div class='featured-brand'>
		<div class='logo'>
			<?php echo $this->Media->brandLogoThumb(array(
				"Brand"=>$featured_brand['Brand'],
				"h"=>"150",
				"canteen"=>true
			)); ?>
		</div>
		<?php foreach($featured_brand['Products'] as $v): ?>
		<?php echo $this->element("canteen/product-thumb",array("product"=>$v)); ?>
		<?php endforeach; ?>
		<div style='clear:both;'></div>
	</div>
	<div class='featured-brands'>
		
	</div>
	<div class='featured-products'>
		<?php foreach($featured as $v): ?>
		<?php $c .= $this->element("canteen/product-thumb",array("product"=>$v)); ?>
		<?php endforeach; ?>
		<?php echo $this->element("paper1",array("content"=>$c)); ?>
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