<script>
$(document).ready(function() { 

	$(".dailyop-media-item").each(function() { 

		var rel = $(this).attr("media_type");

		switch(rel) {

			case "bcove":
				dailyopVideoDiv(this);
			break;
		
		}

	});
	
});

function dailyopVideoDiv(e) {

	$(e).css({

		"position":"relative"

	}).append("<div class='video-options'>Video Options:</div><div class='video-overlay'></div><div class='video-hover'></div>");

	$(e).find('.video-hover').css({

		"width":"728px",
		"height":"500px",
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"z-index":"6000",
		"background-image":"url(/theme/website/img/satin-px.png)"
		

	}).hide();

	$(e).find(".video-overlay").css({

		"width":"728px",
		"height":"500px",
		"position":"absolute",
		"top":"0px",
		"left":"0px",
		"z-index":"6001",
		"background-image":"url(/theme/website/img/play-button-bg.png)",
		"background-repeat":"no-repeat",
		"background-position":"center center"

	});

	$(e).hover(
		function() {

			$(this).find(".video-hover").fadeIn("normal");
			$(this).find(".video-options").fadeIn("normal");
			
		},
		function() {

			$(this).find(".video-hover").fadeOut("normal");
			$(this).find(".video-options").fadeOut("normal");
			
		}
	).click(function() { 

		var href = $(this).find("a:eq(0)").attr("href");

		document.location.href = href+"?autoplay";
		
	});

	
	
	
	
}
</script>
<div>
	
	<?php 
	
		foreach($posts as $post):
	
	?>
	
	<?php 
	
		echo $this->element("dailyops/post-bit",array("dop"=>$post));
	
	?>
	
	<?php 
	
		endforeach;
	
	?>

</div>
<?php 

echo $this->element("dailyops/archive-menu");

?>
