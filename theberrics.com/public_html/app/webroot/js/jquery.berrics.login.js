(function( $ ){

  var methods = {
		  
		  
		init:function(options) {
		
			$(this).data("BerricsLogin",$.extend(options,{}));
			
		},
		openWindow:function() {
				
			
			var opt = $.extend({
				
				"screen":"noscreen"
				
			},arguments[0]);

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
						
						methods[opt['screen']].apply(this,Array.prototype.slice.call( arguments, 1 ));
						
					});
					
					methods.handleWindowResize();
					
					
					
			} else {
				
				methods[opt.screen].apply(this,Array.prototype.slice.call( arguments, 1 ));
				
			}

			
		},
		handleWindowResize:function() { 
			
			$('body,html').css({
				
				"overflow":"hidden"
				
			});
			
		},
		closeWindow:function() {
			
			$('#BerricsLogin').fadeOut('normal',function() {
				
				$('#BerricsLogin').remove();
				$('body,html').css({
					
					
					"overflow":"auto"
					
				});
				
			});
			
		},
		nomethod:function() {
			
			console.log("No Method Found");
			
		},
		loginScreen:function() {
			
			methods.loadAjaxContent({
				
				"url":"/identity/login/form",
				
				
			})
			
		},
		registerScreen:function() { 
			
			methods.loadAjaxContent({
				
				"url":"/identity/login/register",
				
			});
			
		},
		loadAjaxContent:function(opts) {
			
			methods.showLoading();
			
			var o = $.extend({
				
				"success":function(d) {
					
					methods.hideLoading();
					
					$("#BerricsLogin .content").html(d).fadeIn();
					
					$("#BerricsLogin .content a[rel!=no-ajax]").click(function(e) { 
						
						methods.loadAjaxContent({
							
							"url":$(e.target).attr("href")
							
						});
						
						return false;
						
					});
					
					
					//
					
					o.callback.apply(this,[]);
					//format all links to use this method
					$("#BerricsLogin .content form").each(function(e) { 
						
						methods.initForms(this);
						
					});
					
					
					
				},
				"callback":function() {}
				
			},opts);
			
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
					
					$('#BerricsLogin .content').html(d).fadeIn();
					
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
					
					$('#BerricsLogin .content').fadeOut();
					
					return true;
					
				}
				
			});
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