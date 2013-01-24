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
		<div class="span12">
			<div class='products column-shadow clearfix'>
				<div class="large-heading">
					<h1>
						<?php echo strtoupper($category['Parent']['name']); ?> // <?php echo strtoupper($category['CanteenCategory']['name']); ?>
					</h1>
				</div>
				<?php 
					foreach($products as $p):
				?>
					<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
				<?php 
					endforeach;
				?>
				
			</div>
		</div>
	</div>
</div>