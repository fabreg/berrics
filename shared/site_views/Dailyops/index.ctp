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
var dailyops_date;
var today_date = new Date(<?php echo strtotime(date("Y-m-d"))*1000; ?>);
jQuery(document).ready(function($) {

	$("#load-more").click(function() { 

		loadNextPosts();

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

	$.ajax({

		"url":d_str,
		"success":function(d) {

			$("#dailyops").append(d);

			initMediaDivs();
			FB.XFBML.parse();
			history.pushState({},"Dailyops",d_str);

		}

	});
	/*
	$('html, body').animate({
	    scrollTop: 105
	 }, 2000);
	*/
}
</script>

<div id="dailyops" class='clearfix'>
	<?php echo $this->element("dailyops/dailyops-index"); ?>
</div>
<div>
	<button class="btn" id='load-more'>Load More</button>
</div>