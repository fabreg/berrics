$(document).ready(function() { 



	$('.tab-right').click(function(e) { 

		var scrollLeft = $('.thumbs').scrollLeft();
		var scroll = scrollLeft + 555;
		$('.thumbs').animate({'scrollLeft':scroll},500)
		
	});

	$('.tab-left').click(function(e) { 

		var scrollLeft = $('.thumbs').scrollLeft();
		var scroll = scrollLeft - 555;
		$('.thumbs').animate({'scrollLeft':scroll},500)
		

	});
	
	//scoll over to the selected
	
	var offset = $('#gallery .thumbs .strip .selected').position();

	$(".thumbs").scrollLeft(offset.left);

	
});