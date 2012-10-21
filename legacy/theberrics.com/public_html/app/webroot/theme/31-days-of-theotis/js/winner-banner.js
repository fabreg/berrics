$(document).ready(function() { 
	
	//do an ajax call to get the current winner
	$.ajax({
		
		url:"/31-days-of-theotis/ajax_winner_banner",
		dataType:"html",
		success:function(d) {
			
			$("#theotis-winner-banner").html(d);
			
			
			
		}
	});
	
	
}); 