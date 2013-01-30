$(document).ready(function() { 
	
	
	initTopNav();
	
	
});


function initTopNav() {
	
	
	$("#header .top-nav .li-button").hover(
	
		function() {
		
			$(this).addClass('li-button-hover').find('.sub-nav-list').slideDown();
			
		},
		function() {
			
			$(this).removeClass('li-button-hover').find('.sub-nav-list').hide();
			
		}
	
	);
	
	
}