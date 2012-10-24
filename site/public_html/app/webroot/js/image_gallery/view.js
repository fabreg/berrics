$(document).ready(function() { 
	
	$(".img-"+media_file_id).addClass('selected');
	
	if(document.location.href.match(/view:/)) {
		
		scrollToImage();
		
	}
	
	$("div.item").hover(
			
		function() { 
			
			$(this).css({
				
				"background-color":"#333"
				
			});
			
		},
		function() { 
			
			
			$(this).css({
				
				"background-color":"transparent"
				
			});
			
		}
	);

	$('.image-view img').load(function() { 

		scrollToImage();
		var imgWidth = $('.image-view').width();
		 
		 var imgHeight = $('.image-view').height();
		 
		 $('.image-view .arrow-right,.image-view .arrow-left').css({
			 
			 "height":(imgHeight)+"px",
			 
		 });
		
	}).click(function() { 
		var ref = $('.next').find("a").attr("href");
		document.location.href =ref;
	
		
	});


	$(document).bind('keydown',function(e) { 

		keyToImage(e);
				
	});
	
	
	

});

function scrollToImage() {

	var p = $('.image-view').offset();

	if(p['top'] == undefined || p['top'] <= 0) {
		
		return scrollToImage();
		
	} else {
		
		$('body').append(p['top']);
		
		$(document).scrollTop(p['top']-100);

	}
	
}

function keyToImage(code) {

	var key = (code.keyCode) ? code.keyCode:code.which;
	
	var dir = '';
	
	switch(key) {

		case 37:
			dir = 'left';
		break;
		case 39:
			dir = 'right';
		break;
		default:
			return false;
		break;
		
	}

	var selected = $('.selected');

	var index = parseInt($(selected).attr("index"));

	var nextIndex = index+1;
	
	var prevIndex = index-1;
	
	var link = false;

	switch(dir) {

		case "left":

			link = $('.item[index='+prevIndex+']').find('a').attr('href');
			
			
		break;
		case "right":

			link = $('.item[index='+nextIndex+']').find('a').attr('href');
			
			
		break;

	}

	if(link && link != undefined) {

		document.location.href = link;

	}
	



	
	
}




function getImageIndexes() {

	$('.item').each(function() { 

		$('body').append($(this).index()+"<br />");

	});

	
}
