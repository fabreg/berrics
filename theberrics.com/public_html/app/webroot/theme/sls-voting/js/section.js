$(document).ready(function() { 
	
	var pre = new Image();
	pre.src = '/theme/sls-voting/img/loading.png';
	
	//boot strap links
	$('.play-button a').click(function() { 
		
		SlsVideo.openVideo($(this).attr("href"));
		
		return false;
		
	});
	
	
	$(window).scroll(function(e) { 
		
		if($(window).scrollTop()>400) {
		
			$('.voting-form').css({
				
				"position":"fixed",
				"top":"115px"
				
			});
			
		} else {
			
			$('.voting-form').css({
				
				"position":"static"
				
			});
		}
		
	});
	
	

	
});

var SlsVideo = {
		
		openVideo:function(uri) {
			
			$('body').append("<div id='video-overlay'><div class='inner'><div class='loading'></div></div></div>");
			
			$.ajax({
				
				"url":uri,
				"success":function(d) {
				
					berricsRelatedVideoScreen = function(media_file_id, dailyop_id) {
						
						SlsVideo.closeVideo();
						
					}
					$('#video-overlay .inner').html(d);
					
					initMediaFileDiv();
					
					$("#video-overlay .inner .sls-video-post").slideDown('slow',function() { 
						
						$('.dailyop_media_item:eq(0)').click();
						
						//$("#video-overlay").click(function() { SlsVideo.closeVideo(); });
						
					});
					
				},
				
				
			});
			
			this.handleVideoOverlay();
			
		},
		handleVideoOverlay:function() { 
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
		},
		closeVideo:function() { 
			
			$('body,html').css({
				
				"overflow":"auto"
				
			});
			
			$("#video-overlay").fadeOut("fast",function() { $("#video-overlay").remove(); });
			
		}
		
		
}