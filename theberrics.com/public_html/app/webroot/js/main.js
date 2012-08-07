(function(f){
	
	//hack the shit of of setInterval & setTimeout to make it work in IE
		window.setTimeout = f(window.setTimeout);
		window.setInterval = f(window.setInterval);
		})(function(f){
		return function(c,t){
		var a = Array.prototype.slice.call(arguments,2);
		if(typeof c != "function")
		c = new Function(c);
		return f(function(){
		c.apply(this, a)
		}, t)
		}
	
});


$(document).ready(function() {
	
	(new Image()).src = "/img/layout/featured-bg.jpg";
	
	//init cart widget
	CartWidget.docReady();
	DailyopsSlideShow.init();
	//initTopNav();
	initThumbHovers();
	initCanteenProductThumbs();
	initMediaFileDiv();
	
	//auto compete data
	$("#SearchTag").autocomplete({

		source:'/search/ajax_auto_tag/',
		minLength:2

	});
	
	$("#section-year-menu li").click(function() { 
		
		var ref = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
	});
	
	
	
	$(".dailyop-swf-file").each(function() { 
		
		
		var file = $(this).attr("file");
		
		$(this).flash({
			
			swf:file,
			width:540,
			height:400
			
		});
		
	});
	
	
	//check for auto player
	var _autoCheck = document.location.href.split("?");
	
	if(_autoCheck[1] != undefined) {
		
		if(_autoCheck[1].match(/^(autoplay)$/)) {
			
			$('.dailyop_media_item:eq(0)').click();
			
		}
		
	}
	
	//bbq!!!
	$(window).bind('hashchange',function() { 
		
		var BerricsLogin = $.bbq.getState("BerricsLogin") || '';
		
		if(BerricsLogin.length>0) {
			
			if(BerricsLogin == 1) BerricsLogin = '';
			
			$.BerricsLogin('openWindow',BerricsLogin);
			
		} else {
			
			$.BerricsLogin('closeWindow');
			
			$.bbq.removeState("BerricsLogin");
			
		}
		
		
	});
	
	$(window).trigger("hashchange");
	
	
});

function initTopNav() {
	
	if(navigator.userAgent.toLowerCase().indexOf('mobile')>-1) {
		
		
		
	} else {
		
		$("#top-nav .nav-button").hover(
				function() { 
					
					$(this).addClass('over');
					
					$(this).find('.sublist').slideDown('normal');
					$(this).find("img").css({"opacity":.7});
				},
				function() { 
					
					$(this).removeClass('over');
					$("#top-nav .sublist").hide();
					$(this).find("img").css({"opacity":1});
				}
			);
		
	}
	
	//do some shit to the icons
	$("#featured-sublist img").css({
		
		"opacity":.6
		
	});
	
	$("#featured-sublist li").hover(
	
		function() { 
			
			$(this).addClass("featured-over").find("img").css({"opacity":1});
			
		},
		function() {
			
			$(this).removeClass("featured-over").find("img").css({"opacity":.6});
			
		}
	
	).click(function() { 
		
		var ref = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
	});
	
	$("#featured-post .thumb").hover(
	
		function() { 
			
			$(this).find(".featured-thumb-over").fadeIn();
			
		},
		function() { 
			
			
			$(this).find(".featured-thumb-over").hide();
			
		}
	
	).click(function() { 
		
		var ref = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
		
	});
	
	
}

function initThumbHovers() {
	
	
	$(".post-thumb-large").hover(
	
		function() { 
			
			$(this).find(".post-thumb-large-over").fadeIn();
			
		},
		function() { 
			
			$(this).find(".post-thumb-large-over").hide();
			
		}
	
	).click(function() { var ref = $(this).find("a:eq(0)").attr("href"); document.location.href = ref+"?autoplay"; });
	
	$(".post-thumb-med").hover(
			
			function() { 
				var type = $(this).attr("media_type");
				
				switch(type) {
				
					case "image":
					case "img":
					case "pic":
					case "piclink":
						$(this).find(".post-thumb-med-over").css({
							
							"background-image":"url(/img/layout/thumb-med-over-img.png)"
							
						});
					break;
				
				}
				$(this).find(".post-thumb-med-over").fadeIn();
				
			},
			function() { 
				
				$(this).find(".post-thumb-med-over").hide();
				
			}
		
	).click(function() { var ref = $(this).find("a:eq(0)").attr("href"); document.location.href = ref+"?autoplay"; });
		
	$(".post-thumb-small").hover(
			
			function() { 
				
				var type = $(this).attr("media_type");
				
				switch(type) {
				
					case "image":
					case "img":
					case "pic":
					case "piclink":
						$(this).find(".post-thumb-small-over").css({
							
							"background-image":"url(/img/layout/thumb-med-over-img.png)"
							
						});
					break;
				
				}
				
				$(this).find(".post-thumb-small-over").fadeIn();
				
			},
			function() { 
				
				$(this).find(".post-thumb-small-over").hide();
				
			}
		
	).click(function() { var ref = $(this).find("a:eq(0)").attr("href"); document.location.href = ref+"?autoplay"; }).find(".icon").css({"opacity":.5});
		
	
	$('.post-thumb[showBubble=1]').hover(
	
		function() {
			
			var sub_title = $(this).attr("sub_title");
			var label = $(this).attr("name");
			
			if(sub_title.length > 0) {
				
				label += "<div class='sub-title'>"+sub_title+"</div>";
				
			}
			
			$(this).append("<div class='description'><div class='inner'>"+label+"</div></div>");
			
			$(this).find('.description').fadeIn('fast');
			
		},
		function() { 
			
			$(this).find(".description").remove();
			
		}
	
	);
	
	
}


var berricsRelatedVideoScreen = function(media_file_id, dailyop_id) {
	
	
	$.ajax({
		
		"url":"/dailyops/related/"+dailyop_id,
		"success":function(d) {
			var ele = $("div[media_file][dailyop_id="+dailyop_id+"]");
			$(ele).html(d);
			$(ele).find(".icon").css({"opacity":.5});
			
			
			//make the replay button clickable
			
			format_berricsRelatedVideoScreen();
		}
		
	});
	
}

function format_berricsRelatedVideoScreen() {
	
	var ele = $('.dailyops-related');
	
	$(ele).find('.bg-underlay').remove();
	
	$(ele).prepend("<div class='bg-underlay'></div>");
	
	var bg = $(ele).find('.bg-underlay');
	
	$(ele).find('.replay-button').click(function() { 
		
		var href = $(this).find("a").attr("href");
		
		document.location.href = ref;
		
		
	});
	
	$(bg).css({
		
		"background-image":"url("+$(ele).attr("bg_img")+")",
		"opacity":.1,
		"height":$(ele).height()+"px",
		"width":$(ele).width()+"px"
		
	}).show();
	
	
}

function ps3VideoPostBit(id,mid) {
	
	//alert(id);
	
	var ele = document.getElementById('ps3-video-div-'+id);
	//alert(ele);
	//var htm = '<object data="/swf/BerricsPlayerTest.swf?time=0.11105233117236601" type="application/x-shockwave-flash" id="flash_1859223" height="400" width="700"><param name="flashVars" value="media_file_id='+mid+'&pre_roll=0&post_roll=0&videoAspectRatio=1&dailyop_id=2899"><param name="wmode" value="opaque"><param name="bgcolor" value="#000000"><param name="allowfullscreen" value="true"><param name="movie" value="/swf/BerricsPlayerTest.swf?time=0.11105233117236601"></object>';
	
	ele.innerHTML("test");
	
}


/*
 * 
 * Media File Div's
 * 
 */




function initMediaFileDiv() {
	

	$('div[media_file][media_type="bcove"]').each(function() {
		

    		var media_type = $(this).attr("media_type");
    		var media_file_id = $(this).attr("media_file_id");
    		var pre = $(this).attr("pre");
    		var post = $(this).attr("post");
    		
    		
    		
    		var m = eval('('+$(this).attr("media_file")+')');
    		
			switch(m['MediaFile']['media_type']) {
			
				case "bcove":
						
						//$(this).click(function() { flashVideoWeb(this,m); });
						var eleid = "berricsVideo"+media_file_id;	
					
						$(this).click(function() { 
							
							berricsPlayer(eleid,m);
							
						}).html("<div id='"+eleid+"'>"+$(this).html()+"</div>");
					
					break;
				default:
					
				break;
			}
    		
    		
    		if(navigator.userAgent.toLowerCase().indexOf('mobile')>-1) {
    			
    				$(this).load("/media/json_video_tag/"+media_file_id,function() { 
    					
    				});
    				
    				$(this).unbind("click");
    				
    		
    		} else {
    			
    			$(this).find('.overlay').css({
    				
    				"opacity":.6
    				
    			});
    			
    			$(this).hover(
    					function() { 
    						
    						$(this).find(".overlay").fadeIn();
    						
    					},
    					function() {
    						
    						$(this).find(".overlay").fadeOut();
    						
    					}
    			);
    			
    			
    		}
       		
	});
	
	//init EMOTW 
	
	$(".dailyop_media_item[dailyop_section_id=15]").each(function() { 
		
		var t = $(this).attr("publish_date").split(/[- :]/);
		
		var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

		if(d.getFullYear() == '2012') {
			
			//bootstrap the image
			
			$(this).find("img").click(function() { 
				
				EMOTW.bootstrapPost($(this).parent());
				
			});
			
			
		}
		
	});
	

	//fade out the logos
	$('.d-post-bit .icon img').css({'opacity':.4});
	
}


var EMOTW = {
		
		loadingHtml:"<div class='emotw-loading-screen'>LOADING EMAIL <br /><br /><img src='/img/layout/ajax-loader.gif' border='0'/></div>",
		bootstrapPost:function(div) {
			
			$(div).parent().unbind('click').css({
				
				"min-height":"396px"
					
			});
	
			$(div).click(function() { 
				
				$(this).html("");
				
				$(this).css({
					
					"position":"relative",
					"overflow":"hidden",
					
				});
				
				var dailyop_id = $(this).attr("dailyop_id");
				
				EMOTW.loadEmail(dailyop_id,1);
				$(div).unbind('click');
				
			});
			
			
	
		},
		loadEmail:function(dailyop_id,page) {
			
			var div = $(".dailyop_media_item[dailyop_id="+dailyop_id+"]");
			
			//overlay the loading screen
			$(div).prepend(EMOTW.loadingHtml).find('.emotw-loading-screen').css({
				
				"height":$(div).height()+"px"
				
			}).fadeIn('normal',function() { 
				
				$(div).find(".emotw-div").remove();
				
				$.post("/dailyops/ajax_emotw_paginator/"+dailyop_id+"/page:"+page,function(email_content) { 
					
					$(div).find(".emotw-loading-screen").fadeOut("normal",function() { 
						
						$(this).remove();
						$(div).html(email_content).find(".paging-link").each(function() {
							
							 $(this).click(function() { 
								 
								 EMOTW.loadEmail($(this).attr("dailyop_id"),$(this).attr("page"));
								 
								 
							 });
							
						});
						
					})
					
				});
				
			});
			
			
			
			
		},
		showContent:function() { 
			
			
			
		},
		showLoading:function(dailyop_id,page) {
			
			
			
		},
		loadNext:function(dailyop_id,page) {
			
			
			
		},
		loadPrevious:function(dailyop_id,page) {
			
			
			
		}
		
		
};



function flashVideoWeb(ele,data,width,height) {
	
	var m = data['MediaFile'];
	var swf_width = arguments[2] || 700;
	var swf_height = arguments[3] || 400;

	var swfVars = {
		'media_file_id':m['id'],
		videoAspectRatio:1,
		"dailyop_id":data['dailyop_id'],
		pre_roll:m['preroll'],
		post_roll:m['postroll'],
		//new properties
		preroll_server:"LEGACY",
		postroll_server:"LEGACY"
	};
	
	$(ele).flash({
		swf:swfPlayer+"?time="+Math.random(),
		flashVars:swfVars,
		height:swf_height,
		width:swf_width,
		wmode:"opaque",
		bgcolor:"#000000",
		allowfullscreen:"true",
		hasVersion:9,
		expressInstaller:'/swf/expressInstall.swf'
	
	});
	
	$(ele).unbind("click");
}

function berricsPlayer(id,data,width,height) {
	
	var e = $(document.getElementById(id));
	$(e).unbind("click");
	
	var swf_width = arguments[2] || 700;
	var swf_height = arguments[3] || 400;
	
	var fparams = {
			
		media_file_id: data["MediaFile"]["id"],
		xid:e.attr("xid"),
		legacy_preroll:data["MediaFile"]["preroll"],
		legacy_postroll:data["MediaFile"]["postroll"],
		server:window.location.hostname,
		preroll_server:'LEGACY',
		postroll_server:'LEGACY',
		loader:'/swf/player/BerricsPlayer.swf?rev=John1.7'
			
	};
	
	if(data["dailyop_id"]) {
		
		fparams.dailyop_id = data["dailyop_id"];	
	
	}
	
	
	var xiSwfUrlStr = "/swf/expressInstall.swf";
	var swfVersionStr = "0.0.0";
	var params = {};
	params.quality = "high";
	params.bgcolor = "#000000";
	params.play = "true";
	params.loop = "true";
	params.wmode = "gpu";
	params.scale = "noscale";
	params.menu = "true";
	params.devicefont = "false";
	params.salign = "";
	params.allowscriptaccess = "always";
	params.allowFullScreen = "true";
	var attributes = {};
	attributes.id = "BerricsPlayerLoader";
	attributes.name = "BerricsPlayerLoader";
	attributes.align = "left";
	
	swfobject.embedSWF(
			"/swf/player/BerricsPlayerLoader.swf?testing", id,
			swf_width, swf_height,
			swfVersionStr, xiSwfUrlStr,
			fparams, params, attributes);
	
}

function flashVideoPs3() {
	
	
}

function html5Video() {
	
	
	
}

function initCanteenProductThumbs() {
	
	$('.canteen-product-thumb').hover(
			function() { 

				$(this).find('.info').fadeIn();
				
			},
			function() { 

				$(this).find('.info').hide();
				
			}
		).click(function() { 

			var ref = $(this).find("a").attr("href");

			document.location.href = ref;
			
	});

	$('.canteen-product-thumb a').click(function() { 

		return false;

	});
	
	
	//super thumb
	$('.canteen-product-super-thumb').hover(
			function() { 

				$(this).find('.info').fadeIn();
				
			},
			function() { 

				$(this).find('.info').hide();
				
			}
		).click(function() { 

			var ref = $(this).find(".thumb-inner a").attr("href");

			document.location.href = ref;
			
	});

	
}


/****
 * 
 * DAILYOPS SLIDE SHOW
 * 
 */
var DailyopsSlideShow = {
			
		init:function() {
			/*
			$(".dailyop_media_item[slide_show=1]").bind('click.DailyopsSlideShow',function() { 
				
				DailyopsSlideShow.loadNext(this);
				
			});
			*/
	
		$(".dailyop_media_item[slide_show=1]").each(function() { 
			
			$(this).click(function() { DailyopsSlideShow.loadNext(this); });
			
		});
	
		},
		destroy:function() { 
			
			$('.dailyop_media_item[slide_show=1]').unbind('.DailyopsSlideShow');
			
		},
		loadNext:function(ele) {
			
			//var ele = arguments[0];
			
			var dailyop_id = $(ele).attr("dailyop_id");
			
			DailyopsSlideShow.showLoadingMsg(ele,"Loading...");
			
		},
		loadPrev:function() { 
			
			
			
		},
		showLoadingMsg:function() { // 1.Element 2.Message 3. Direction ( prev || next )
			
			var ele = arguments[0];
			var msg = arguments[1] || "Loading Next Item";
			var direction = arguments[2] || "next";
			var img = $(ele).find("img");
			var height = $(ele).height();
			
			$(ele).css({
				
				"position":"relative"
				
			});
			

			
			//send a request for a new image based on the post id and the display weight of the current image
			$.ajax({
				
				url:"/dailyops/ajax_slideshow/"+$(ele).attr("dailyop_id")+"/"+$(img).attr("display_weight")+"/"+direction,
				dataType:"json",
				success:function(d) {
		
					if(d != 0) {
						
						var w = d['DailyopMediaItem']['display_weight'];
						var f = d['MediaFile']['file_html'];
						var did = d['DailyopMediaItem']['dailyop_id'];
						//inject the new file
						$(".dailyop_media_item[dailyop_id="+did+"]").html(f)
						
					}

					
				}
				
			});
			
		},
		closeLoadingMsg:function() { 
			
			$('.dailyops-slide-show-msg').remove();
			
		}
	
		
};


/****
 * 
 * Canteen Widget
 * 
 */

var CartWidget = {
		
		openLoginScreen:function() { 
			
			if($("#login-overlay").length>0) {
				
				return false;
				
			}
	
			$('body').append("<div id='login-overlay'><div id='login-overlay-wrapper'><div id='login-overlay-box'><h1>- LOGIN TO THE BERRICS -</h1><div class='facebook'><a href='/identity/login/send_to_facebook'><img border='0' src='/img/login/facebook.png' /></a></div></div></div></div>");
			this.handleResize("intro");
			$("#login-overlay").click(function() { 
				
				CartWidget.handleClose();
				
			});
			
			$(window).bind('resize',function() { CartWidget.handleResize(); });
		},
		docReady:function() { 
			
			$("a[rel=cart-login]").click(function() { 
				
				CartWidget.openLoginScreen();
				
				return false;
			});
			
		},
		handleResize:function() { 
		
			
			
			var wh = $(window).height();
			var ww = $(window).width();

			if(arguments[0] == "intro") {
				
				$("#login-overlay-box").hide();
				
				$('#login-overlay').css({
					
					height:wh+'px'
					
				}).hide().fadeIn('normal',function() { 
					
					$("#login-overlay-box").slideDown('normal');
					
				});
				
				
			} 
			
			$('#login-overlay').css({
				
				height:wh+'px'
				
			});
			
			var lf = $("#login-overlay-box").height()/2;
			$("#login-overlay-box").css({
				
				"margin-top":((wh/2)-lf)+"px"
				
				
			});
			
		},
		handleClose:function() { 
			
			
			$(window).unbind('resize');
			$("#login-overlay").remove();
		}

		
};


/*
 * 
 * Base64 helper
 * 
 */

var Base64 = {
		 
		// private property
		_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
	 
		// public method for encoding
		encode : function (input) {
			var output = "";
			var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
			var i = 0;
	 
			input = Base64._utf8_encode(input);
	 
			while (i < input.length) {
	 
				chr1 = input.charCodeAt(i++);
				chr2 = input.charCodeAt(i++);
				chr3 = input.charCodeAt(i++);
	 
				enc1 = chr1 >> 2;
				enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
				enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
				enc4 = chr3 & 63;
	 
				if (isNaN(chr2)) {
					enc3 = enc4 = 64;
				} else if (isNaN(chr3)) {
					enc4 = 64;
				}
	 
				output = output +
				this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
				this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);
	 
			}
	 
			return output;
		},
	 
		// public method for decoding
		decode : function (input) {
			var output = "";
			var chr1, chr2, chr3;
			var enc1, enc2, enc3, enc4;
			var i = 0;
	 
			input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
	 
			while (i < input.length) {
	 
				enc1 = this._keyStr.indexOf(input.charAt(i++));
				enc2 = this._keyStr.indexOf(input.charAt(i++));
				enc3 = this._keyStr.indexOf(input.charAt(i++));
				enc4 = this._keyStr.indexOf(input.charAt(i++));
	 
				chr1 = (enc1 << 2) | (enc2 >> 4);
				chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
				chr3 = ((enc3 & 3) << 6) | enc4;
	 
				output = output + String.fromCharCode(chr1);
	 
				if (enc3 != 64) {
					output = output + String.fromCharCode(chr2);
				}
				if (enc4 != 64) {
					output = output + String.fromCharCode(chr3);
				}
	 
			}
	 
			output = Base64._utf8_decode(output);
	 
			return output;
	 
		},
	 
		// private method for UTF-8 encoding
		_utf8_encode : function (string) {
			string = string.replace(/\r\n/g,"\n");
			var utftext = "";
	 
			for (var n = 0; n < string.length; n++) {
	 
				var c = string.charCodeAt(n);
	 
				if (c < 128) {
					utftext += String.fromCharCode(c);
				}
				else if((c > 127) && (c < 2048)) {
					utftext += String.fromCharCode((c >> 6) | 192);
					utftext += String.fromCharCode((c & 63) | 128);
				}
				else {
					utftext += String.fromCharCode((c >> 12) | 224);
					utftext += String.fromCharCode(((c >> 6) & 63) | 128);
					utftext += String.fromCharCode((c & 63) | 128);
				}
	 
			}
	 
			return utftext;
		},
	 
		// private method for UTF-8 decoding
		_utf8_decode : function (utftext) {
			var string = "";
			var i = 0;
			var c = c1 = c2 = 0;
	 
			while ( i < utftext.length ) {
	 
				c = utftext.charCodeAt(i);
	 
				if (c < 128) {
					string += String.fromCharCode(c);
					i++;
				}
				else if((c > 191) && (c < 224)) {
					c2 = utftext.charCodeAt(i+1);
					string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
					i += 2;
				}
				else {
					c2 = utftext.charCodeAt(i+1);
					c3 = utftext.charCodeAt(i+2);
					string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
					i += 3;
				}
	 
			}
	 
			return string;
		}
	 
	}
