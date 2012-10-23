<style>
.brand-thumb {
	
	background-image:url(/img/layout/canteen/brand-thumb-bg.png);
	height:171px;
	width:231px;
	float:left;
	margin:5px;
	text-align:center;
}

.brand-thumb img {

	margin-top:8px;

}


</style>
<div id='brands-listing'>
	<?php foreach($brands as $b): ?>
	<div class='brand-thumb'>
		<?php echo $this->Media->brandLogoThumb(array(
				"Brand"=>$b['Brand'],
				"h"=>"160",
				"w"=>"210",
				"canteen"=>true
			)); ?>
	</div>
	<?php endforeach; ?>
	<div style='clear:both;'></div>
</div>