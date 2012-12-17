jQuery(document).ready(function($) {
	
	//init media gallery
	initArticleGallery();

});


function initArticleGallery() {
	
	$('.article-media-gallery .media-thumb').each(function() { 


		$(this).bind('click',function() { 

			var media_type = $(this).attr("data-media-type");

			switch(media_type) {

				case "IMG":

					//show the loader
					$('.article-media-gallery .viewing-div .loader').show().css({opacity:.5});

					var file = $(this).attr('data-thumb-large-src');

					var name = Base64.decode($(this).attr('data-media-file-name'));

					var caption = Base64.decode($(this).attr("data-media-file-caption"));

					$("<img/>",{"src":file}).bind('load',function() {

						$('.article-media-gallery .viewing-div .loader').hide();

						$('.article-media-gallery .media-file').html(this);

					});

					$('.article-media-gallery .caption').html(caption);

					$('.article-media-gallery .title').html(name);

					$('.article-media-gallery .media-thumb').removeClass('active');

					$(this).addClass("active");

				break;


			}
			

		});

	});

}
