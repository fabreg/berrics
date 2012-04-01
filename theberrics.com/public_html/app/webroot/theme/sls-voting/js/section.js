var st = 0;
$(document).ready(function() { 
	
	var pre = new Image();
	pre.src = '/theme/sls-voting/img/loading.png';
	
	if( 		
			navigator.userAgent.match(/Android/i)
			 || navigator.userAgent.match(/webOS/i)
			 || navigator.userAgent.match(/iPhone/i)
			 || navigator.userAgent.match(/iPod/i)
			 || navigator.userAgent.match(/BlackBerry/i)
	)
	{
			 
	
		
		
	} else {
	
		//boot strap links
		$('.play-button a').click(function() { 
			
			sc = $(window).scrollTop();
			
			SlsVideo.openVideo($(this).attr("href"));
			
			$(window).scrollTop(sc);
			
			return false;
			
		});
		

		
	}
	
	
	$(window).scroll(function(e) { 
		
		superScrollMethod();
		
	});
	
	superScrollMethod();
	
	$('form').submit(function() { 
		
		$('input[type=submit]').attr("disabled",true);
		
		return true;
		
	});
	

	
});

function superScrollMethod() {
	
	var factor = 400;
	
	if($('#scroll-chk').length>0) factor+=470;
	
	if($(window).scrollTop()>factor && $(window).height()>650) {
	
		$('.voting-form').css({
			
			"position":"fixed",
			"top":"115px"
			
		});
		
	} else {
		
		$('.voting-form').css({
			
			"position":"static"
			
		});
	}
}

var SlsVideo = {
		
		openVideo:function(uri) {
			
			$('body').append("<div id='video-overlay'><div class='inner'><div class='loading'></div></div></div>");
			
			$.ajax({
				
				"url":uri,
				"success":function(d) {
					
					$.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
					berricsRelatedVideoScreen = function(media_file_id, dailyop_id) {
						
						SlsVideo.closeVideo();
						
					}
					$('#video-overlay .inner').html(d);
					
					initMediaFileDiv();
					
					$("#video-overlay .inner .sls-video-post").slideDown('slow',function() { 
						
						$('.dailyop_media_item:eq(0)').click();
						
						//$("#video-overlay").click(function() { SlsVideo.closeVideo(); });
						
						berricsRelatedVideoScreen = function(d,a) {
						
							SlsVideo.closeVideo();
							
						}
						
						
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
			
		},
		videoOverScreen:function(m_id,d_id) {
			
			var post_div = $('.d-post-bit[dailyop_id='+d_id+']').parent();
			
			var form_div = $('.entry-div[dailyop_id='+d_id+']').clone();
			
			
			$(post_div).html($(form_div));
			
		}
		
		
}