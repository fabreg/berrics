$(document).ready(function() { 
	
	//make an ajax call to get the total signups and trigger the banner
	$.ajax({
		
		url:'/younited-nations-3/ajax_top_banner',
		success:function(d) {
			
			$("#yn3-top-banner").html(d).click(function() { 
				
				document.location.href='/younited-nations-3'
				
			}).css({
				
				"background-image":"url(/theme/younited-nations-3/img/YN3_TopBanner.jpg)",
				"height":"300px",
				"position":"relative",
				"width":"1000px",
				"margin":"auto",
				'margin-bottom':'15px'
					
			}).find('.total').css({
				
				'position':'absolute',
				'height':'55px',
				'left':'20px',
				'top':'117px',
				'font-size':'90px',
				'font-family':'Arial',
				'font-weight':'bold',
				'width':'250px',
				'text-align':'right',
				'color':'#812b00'
				
			});

			
		}
		
	});
	
	
});