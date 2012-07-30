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
									$("<div class='wrapper' />").append("<div class='content'/>")
									
							);
								
					
					$('body').append(div);
					
					
					
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
			
			var o = $.extend({
				
				"success":function(d) {
					
					$("#BerricsLogin .content").html(d).fadeIn();
					o.callback.apply(this,[]);
					
				},
				"callback":function() {}
				
			},opts);
			
			$("#BerricsLogin .content").fadeOut("normal",function() { 
				
				$.ajax(o)
				
				
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