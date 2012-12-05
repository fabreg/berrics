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





#banner1 {

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
var dailyops_date;
var today_date = new Date(<?php echo strtotime(date("Y-m-d"))*1000; ?>);
jQuery(document).ready(function($) {

	$("#dailyops .load-more-btn").bind('click',function() { 
		
		loadNextPosts();
		return false;
	});

	var col = $("#dailyops");
	$(window).scroll(function(){
	   if (col.outerHeight() == (col.get(0).scrollHeight - col.scrollTop()))
	   console.log("fic"); 
	});



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
