	var monthsLabel = {

			1:"Jan",
			2:"Feb",
			3:"Mar",
			4:"Apr",
			5:"May",
			6:"Jun",
			7:"Jul",
			8:"Aug",
			9:"Sep",
			10:"Oct",
			11:"Nov",
			12:"Dec"
				
		};

	var scollInterval = false;

$(document).ready(function() { 


	buildDateMenu();
	dateBitSetSelected();
	//right arrow
	$('#date-bit .right-arrow').bind('mousedown',function(e) { 

		scrollInterval = setInterval(function() { 

			var scrollLeft = $('#date-bit .slide-wrapper').scrollLeft();
			var scroll = scrollLeft + 10;
			$('#date-bit .slide-wrapper').scrollLeft(scroll);

		},10);
	

	}).bind("mouseup",function(e) { 

		clearInterval(scrollInterval);

	});
	
	$('#date-bit .left-arrow').bind('mousedown',function(e) { 

		scrollInterval = setInterval(function() { 

			var scrollLeft = $('#date-bit .slide-wrapper').scrollLeft();
			var scroll = scrollLeft - 10;
			$('#date-bit .slide-wrapper').scrollLeft(scroll);

		},10);
	

	}).bind("mouseup",function(e) { 

		clearInterval(scrollInterval);

	});


	///

	$('#date-bit .slide-wrapper').scrollTo('div[year='+currYear+'][month='+currMonth+']');



	$("#date-bit .jump-nav .months span").click(function() { 


			
		var month = $(this).attr("month");

		if(currYear == 2007) {

			
			currYear = 2007;
			currMonth = 12;
			
		} else {

			currMonth = month;

		}

		$('#date-bit .slide-wrapper').scrollTo('div[year='+currYear+'][month='+currMonth+']');

		dateBitSetSelected();

	});


	$("#date-bit .jump-nav .years span").click(function() { 

			var year = $(this).attr("year");

			if(year == 2007) {

				
				currYear = 2007;
				currMonth = 12;
				
			} else {

				currYear = year;

			}

			$('#date-bit .slide-wrapper').scrollTo('div[year='+currYear+'][month='+currMonth+']');

			dateBitSetSelected();

	});

	$("#date-bit .jump-nav span").hover(

		function() { 

			$(this).addClass("over");

		},
		function() {

			$(this).removeClass("over");
	
		}
			
	);
	
	$("#date-bit .right-arrow, #date-bit .left-arrow").hover(
			
		function() {
			
			$(this).css({"opacity":.5});
			
			
			
		},function() {
			
			$(this).css({"opacity":1});
			
	});
	
	$("#date-bit .date-days li").hover(
			
			function() {
				
				
				$(this).addClass("over");
				
			},
			function() {
				
				$(this).removeClass("over");
				
			}
	
	).click(function() { 
		
		var ref = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
	});
	
});


	function dateMenuScrollLeft() {

		
	}

		


function buildDateMenu() {
	
	//loop thru the years
	for(var year in date_nav_json) {

		//loop throught the months
		for(var month in date_nav_json[year]) {

			var label = "<div class='month-label'>"+monthsLabel[month].toUpperCase()+" '"+year.substring(2)+"</div>";
			
			var list = "<ul>";

			for(var day in date_nav_json[year][month]) {
				
				var href= "/"+year+"/"+paddShit(month)+"/"+paddShit(date_nav_json[year][month][day]);
				
				list += '<li day="'+paddShit(date_nav_json[year][month][day])+'"><a href="'+href+'">'+date_nav_json[year][month][day]+'</a></li>';
				
			}

			list +="</ul>";

			var style = '';

			if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {

				style = "style='float:right; '";
				
			}
			
			var div = "<div class='month-bit' month='"+month+"' year='"+year+"' "+style+">"+label+list+"</div>";
			
			$('#date-bit .date-days').append(div);

		}	

	}

	//put in the days
	

}

function dateBitSetSelected() {
	
	$("#date-bit .jump-nav span").removeClass("selected");
	$("#date-bit .jump-nav span[month="+currMonth+"]").addClass("selected");
	$("#date-bit .jump-nav span[year="+currYear+"]").addClass("selected");
	$(".month-bit[month="+currMonth+"][year="+currYear+"] li[day="+currDay+"]").addClass("selected");
}

function paddShit(str) {

	var i = parseInt(str);

	if(i<=9) {

		return "0"+i;
		
	} else {

		return i;

	}
	
}