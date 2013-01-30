$(document).ready(function() { 
	
	var hover_img = new Image();
	
	hover_img.src = '/img/layout/commander/command-thumb-over.png';
	
	//handle the thumbnail rollovers
	
	$("#commander-thumb-menu .post-thumb-div").hover(
	
		function() {

			$(this).find('.post-thumb-over').fadeIn().click(function() { var ref = $(this).parent().find("a").attr("href"); document.location.href = ref; });
			
		},
		function() {
			
			$(this).find('.post-thumb-over').hide();
			
		}
	
	).click(function() { 
		
		var ref = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
		
	});
	
	
	
});