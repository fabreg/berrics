$(function() {

	//top menu parking
	$(window).bind('scroll.topNav resize.topNav',function(e) { 

		var st = $(window).scrollTop();

		if(st>80) {

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
	
	$('.post div[data-media-file-id]').each(function() { 

		$(this).click(function() { 

			$(this).videoDiv();
			$(this).unbind('click');

		});

	});




}
function initLayout() {
	
	$("#top-dropdown").unbind().
	hover(
		function() {
			$("#top-dropdown-menu").slideDown();
		},
		function() {
			$("#top-dropdown-menu").hide();
		}
	);

}