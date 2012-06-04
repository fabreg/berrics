<?php 
$this->Html->script(array("jquery.cycle"),array("inline"=>false));
?>
<script>
var doormats = <?php echo json_encode($doormats); ?>;
$(document).ready(function() { 

	$("#doormat .main-window").cycle({
		pager:$(".crumbs"),
		pagerAnchorBuilder:function(i,e) {
			$('.crumbs').append("<div class='crumb-thumb-"+i+" crumb-element' index='"+i+"'><img border='0' src='"+$(e).attr("thumb")+"' /><div>");

			$('.crumb-thumb-'+i).click(function() { 

				$("#doormat .main-window").cycle(i);

			}).css({
				"opacity":.4
			});

			if(i==0) {

				$('.crumb-thumb-'+i).addClass('crumb-border');

			}
			
		},
		after:function(currSlideElement, nextSlideElement, options, forwardFlag) {

			$('.crumb-element').removeClass("crumb-border").css({
				'opacity':.4
			});
			$('.crumb-element[index='+$(nextSlideElement).attr('index')+']').addClass('crumb-border').css({
				'opacity':1
			});
			
		}
	});

	$('.doormat').click(function() { 

		var l = $(this).attr('link');

		if(l.length>0) {

			document.location.href = l;

		}
		
	});
	
});
</script>
<style>

#doormat {

	background-image:url(/img/layout/canteen/home/canteen-home-top-bg.jpg);
	height:472px;
	width:1050px;
	background-repeat:no-repeat;
	margin-bottom:15px;
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

.canteen-product-super-thumb {

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
}

</style>
<div id='canteen-home'>
	<div id='doormat'>
		<div class='main-window'>
			<?php foreach($doormats as $k=>$d): ?>
			<div class='doormat' thumb='<?php echo $this->Media->mediaThumbSrc(array("MediaFile"=>$d['MediaFile'],"w"=>220)); ?>' link='<?php echo $d['CanteenDoormat']['click_url']; ?>' index='<?php echo $k; ?>'>
				<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$d['MediaFile'],
					"w"=>700
				)); ?>
			</div>
			<?php endforeach; ?>
		</div>
		<div class='crumbs'>
		
		</div>
		<div style='clear:both;'></div>
	</div>
	<div>
		<div style='float:left; width:801px;' class='products'>
			<div class='container'>
				<div class='container-top'>
					<div class='inner'>
					<?php foreach($new_products as $p) {
						
						echo $this->element("canteen/product-super-thumb",array("product"=>$p));
						
					} ?>
					<div style='clear:both;'></div>
					</div>
				</div>
			</div>
			<div class='bottom'></div>
		</div>
		<div style='float:right;'>
			<img border='0' src='/img/layout/canteen/home/free-shipping-banner.jpg' />
			<br /><br />
			<img border='0' src='/img/layout/canteen/home/giving-back-banner.jpg' />
		</div>
		<div style='clear:both;'></div>
	</div>
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
</div>
<?php 
//print_r($new_products);
?>