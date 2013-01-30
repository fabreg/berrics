(function($) {
	var bs ={'t':'s'};
	var globalMethods = {
		
		controlsHtml:"<div class='controls'>"
						+ "<div class='inner'>"
						+ "<div class='playbutton'>PlayButton</div>"
						+ "<div class='prog-bar'>"
						+ "<div class='timer'></div>"
						+ "<div class='loaded'></div>"
						+ "<div class='bar'>"
						+ "<div class='slider'>"
						+ "<div class='progress'>"
						+ "<div class='marker'></div>"
						+ "</div>"
						+ "</div>"
						+ "</div>"
						+ "<div class='mutebutton'></div>"
						+ "</div>"
						+ "</div>"
						+ "</div>",
		videoHtml: "<video class='berrics-video' playCount='0' preRollStatus='0' postRollStatus='0' mediaFileStatus='0'></video>",
		quicktimeHtml:"",
		flashHtml:"",
		initHtml:function(scope,options) {
		
			//inject HTML
			
		
		},
		initQuicktime:function(scope,options) {
			
		},
		initFlash:function(scope,options) {
			
		},
		htmlBufferInterval:function(scope) {},
		htmlBufferIntervalStart:function(scope) {},
		htmlBufferIntervalClear:function(scope) {},
		quicktimBufferInterval:function(scope) {},
		quicktimeBufferIntervalStart:function(scope) {},
		quicktimeBufferIntervalClear:function(scope) {},
	
		
			
			
	};
	
	$.fn.BerricsVideoPlayer=function(options) {
		
		var $this = $(this);
		
		var defaults = {};
		
		//lets determine the operating system
		
		var nav = navigator.appVersion;
		
		var os = false;
		
		if(nav.toLowerCase().indexOf("win") != -1) {
			
			os = "win";
			
		} else if(nav.toLowerCase().indexOf("mac") != -1) {
			
			os = "mac";
			
		}
		
		if(os == 'win') {
			 
			
			
		} else if(os == 'mac') {
			
			
		}
		
		defaults['os'] = os;
		
		
		var opts = $.extend({},defaults,options);
		
		alert(os);
		
	};
	
})(jQuery);