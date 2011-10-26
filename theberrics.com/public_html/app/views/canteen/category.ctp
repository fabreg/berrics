<style>
.canteen-product-thumb {

	float:left;
	margin-left:10px;
	margin-bottom:10px;
}

</style>
<script type='text/javascript'>
$(document).ready(function() { 


	$('.canteen-product-thumb').hover(
		function() { 

			$(this).find('.info').fadeIn();
			
		},
		function() { 

			$(this).find('.info').hide();
			
		}
	).click(function() { 

		var ref = $(this).find("a").attr("href");

		document.location.href = ref;
		
	});

	$('.canteen-product-thumb a').click(function() { 

		return false;

	});


	$("#reveal").click(function() { 

		$('.canteen-product-thumb').each(function() { 

			$(this).find('.info').toggle('slow');
			
		});
		
	});

	$('#filter-form input').change(function() { 

		$("#filter-form").submit();

	});
		
});
</script>
<div style='height:15px;'></div>
<div id='canteen-category'>
	<div class='products'>
		<div>
		<div id='canteen-crumb'>
			<div class='left'></div>
			<div class='right'></div>
			<div class='center'><h1><?php echo strtoupper($category['Parent']['name']); ?> // <?php echo strtoupper($category['CanteenCategory']['name']); ?></h1></div>
		</div>
		<div style='clear:both;'></div>
		</div>
	
		<?php 
			foreach($products as $p):
		?>
			<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
		<?php 
			endforeach;
		?>
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
</div>

<?php
print_r($metas);
pr($products);
?>
