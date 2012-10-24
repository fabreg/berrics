$(document).ready(function() { 

	 $.mb_videoEmbedder.defaults.width=620;
	 $('.embed-video').each(function()  {
		 
		$(this).mb_embedMovies(); 
		 
	 });

});
