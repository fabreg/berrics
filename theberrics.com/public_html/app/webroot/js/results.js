
$(document).ready(function() { 


	if(document.location.hash.length > 0) {

		var href = Base64.decode(document.location.hash);

		postLinkClick(href);
		
	}
	
});

function formatPostTiles() {
	/*
	$("#posts .post-thumb-small").hover(
		function() { 

			$(this).addClass("post-thumb-over");
			
			var title = $(this).find("a").attr("title");
			
			$(this).find(".img").find("img").css({"opacity":.5});
			//.append("<div class='title-bubble'>"+title+"</div>")
			$(this).find(".title-bubble").css({

				"position":"absolute",
				"top":"-10px",
				"background-color":"red"

			});
		},
		function() {

			$(this).removeClass("post-thumb-over");
			$(this).find(".img img").css({"opacity":1});
			//$(this).find(".title-bubble").remove();
		}
	).find(".icon").css({"opacity":.5});
	 */
	initThumbHovers();
	$("#posts .posts-paginate-menu a").click(function() { 


			postLinkClick($(this).attr("href"));
			document.location.hash = Base64.encode($(this).attr("href"));
			return false;
		
	});

	
}

function postLinkClick(url) {
	
	$.ajax({

		"url":url,
		"success":function(d) {
	
			$("#posts").html(d);
			formatPostTiles();
		}
		

	});
	
}