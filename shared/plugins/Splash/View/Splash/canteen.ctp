<style>
	.berrics-product {

		text-align: center;

		width: 400px;

		margin:auto;

		padding:8px;

		border-radius: 5px;

		background-color: #fff;



	}

	.berrics-product img {



	}

	.product-title {

		width:400px;
		font-family: 'universcnb';
		width:400px;
		margin: auto;
		text-align: center;
		font-size: 26px;

		margin-top:20px;

	}
	.enter {

		font-size: 34px;
		color:#000;
		text-align: center;
		margin-top:20px;

	}

	.enter a {

		color:#000;

	}
</style>
<?php 

	$this->set("title_for_layout","The Berrics Apparel Now In The Canteen");

 ?>
<div class="product-title">
	<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>'><?php echo $product['CanteenProduct']['name']; ?> - <?php echo $product['CanteenProduct']['sub_title']; ?></a>
</div>
<div class='berrics-product'>
	<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>'><?php echo $this->Media->productListThumb($product,array("w"=>400)); ?></a>
</div>
<div class="enter">
	<a href='/dailyops'> - ENTER THE BERRICS - </a>
</div>