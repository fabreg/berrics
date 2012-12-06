<?php 

	$this->set("title_for_layout","The Berrics - News");

?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('.load-more-btn').bind('click',function() { 

		loadNextPosts();

	});

});
function loadNextPosts() {
	
	var nd = new Date($('.news-collection:last-child').attr("data-date"));
	nd.setDate(nd.getDate()-1);
	var d = new Date(nd);
	
	var day = d.getDate();

	if(day<10) day = "0"+day;

	var month = (d.getMonth() + 1);

	if(month<10) month = "0"+month;

	var uri = window.location.href;

	var d_str = "/datein:"+d.getFullYear()+"-"+month+"-"+day;

	if(uri.match(/(\/datein:)([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})/)) {

		var newuri = uri.replace(/(\/datein:)([0-9]{4})(\-)([0-9]{2})(\-)([0-9]{2})/g,d_str);

	} else {

		var newuri = uri + d_str;

	}

	

	$('#newsfeed .loading-div').show();

	//return;

	$.ajax({

		"url":newuri,
		"success":function(d) {

			$("#newsfeed .content").append(d);
			$('#newsfeed .loading-div').hide();

			$(window).scrollTop($(window).scrollTop()+100);
			initMediaDivs();
			lazyLoad();
			FB.XFBML.parse();
			history.pushState({},"Dailyops",newuri);
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
<div id="newsfeed">
	<div class="content">
		<?php echo $this->element("news/news-index"); ?>
	</div>
	<div class='load-more-btn'>
		<img class='visible-desktop' src="/img/v3/layout/load-more-posts-btn.png" border='0' alt="" />
		<img class='hidden-desktop' src="/img/v3/layout/load-more-posts-btn-mobile.png" border='0' alt="" />
	</div>
</div>