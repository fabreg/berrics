<?php 



$this->Html->script(array("jquery.form","jquery.lazyload","category"),array("inline"=>false));

?>
<style>
.canteen-product-thumb,.canteen-product-super-thumb {

	float:left;
	margin-left:3px;
	margin-bottom:3px;
}

.reset-link {

	text-align:center;
	padding:3px;
	
}

.reset-link a {

	font-size:16px;
	color:#999;

}

</style>
<div style='height:15px;'></div>
<div id='canteen-category'>
	<div class='products'>
		<div class='container'>
			<div class='container-top'>
				<div class='inner'>
				<h2><?php echo strtoupper($category['Parent']['name']); ?> // <?php echo strtoupper($category['CanteenCategory']['name']); ?></h2>
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
		<div class='bottom'></div>
	</div>
	<div class='sorting'>
		<div class='wrapper'>
			<div class='heading'>
				<div class='inner'>
					FILTER PRODUCTS
				</div>
			</div>
			<div class='inner'>
				<?php echo $this->Form->create("CanteenProduct",array("url"=>$this->here,"id"=>"filter-form")); ?>
				<div class='filter-menu'>
					<?php if(count($_GET['data'])>0): ?>
					<div class='reset-link'>
						<a href='/canteen/<?php echo $category['CanteenCategory']['uri']; ?>'>RESET FILTERS</a>
					</div>
					<?php endif;?>
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
					<?php if(count($_GET['data'])>0): ?>
					<div class='reset-link'>
						<a href='/canteen/<?php echo $category['CanteenCategory']['uri']; ?>'>RESET FILTERS</a>
					</div>
					<?php endif;?>
					<div class='filter-options'>
						<?php 
							foreach($v as $key=>$val) echo $this->Form->input("Meta.{$key}",array("type"=>"checkbox","label"=>ucfirst($val)));
						?>
					</div>
				</div>
				<?php endforeach; ?>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
		<div style='margin-top:-15px; padding-left:1px;'>
			<img src='/img/layout/canteen/category/filter-bg-bottom.jpg' border='0'/>
		</div>
	</div>
	<div style='clear:both;'></div>

</div>