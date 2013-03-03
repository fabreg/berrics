<script type="text/javascript">
var dailyops_date;
var today_date = new Date(<?php echo strtotime(date("Y-m-d"))*1000; ?>);
jQuery(document).ready(function($) {

	$("#dailyops .load-more-btn").bind('click',function() { 
		
		loadNextPosts();
		return false;
	});

});
function loadNextPosts() {
	
	var d_str = $('.dailyops-day:last-child').attr("data-next-uri");


	$('#dailyops .loading-div').show();

	$.ajax({

		"url":d_str,
		"success":function(d) {

			$("#dailyops .content").append(d);
			$('#dailyops .loading-div').hide();

			$(window).scrollTop($(window).scrollTop()+100);

			

			initMediaDivs();
			lazyLoad();
			FB.XFBML.parse();
			//history.pushState({},"Dailyops",d_str);
			$.ajax({ url: 'https://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
		},
		"dataType":"html"

	});
	/*
	$('html, body').animate({
	    scrollTop: 105
	 }, 2000);
	*/
}
</script>

<div id="dailyops" class='clearfix'>
	<div class="content">
		<?php echo $this->element("dailyops/dailyops-index"); ?>	
	</div>
	<div class="loading-div">
	
	</div>
	<div class='load-more-btn'>
		<img class='visible-desktop' src="/img/v3/layout/load-more-posts-btn.png" border='0' alt="" />
		<img class='hidden-desktop' src="/img/v3/layout/load-more-posts-btn-mobile.png" border='0' alt="" />
	</div>
</div>
