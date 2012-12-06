<?php 

	$this->set("title_for_layout","The Berrics - News");

?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
});
function loadNextPosts() {
	
	var nd = new Date(dailyops_date);
	nd.setDate(nd.getDate()-1);
	var d = new Date(nd);
	
	var day = d.getDate();

	if(day<10) day = "0"+day;

	var month = (d.getMonth() + 1);

	if(month<10) month = "0"+month;

	var d_str = "/"+d.getFullYear()+"/"+month+"/"+day;

	$('#dailyops .loading-div').show();

	$.ajax({

		"url":d_str,
		"success":function(d) {

			$("#dailyops .content").append(d);
			$('#dailyops .loading-div').hide();

			$(window).scrollTop($(window).scrollTop()+100);

			

			initMediaDivs();
			FB.XFBML.parse();
			history.pushState({},"Dailyops",d_str);
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
<div id="news-section">
	<div class="content">
		<?php echo $this->element("news/news-index"); ?>
	</div>
	<div class='load-more-btn'>
		<img class='visible-desktop' src="/img/v3/layout/load-more-posts-btn.png" border='0' alt="" />
		<img class='hidden-desktop' src="/img/v3/layout/load-more-posts-btn-mobile.png" border='0' alt="" />
	</div>
</div>