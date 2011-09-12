$(document).ready(function() { 
	
	
	$(window).scroll(function(ev) { 
		
		
		var s = $(this).scrollTop();
		
		$("#right-col .container").css({"top":(s)+"px"});
		
	});
	
	
});