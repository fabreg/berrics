(function( $ ){
  $.fn.berricsHtmlVideo = function(options) {
  
	  var $this = $(this);
	  
	  var methods = {
			  
		
		requestSuccess:function(d) {
		  
		  $this.html(d);
		  
	  	}
			  
			  
	  };
	  
    //let's put a loading symbol in the div that we are referencing
	  
	
	 
	 //let's do an ajax call to to the media controller to get the video properties
	 
	 $.ajax({
		 
		 "url":"/media/ajax_video/"+options['media_id'],
		 "success":methods.requestSuccess
		 
	 });
	 

  };
})( jQuery );