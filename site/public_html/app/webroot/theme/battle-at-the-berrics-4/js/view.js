/*
Author: John Hardy
*/

var voting = {
		
	modalOpen:function() {
	
	}
		
};

$(document).ready(function() { 
	
	
	$('.vote-button').click(function() { 
		
		//openVoting();
		
	});
	
	
});

function openVoting() {
	
	voting['modalOpen'] = function() {
	
		$.ajax({
			
			"url":"/voting/place_vote/",
			"success":function(d) {
				
				$("#modal-content").html(d);
				
			}
			
		});
		
	};
	
	openModal();
	
}

function openModal() {

	
	$("body").append("<div id='modal-overlay'><div id='modal-relative'><div id='modal-inner'><div id='modal-content'><img src='/img/loader.gif' /></div></div></div></div>");
	
	$("html").css({
		
		"overflow":"hidden"
		
	});
	
	$(window).resize(function() { 
		
		handleModalResize();
		
	});
	
	handleModalResize();
	
	$("#modal-overlay").click(function() { handleModalClose(); });
	
	$(window).scrollTo(0,0);
	
	$("#modal-overlay").hide().fadeIn('fast',function() { 
		
		$("#modal-content").slideDown();
		voting.modalOpen();
		
	});
	
}

function handleModalResize() {
	
	var b_h = $(document).height();
	var b_w = $(document).width();
	$("#modal-overlay").css({
		
		"height":b_h+"px",
		"width":b_w+"px"
		
	});
	
}

function handleModalClose() {
	
	$("#modal-overlay").remove();
	$("html").css({
		
		"overflow":"auto"
		
	});
	
	
}