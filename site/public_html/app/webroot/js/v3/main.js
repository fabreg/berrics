jQuery(document).ready(function($) {

	//top menu parking
	$(window).scroll(function(e) { 

		var st = $(window).scrollTop();

		if(st>98) {

			$("#top-nav-container").addClass("top-nav-parked");
			$('#body-div').addClass("top-nav-showing");
			

		} else {

			$("#top-nav-container").removeClass('top-nav-parked');
			$('#body-div').removeClass("top-nav-showing");
			

		}

	});

});


