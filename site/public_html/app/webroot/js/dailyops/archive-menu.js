$(document).ready(function() { 

	$("#dailyops-archive-menu .left-nav").click(function() { 

		var cur = $("#dailyops-archive-menu .scroller").css("left");

		cur = parseInt(cur);
		
		if(!$("#dailyops-archive-menu .scroller").is(":animated") && cur !=0) {
			var pos = parseInt($("#dailyops-archive-menu .scroller").css("left"));
			
			var x = parseInt(pos) + 630;

			//alert(x);
			$("#dailyops-archive-menu .scroller").animate({

				"left":x+"px"
		
			},500);
		}

		
	});

	$("#dailyops-archive-menu .right-nav").click(function() { 

		if(!$("#dailyops-archive-menu .scroller").is(":animated")) {
			var pos = parseInt($("#dailyops-archive-menu .scroller").css("left"));
			

			var x = parseInt(pos) - 630;

			//alert(x);
			$("#dailyops-archive-menu .scroller").animate({

				"left":x+"px"
		
			},500);
		}
		
	});

});

function dailyopsScrollToIndex(year,month) {
	
	//find the div's index
	
	var ind = $("#dailyops-archive-menu .month[year='"+year.toString()+"'][month='"+month.toString()+"']").attr("index");
	
	var pos = 630*ind;
	
	alert(ind);
	
	
	$("#dailyops-archive-menu .scroller").animate({
		
		"left":"-"+pos+"px"
		
	},1000);
	
}