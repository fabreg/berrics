jQuery(document).ready(function($) {

	//top menu parking
	$(window).bind('scroll.topNav resize.topNav',function(e) { 

		var st = $(window).scrollTop();

		if(st>98) {

			var offset = $("#main-container").offset();

			$("#top-nav-container").addClass("top-nav-parked");
			$(".top-nav-parked").css({

				"left":offset.left+"px",
				'width':$("#main-container").width()+"px"

			});

			$('#body-div').addClass("top-nav-showing");

			//$("#nested-nav-container").html($("#top-nav-container").clone());

		} else {

			//$(".top-nav-parked").css('width','');
			$(".top-nav-parked").css({

				"left":'',
				'width':''

			});
			$("#top-nav-container").removeClass('top-nav-parked');


			$('#body-div').removeClass("top-nav-showing");

			//$("#top-nav-container").html($("#nested-nav-container").clone());
			
		}

	});

	initMediaDivs();

});

function initMediaDivs () {
	
	$('.post div[data-media-file-id]').each(function() { 

		$(this).click(function() { 

			$(this).videoDiv();
			$(this).unbind('click');

		});

	});

}
