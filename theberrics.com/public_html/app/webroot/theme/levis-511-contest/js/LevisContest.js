(function( $ ){

  var methods = {
		  
		 
		 openWindow:function(opt) {
			 
			 var open = true;
			 
			 if(open) {
				 
				 var div = $("<div id='LevisOverlay' />");
				 div.append(
						$("<div class='wrapper'/>").
						append(
								$("<div class='close-div'/>").append(
										"<div class='close-button' />"
								)
						).
						append("<div class='content'/>")
				 );
				 
				 $('body').append(div);
				 
				 //bind the UI
				 $("#LevisOverlay .close-button").click(function() { 
					 
					 methods.handleClose();
					 
				 });
				 
				$('body,html').css({
					
					"overflow":"hidden"
					
				});
				 
				$("#LevisOverlay").fadeIn('normal',function() { 
					
					methods.openUrl(opt.url);
					
				});
				
			 } else {
				 
				 methods.openUrl(opt.url);
				 
			 }
			 
			
			 
		 },
		 initForms:function(f) {
			 
			 $(f).ajaxForm({
					
					"success":function(d) {
						
						methods.hideLoading();
						
						$('#LevisOverlay .content').html(d).fadeIn();
						
						$("#LevisOverlay .content form[rel!='no-ajax']").each(function(e) { 
							
							methods.initForms(this);
							
						});
						
						$("#LevisOverlay .content a[rel!=no-ajax]").click(function(e) { 
							
							methods.openUrl($(e.target).attr("href"));
							
							return false;
							
						});
						
						
					},
					'beforeSubmit':function() {
						
						methods.showLoading();
						
						$('#LevisOverlay .content').fadeOut();
						
						return true;
						
					}
					
				});
			 
		 },
  		handleClose:function()  { 
  			
  			$('#LevisOverlay').remove();
  			$('body,html').css({
				
				"overflow":"auto"
				
			});
  			
  			document.location.hash = "";
  			
  		},
  		openUrl:function(url) {
  			
  			methods.showLoading();
  		
  			var suc = function(d) {
  				
  				$('#LevisOverlay .content').html(d).fadeIn('normal',function() { methods.hideLoading(); });
					
				$("#LevisOverlay .content a[rel!='no-ajax']").click(function(e) { 
					
					var ref = $(e.target).attr("href");
					
					methods.openUrl(ref);
					
					return false;
					
				});
				$("#LevisOverlay .content form[rel!='no-ajax']").each(function(e) { 
					
					methods.initForms(this);
					
				});
  			}
  			
  			var o = {
  			
  				'url':url,
  				'success':function(d) {
  					
  					suc(d);
  					
  				},
  				statusCode:{
  					
  					403:function(d) {
  						
  						methods.openUrl("/identity/login/form");
  						
  					}
  					
  				}
  					
  			};
  			
  			$('#LevisOverlay .content').fadeOut('normal',function() { 
  				
  				$.ajax(o);
  				
  			});
  			
  			
  			
  			
  		},
  		showLoading:function() {},
  		hideLoading:function() {}
  		
	
		  
  };

  $.LevisContest = function( method ) {
    
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on Levis Contest' );
    }    
  
  };

})( jQuery );