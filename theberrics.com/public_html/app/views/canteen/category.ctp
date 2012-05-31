<?php 



$this->Html->script(array("jquery.form","jquery.lazyload","category"),array("inline"=>false));

?>
<style>
.canteen-product-thumb,.canteen-product-super-thumb {

	float:left;
	margin-left:3px;
	margin-bottom:3px;
}

</style>
<div style='height:15px;'></div>
<div id='canteen-category'>
	<!-- 
	<div>
		<div id='canteen-crumb'>
			<div class='left'></div>
			<div class='right'></div>
			<div class='center'><h1><?php echo strtoupper($category['Parent']['name']); ?> // <?php echo strtoupper($category['CanteenCategory']['name']); ?></h1></div>
		</div>
		<div style='clear:both;'></div>
	</div>
	-->
	<div class='products'>
		<!-- 
		<div>
		<div id='canteen-crumb'>
			<div class='left'></div>
			<div class='right'></div>
			<div class='center'><h1><?php echo strtoupper($category['Parent']['name']); ?> // <?php echo strtoupper($category['CanteenCategory']['name']); ?></h1></div>
		</div>
		<div class='total-items'>
			<?php echo count($products); ?> Items
		</div>
		<div style='clear:both;'></div>
		</div>
		-->
		<div style='padding:5px; text-align:left;'>
		<h2><?php echo $category['Parent']['name']; ?> // <?php echo $category['CanteenCategory']['name']; ?></h2>
		</div>
		<div class='container'>
			<div class='container-top'>
				<div class='inner'>
					<?php 
						foreach($products as $p):
					?>
						<?php echo $this->element("canteen/product-super-thumb",array("product"=>$p)); ?>
					<?php 
						endforeach;
					?>
				<div style='clear:both;'></div>
				</div>
			</div>
		</div>
	</div>
	<div class='sorting'>
		<div class='heading'>
			<div class='inner'>
				FILTER PRODUCTS
			</div>
		</div>
		<div class='inner'>
			<?php echo $this->Form->create("CanteenProduct",array("url"=>$this->here,"id"=>"filter-form")); ?>
			<div class='filter-menu'>
				<div class='filter-heading'> // BRANDS</div>
				<div class='filter-options'>
					<?php 

						foreach($filters['Brand'] as $b) echo $this->Form->input("Brand.{$b['id']}",array("type"=>"checkbox","label"=>$b['name']));
 			
					?>
				</div>
			</div>
			<?php foreach($filters['Meta'] as $k=>$v): ?>
			<div class='filter-menu'>
				<div class='filter-heading'> // <?php echo strtoupper($k); ?></div>
				<div class='filter-options'>
					<?php 
						foreach($v as $key=>$val) echo $this->Form->input("Meta.{$key}",array("type"=>"checkbox","label"=>$val));
					?>
				</div>
			</div>
			<?php endforeach; ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
	<div style='clear:both;'></div>
	<div class='bottom'>
		<div class='left'></div>
		<div class='right'></div>
		<div style='clear:both;'></div>
	</div>
</div>