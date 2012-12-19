<?php 


$this->Html->script(array("jquery.form","category"),array("inline"=>false));

$this->set("title_for_layout",strtoupper($category['Parent']['name'])." // ".strtoupper($category['CanteenCategory']['name']));

?>

<style>
.canteen-product-thumb,.canteen-product-thumb {

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
<div id="canteen-category">
	<div class="row-fluid">
		<div class="span9">
			<div class='products column-shadow clearfix'>
				
					<?php 
						foreach($products as $p):
					?>
						<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
					<?php 
						endforeach;
					?>
				
			</div>
		</div>
		<div class="span3">
			<div class='sorting column-shadow clearfix'>
				<div class='wrapper'>
					<div class='heading'>
						
							FILTER PRODUCTS
						
					</div>
					<div class='inner'>
						<?php echo $this->Form->create("CanteenProduct",array("url"=>$this->request->here,"id"=>"filter-form")); ?>
						<div class='filter-menu'>
							<?php if(isset($_GET['data']) && count($_GET['data'])>0): ?>
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
							<?php if(isset($_GET['data']) && count($_GET['data'])>0): ?>
							<div class='reset-link'>
								<a href='/canteen/<?php echo $category['CanteenCategory']['uri']; ?>'>RESET FILTERS</a>
							</div>
							<?php endif;?>
							<div class='filter-options'>
								<?php 
									foreach($v as $key=>$val):
										echo $this->Form->input("Meta.{$key}",array("type"=>"checkbox","label"=>ucfirst($val)));
								?>
									
								<?php endforeach; ?>
							</div>
						</div>
						<?php endforeach; ?>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>