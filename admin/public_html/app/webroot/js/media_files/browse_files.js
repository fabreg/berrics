/*
John hardy
*/

var media_files = {};

$(document).ready(function() { 
	
	
	
	
});

media_files.browse = function() {
	
	media_files.openModalWindow();
	alert("shit!");
	
};

media_files.openModalWindow = function() {
	
	$('body').prepend("<div id='media-overlay'><div id='media-overlay-inner'><div id='media-overlay-content'></div></div></div>");
	
	$("#media-overlay").css({
		
		"position":"absolute"
		
	});
	
	
};

media_files.handleModalWindow = function() { };

media_files.closeModalWindow = function() { };
