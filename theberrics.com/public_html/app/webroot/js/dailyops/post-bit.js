$(document).ready(function() { 
	

	/*
	$('.dailyop_media_item').click(function() { 

		var media_type = $(this).attr("media_type");
		var media_file_id = $(this).attr("media_file_id");
		var pre = $(this).attr("pre");
		//pre = "0";
		var post = $(this).attr("post");
		var dailyop_id = $(this).attr("dailyop_id");
		switch(media_type) {

			case "bcove":
				
				
				if(navigator.userAgent.toLowerCase().indexOf('ipad')>-1) {
					
					
				
				} else {
					
					$(this).flash({
						swf:"/swf/BerricsPlayerTest.swf?time="+Math.random(),
						flashVars:{
							'media_file_id':media_file_id,
							'pre_roll':pre,
							'post_roll':post,
							videoAspectRatio:1,
							"dailyop_id":dailyop_id
						},
						height:400,
						width:700,
						wmode:"opaque",
						bgcolor:"#000000",
						allowfullscreen:"true"
					
					});
					$(this).unbind("click");
					
				}
				
				
				
			break;

		}
		
	
	});
	
	*/

	
	
	//swf files
	
	

	
});


function formatIpadVideo() {
	
	
	$(this).find("video").css({
		
		"background-color":"transparent"
		
	});
	
}
