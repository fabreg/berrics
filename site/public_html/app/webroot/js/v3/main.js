var userAgent = navigator.userAgent.toLowerCase(),
browser   = '',
version   = 0;
$(function() {	

	//capture all ads 
	$.writeCapture.autoAsync();


	$(window).bind('resize.TopNav',function() { 

		var $w = $(window).width();

		if($w<=978) {

			$("#top-nav-div").hide();
			$("#top-nav-mobile").show();

		} else {

			$("#top-nav-div").show();
			$("#top-nav-mobile").hide();

		}
		
	}).trigger('resize');

	$("#mobile-nav-select").change(function() { 


		var uri = $(this).val();

		if(uri.length>0) document.location.href = uri;

		return;

	});

	$('header .user-info a.login-link').click(function() { 
		//alert("user click");
		openUserLogin($(this).attr("href"));
		return false;

	});
	initBrowserDetection();
	initLayout();
	initMediaDivs();
	initTrending();
	lazyLoad();

});

function lazyLoad () {
	
	$('img.lazy').lazyload({

			load:function(e) {

				var img = $('img').eq(e);

				$(img.get(0)).attr({

					"width":"",
					"height":""

				});

			}

		});
}

function initTrending () {
	
	$("#trending-content .tab:not(.active)").unbind().bind('click',function() { 

		$("#trending-content .loading").remove();

		$("#trending-content").append($("<div class='loading' />").append($("<div class='spinner' />")));

		$("#trending-content .loading").fadeIn('fast');

		var s = $(this).attr("data-section");
		$("#trending-content .tab").removeClass('active').unbind('click');
		$(this).addClass('active');
		$.ajax({

			"url":"/dailyops/trending/"+s,
			"success":function(d) {

				$("#trending-content tbody.content").html(d);
				lazyLoad();
				initTrending();
				$("#trending-content .loading").fadeOut('fast',function() { $("#trending-content .loading").remove(); });
			}


		});

	});

	$("#calendar-widget .cal-nav a").unbind().bind('click',function() {

		$("#calendar-widget").append($("<div class='loading' />").append($("<div class='spinner' />")));
		$("#calendar-widget .loading").fadeIn('fast');

		var uri = $(this).attr("href");

		$.ajax({

			"url":uri,
			"success":function(d) {

				$("#calendar-widget").html(d);
				initTrending();
				$("#calendar-widget .loading").fadeOut('fast',function() { $("#calendar-widget .loading").remove(); });
			}

		});
		return false;

	});

}

function initJWPlayer($ele) {

	
	var $div = $("#"+$ele);
	//alert($div.attr("data-media-file-id"));
	//return;

	var $media_file_id = $div.attr("data-media-file-id");

	var $dailyop_id = $div.attr("data-dailyop-id");

	var $poster = $div.attr("data-poster-file");

	var $container = "media-file-div-"+$media_file_id;

	//media service v2 request

	var $ms_uri = "/media_service/video_player_requestv2/media_file_id:"+$media_file_id;

	if($dailyop_id.length>0) $ms_uri += "/dailyop_id:"+$dailyop_id;
	

	$.ajax({

		url:$ms_uri,
		dataType:'json',
		success:function($d) { 

			var adObj = {

				"client":"googima",
				schedule:{}

			};

			if($d.prerollUrl) {

				adObj.schedule.adBreak1 = {

					offset:'pre',
					tag:$d.prerollUrl

				}

			} 

			adObj.schedule.adBreak1 = {

					offset:'pre',
					tag:$d.prerollUrl

				}
			/*
			if($d.postrollUrl) {

				adObj.schedule.adBreak2 = {

					offset:'post',
					tag:$d.postrollUrl

				}

			}
			*/

			jwplayer($container).setup({

		        file: $d.MediaFile.jw_url,
		        height: 396,
		        image: $poster,
		        width: "100%",
		        autostart:true,
		        primary:'flash',
		        advertising:adObj


		    });

		    jwplayer($container).onComplete(function() {

		        	alert($media_file_id);

		    });

		}

	});

	//alert($ms_uri);

}

function initMediaDivs () {
	

	
	//large posts || ASSUME ALL ARE VIDEO
	
	/*
	$('.featured-post .post-media-div').each(function() { 

		$type = $(this).attr("data-media-type");
		$this = $(this);
		$this.unbind();
		switch($type) {

			case 'bcove':

				if(!Modernizr.touch) {

					$this.hover(
					function(e) { 
						$(this).find('.video-hover').fadeIn().parent().find('.play-button').animate({opacity:1});
					},
					function(e) { 
						$(this).find('.video-hover').fadeOut().parent().find('.play-button').animate({opacity:.6});
					});

				}

				$this.click(function() { 
					
						$(this).videoDiv({
							beforeDataLoad:function(context) {

								var $data = $.data(context);

								$data.target.parent().parent().find('.post-footer,.post-top').show();

							}
						});
						$(this).unbind('click');

				});

			break;

		}

		$(this).attr("data-init",1);


	});
	*/

	$('.post-media-div:not([data-init])').each(function() { 

		$type = $(this).attr("data-media-type");
		$this = $(this);
		switch($type) {

			case 'bcove':

				if(!Modernizr.touch) {

					$this.hover(
					function(e) { 
						$(this).find('.video-hover').fadeIn().parent().find('.play-button').animate({opacity:1});
					},
					function(e) { 
						$(this).find('.video-hover').fadeOut().parent().find('.play-button').animate({opacity:.6});
					});

				}

				$this.bind('click',function(ev) { 
						
						//initJWPlayer($(this).attr("id"));

						initVideo($(this).attr("id"));

				});

			break;

		}

		$(this).attr("data-init",1);

	});

	

		//post thumb
	$('.post-thumb .thumb').each(function() { 

		if(!Modernizr.touch) {

			$(this).unbind().hover(
			function() { 
				$(this).find('.overlay').fadeIn().parent().find('.play-button').animate({opacity:1});
			},
			function() { 
				$(this).find('.overlay').fadeOut().parent().find('.play-button').animate({opacity:.6});;
			})

		}

	});

	return;

}

function initVideo ($ele_id) {
	

	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);

	if(isMobile) {

		$("#"+$ele_id).videoDiv();

	} else {

		initJWPlayer($ele_id)

	}

}

function openUserLogin () {
		
	var uri = arguments[0] || "/identity/login/form";

	$('body').append("<div id='user-login-modal' class='modal hide'><div style='text-align:center; padding:15px;'><img border='0' src='/img/v3/layout/loader-clear.gif'/></div></div>");

	var modal = $("#user-login-modal");
	
	//modal.modal({'backdrop':'static'});

	$.ajax({

		"url":uri,
		"success":function(d) {

			modal.html(d);

		}

	});

	modal.modal('show');

}

function initNav () {
	// body...

	$("#top-dropdown").unbind();

	$("#top-nav-div").find("#top-dropdown").
	hover(
		function() {
			$("#top-dropdown-menu").slideDown('fast');
		},
		function() {
			$("#top-dropdown-menu").hide();
		}
	);

	$("#top-nav-mobile").find("#top-dropdown-menu").show();
	$("#top-nav-div #top-dropdown-menu").hide();

	//features list
	

}

function initLayout() {
	
	initNav();


	//format flash messages to alert

	$("#flashMessage.message").each(function() { 

		$(this).addClass("alert").addClass("alert-info");

	});
	
}

function berricsRelatedVideoScreen (media_file_id,dailyop_id) {
	
	var div = $('.post-media-div[data-media-file-id="'+media_file_id+'"]').html();

	console.log(media_file_id);
	console.log(dailyop_id);
	$(div).videoDiv('videoEndScreen',div);

}

function handleVideoEnd() {

	var obj = JSON.parse(arguments[0]);

	//console.log(obj);

	var media_file_id = obj.MediaFile.id;
	var dailyop_id = obj.Dailyop.id;

	$(".post-media-div[data-media-file-id="+media_file_id+"][data-dailyop-id="+dailyop_id+"]").load(
		"/media_service/end/media_file_id:"+media_file_id+"/dailyop_id:"+dailyop_id,
		function(d) { 

			$(".post-media-div[data-media-file-id="+media_file_id+"][data-dailyop-id="+dailyop_id+"]").find('.replay-btn').bind('click',function(e) { 

              $(".post-media-div[data-media-file-id="+media_file_id+"][data-dailyop-id="+dailyop_id+"]").videoDiv();
              return false;

          });

		}
	);

}

function initBrowserDetection () {

	$.browser.chrome = /chrome/.test(navigator.userAgent.toLowerCase());

	// Is this a version of IE?
	if ($.browser.msie) {
	  userAgent = $.browser.version;
	  userAgent = userAgent.substring(0,userAgent.indexOf('.'));	
	  version = userAgent;
	  browser = "Internet Explorer";
	}

	// Is this a version of Chrome?
	if ($.browser.chrome) {
	  userAgent = userAgent.substring(userAgent.indexOf('chrome/') + 7);
	  userAgent = userAgent.substring(0,userAgent.indexOf('.'));	
	  version = userAgent;
	  // If it is chrome then jQuery thinks it's safari so we have to tell it it isn't
	  $.browser.safari = false;
	  browser = "Chrome";
	}

	// Is this a version of Safari?
	if ($.browser.safari) {
	  userAgent = userAgent.substring(userAgent.indexOf('safari/') + 7);	
	  userAgent = userAgent.substring(0,userAgent.indexOf('.'));
	  version = userAgent;	
	  browser = "Safari";
	}

	// Is this a version of Mozilla?
	if ($.browser.mozilla) {
		//Is it Firefox?
		if (navigator.userAgent.toLowerCase().indexOf('firefox') != -1) {
			userAgent = userAgent.substring(userAgent.indexOf('firefox/') + 8);
			userAgent = userAgent.substring(0,userAgent.indexOf('.'));
			version = userAgent;
			browser = "Firefox"
		}
		// If not then it must be another Mozilla
		else {
		  browser = "Mozilla (not Firefox)"
		}
	}

	// Is this a version of Opera?
	if ($.browser.opera) {
		userAgent = userAgent.substring(userAgent.indexOf('version/') + 8);
		userAgent = userAgent.substring(0,userAgent.indexOf('.'));
		version = userAgent;
		browser = "Opera";
	}
}

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
function urldecode(str) {
   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

