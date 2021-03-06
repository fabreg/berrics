(function( $ ){

  var methods = {
		  
		  
		init:function(options) {
		
			$(this).data("BerricsLogin",$.extend(options,{}));
			
		},
		openWindow:function(url) {
				
			if(!url || url.length<=0) url = "/identity/login/form";

			var chk = $("#BerricsLogin");
			
			if(chk.length<=0) {
				
				var div = $("<div id='BerricsLogin'/>").
							
							append(
									$("<div class='wrapper' />").
										append(
											"<div class='loading' />"
										).
										append(
											$("<div  class='close-div'/>").append(
													"<div class='close-button'/>"
											)
										).
										append("<div class='content'/>")
									
							);
								
					
					$('body').append(div);
					
					$("#BerricsLogin .close-button").click(function() { methods.closeWindow();  });
					
					div.fadeIn('normal',function() { 
						
						methods.loadAjaxContent(url);
						
					});
					
					methods.handleWindowResize();
					
			} else {
				
				methods.loadAjaxContent(url);
				
			}
			
			$(document).bind('keyup.berricsLogin',function(e){

			    if(e.keyCode === 27) {

			    	 methods.closeWindow();
			    	
			    }
			      

			});
			
			
		},
		handleWindowResize:function() { 
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
		},
		closeWindow:function() {
			
			if($("#BerricsLogin").length<=0) return;
			
			$('#BerricsLogin').fadeOut('normal',function() {
				
				$('#BerricsLogin').remove();
				$('body,html').css({
					
					
					"overflow":"auto"
					
				});
				
			});
			
			$(document).unbind('.berricsLogin');
			
			document.location.hash = "";
			
		},
		loadAjaxContent:function(uri) {
			
			methods.showLoading();
			
			$.bbq.pushState({"BerricsLogin":uri});
			
			var o = {
					
					"success":function(d) {
						
						methods.hideLoading();
						
						$("#BerricsLogin .content").html(d).fadeIn("normal",function() { 
							
							methods.showCloseDiv();
							
						});
						
						$("#BerricsLogin .content a[rel!=no-ajax]").click(function(e) { 
							
							methods.loadAjaxContent($(e.target).attr("href"));
							
							return false;
							
						});
									
			
						//format all links to use this method
						$("#BerricsLogin .content form[rel!='no-ajax']").each(function(e) { 
							
							methods.initForms(this);
							
						});
						
						
						
					},
					"url":uri,
					statusCode:{
						
						404:function() {
							
							alert("Whoops, we couldn't find that page");
							methods.closeWindow();
							
						}
						
					}
					
				};
			methods.hideCloseDiv();
			$("#BerricsLogin .content").fadeOut("normal",function() { 
				
				$.ajax(o);
				
				
			});
			
			
		},
		showLoading:function() {
			
			$("#BerricsLogin .wrapper").css({
				
				"background-image":"url(/img/layout/ajax-loader.gif)"
				
			});
			
		},
		hideLoading:function() { 
			
			$("#BerricsLogin .wrapper").css({
				
				"background-image":"none"
			});
			
		},
		initForms:function(e) {
			
			$(e).ajaxForm({
				
				"success":function(d) {
					
					methods.hideLoading();
					
					$('#BerricsLogin .content').html(d).fadeIn("normal",function() { 
						
						methods.showCloseDiv();
						
					});
					
					$("#BerricsLogin .content form").each(function(e) { 
						
						methods.initForms(this);
						
					});
					
					$("#BerricsLogin .content a[rel!=no-ajax]").click(function(e) { 
						
						methods.loadAjaxContent({
							
							"url":$(e.target).attr("href")
							
						});
						
						return false;
						
					});
					
					
				},
				'beforeSubmit':function() {
					
					methods.showLoading();
					methods.hideCloseDiv();
					$('#BerricsLogin .content').fadeOut();
					
					return true;
					
				}
				
			});
		},
		showCloseDiv:function() { 
			
			$("#BerricsLogin .close-div").show();
			
		},
		hideCloseDiv:function() { 
			
			$("#BerricsLogin .close-div").hide();
			
		}
	
	
		  
  };

  $.BerricsLogin = function( method ) {
    
    if ( methods[method] ) {
      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on Berrics Login' );
    }    
  
  };

})( jQuery );