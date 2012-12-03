$(function() {

	$(window).bind('resize.TopNav',function() { 

		var $w = $(window).width();

		if($w<=978) {

			$("#top-nav-div").hide();
			$("#top-nav-mobile").show();

		} else {

			$("#top-nav-div").show();
			$("#top-nav-mobile").hide();

		}
		
	}).trigger('resize');

	$("#mobile-nav-select").change(function() { 


		var uri = $(this).val();

		if(uri.length>0) document.location.href = uri;

		return;

	});
	initLayout();
	initMediaDivs();
	initTrending();

});

function lazyLoad () {
	
	$('img.lazy').lazyload({

			load:function(e) {

				var img = $('img').eq(e);

				$(img.get(0)).attr({

					"width":"",
					"height":""

				});

			}

		});

}

function initTrending () {
	
	$("#trending-content .tab:not(.active)").click(function() { 

		$("#trending-content .loading").remove();

		$("#trending-content").append($("<div class='loading' />").append($("<div class='spinner' />")));

		$("#trending-content .loading").fadeIn('fast');

		var s = $(this).attr("data-section");
		$("#trending-content .tab").removeClass('active').unbind('click');
		$(this).addClass('active');
		$.ajax({

			"url":"/dailyops/trending/"+s,
			"success":function(d) {

				$("#trending-content tbody.content").html(d);
				lazyLoad();
				initTrending();
				$("#trending-content .loading").fadeOut('fast',function() { $("#trending-content .loading").remove(); });
			}


		});

	});

}

function initMediaDivs () {
	

	$('.post-media-div:not([data-init])').each(function() { 

		$type = $(this).attr("data-media-type");
		$this = $(this);
		switch($type) {

			case 'bcove':

				if(!Modernizr.touch) {

					$this.hover(
					function(e) { 
						$(this).find('.video-hover').fadeIn().parent().find('.play-button').animate({opacity:1});
					},
					function(e) { 
						$(this).find('.video-hover').fadeOut().parent().find('.play-button').animate({opacity:.6});
					});

				}
						

				$this.click(function() { 
					
						$(this).videoDiv();
						$(this).unbind('click');

				});

			break;

		}

		$(this).attr("data-init",1);

	});

		//post thumb
	$('.post-thumb .thumb').each(function() { 

		if(!Modernizr.touch) {

			$(this).unbind().hover(
			function() { 
				$(this).find('.overlay').fadeIn().parent().find('.play-button').animate({opacity:1});
			},
			function() { 
				$(this).find('.overlay').fadeOut().parent().find('.play-button').animate({opacity:.6});;
			})

		}

	});

	return;

}

function initNav () {
	// body...

	$("#top-dropdown").unbind();

	$("#top-nav-div").find("#top-dropdown").
	hover(
		function() {
			$("#top-dropdown-menu").slideDown('fast');
		},
		function() {
			$("#top-dropdown-menu").hide();
		}
	);

	$("#top-nav-mobile").find("#top-dropdown-menu").show();
	$("#top-nav-div #top-dropdown-menu").hide();

}

function initLayout() {
	
	initNav();
	

}