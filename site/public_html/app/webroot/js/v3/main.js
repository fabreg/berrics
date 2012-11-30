$(function() {

	//top menu parking
	/*
	$(window).bind('scroll.topNav resize.topNav',function(e) { 

		var st = $(window).scrollTop();

		if(st>65) {

			var offset = $("#main-container").offset();

			$("header").addClass("top-nav-parked");
			

			$('#body-div').addClass("top-nav-showing");

			//$("#nested-nav-container").html($("#top-nav-container").clone());

		} else {

			
			$("header").removeClass('top-nav-parked');


			$('#body-div').removeClass("top-nav-showing");

			//$("#top-nav-container").html($("#nested-nav-container").clone());
			
		}

	});
	*/
	initLayout();
	initMediaDivs();
	initTrending();

});

function initTrending () {
	
	$("#trending-content .tab:not(.active)").click(function() { 

		$("#trending-content .loading").remove();

		$("#trending-content").append($("<div class='loading' />"));

		$("#trending-content .loading").fadeIn('fast');

		var s = $(this).attr("data-section");
		$("#trending-content .tab").removeClass('active').unbind('click');
		$(this).addClass('active');
		$.ajax({

			"url":"/dailyops/trending/"+s,
			"success":function(d) {

				$("#trending-content .content").html(d);
				initTrending();
				$("#trending-content .loading").fadeOut('fast',function() { $("#trending-content .loading").remove(); });
			}


		});

	});

}

function initMediaDivs () {
	
	$('.large-post').each(function() { 

		$(this).click(function() { 

			$(this).videoDiv();
			$(this).unbind('click');

		});
		

	});


	//video post
	$('.post .post-media-div[data-media-type=bcove]').unbind().hover(
	function() { 
		$(this).find('.video-hover').fadeIn().parent().find('.play-button').animate({opacity:1});
	},
	function() { 
		$(this).find('.video-hover').fadeOut().parent().find('.play-button').animate({opacity:.6});
	}).click(function() { 
			
			if($(this).find('video').length<=0) {

				$(this).videoDiv();
				$(this).unbind('click');

			}

	});

	//post thumb
	$('.post-thumb .thumb').unbind().
	hover(
		function() { 
			$(this).find('.overlay').fadeIn().parent().find('.play-button').animate({opacity:1});
		},
		function() { 
			$(this).find('.overlay').fadeOut().parent().find('.play-button').animate({opacity:.6});;
		}
	)



}
function initLayout() {
	
	$("#top-dropdown").unbind().
	hover(
		function() {
			$("#top-dropdown-menu").slideDown('fast');
		},
		function() {
			$("#top-dropdown-menu").hide();
		}
	);

}