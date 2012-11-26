<style type="text/css">
.dailyops-post {

	background-color: #e9e9e9;
	max-width:700px;
	margin:auto;
}
.large-post {

	max-width:1120px;
	margin:auto;

}



#body-row {

border-right:2px dotted #ccc;

}

#banner1 {

	margin:auto;

}

#dailyops {

	max-width:728px;
	margin:auto;

}


/*

RESPONSIVE SHIT
*/

/* Large desktop */
@media (min-width: 1200px) { 
	
}
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 


}
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {




}
 
/* Landscape phones and down */
@media (max-width: 480px) { 


}

</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('.large-post,div[data-media-file-id]').click(function(e) { 

		$(this).videoDiv();
		$(this).unbind('click');

	});

	


});
</script>

<div id="dailyops" class='clearfix'>
	<div class="banner-728" id='banner1'>
		<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
	</div>
	<?php foreach ($posts as $k => $v): ?>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)); ?>
	<?php endforeach ?>
</div>
<div>
	<button class="btn" id='load-more'>Load More</button>
</div>