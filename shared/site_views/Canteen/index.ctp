<?php 

$title_for_layout = "The Berrics Canteen";


$this->set(compact("title_for_layout"));


?>
<script>

$(document).ready(function() { 

	
	
});
</script>
<style>

#doormat {

	background-image:url(/img/layout/canteen/home/canteen-home-top-bg.jpg);
	height:472px;
	width:1050px;
	background-repeat:no-repeat;
	margin-bottom:15px;
	cursor:pointer;
}

.main-window {

	height:396px;
	width:700px;
	float:left;
	margin-left:40px;
	margin-top:40px;
	
}
.crumbs {

	width:240px;
	float:right;
	margin-top:40px;
	margin-right:40px;
	text-align:right;
	border-left:dotted 2px #666;
}

.crumb-element {
	border:2px solid #ccc;
	border-color:transparent;
	width:220px;
	margin-bottom:8px;
	float:right;
}

.crumb-element img {

	display:block;
	padding:0px;
	margin:0px;

}

.crumb-border {

	border-color:#ccc;

}

.canteen-product-thumb {

	float:left;
	margin-left:3px;
	margin-bottom:3px;
}

.brands {

	background-image:url(/img/layout/canteen/home/brands-bg.jpg);
	height:257px;

}

.brands .inner {

	padding:12px;
	

}

.brands .inner .heading {

	text-align:center;
	font-family:'Courier';
	color:#666;
	letter-spacing:3px;
	font-size:22px;
	padding:5px;
}

.brands .brand {

	float:left;
	margin-right:10px;
	margin-left:10px;
}

</style>
<div id='canteen-index' class='column-shadow'>
	<div class="row-fluid">
		<div class="span12">
			<div id="canteen-caro" class="carousel slide">
			  <!-- Carousel items -->
			  <div class="carousel-inner">
			    
			   	<?php foreach($doormats as $k=>$d): ?>
						<div class="item <?php if($k==0) echo "active" ?>">
							<?php echo $this->Media->mediaThumb(array(
								"MediaFile"=>$d['MediaFile'],
								"w"=>700
							)); ?>
						</div>
					<?php endforeach; ?>
			  </div>
			  <!-- Carousel nav -->
			  <a class="carousel-control left" href="#canteen-caro" data-slide="prev">&lsaquo;</a>
			  <a class="carousel-control right" href="#canteen-caro" data-slide="next">&rsaquo;</a>
			</div>

		</div>
		
	</div>
	<div id="new-arrivals" class=''>
		<div class="large-heading">
			<h1>New Arrivals</h1>
		</div>
		<div class="product-thumb-collection clearfix">
			<?php foreach($new_products as $p) {
				
				echo $this->element("canteen/product-thumb",array("product"=>$p));
				
			} ?>
		</div>
	</div>
	
	
	<?php /* ?>
	<div class='brands'>
		<div class='inner'>
			<div class='heading'>FEATURED BRANDS</div>
			<div>
				<?php foreach($brands as $v): ?>
				<div class='brand'>
					<a>
						<?php echo $this->Media->brandLogoThumb(array(
							"Brand"=>$v['Brand'],
							"h"=>180,
							"canteen"=>true
						)); ?>
					</a>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php */ ?>
</div>
<?php 
//print_r($new_products);
?>