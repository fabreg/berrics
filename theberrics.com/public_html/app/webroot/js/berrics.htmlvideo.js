(function($) { 
	
	
	var methods = {
			
			VAST_TEST_URL:"http://pubads.g.doubleclick.net/gampad/ads?sz=700x394&iu=%2F5885%2Fvast_pre&ciu_szs=&impl=s&gdfp_req=1&env=vp&output=xml_vast2&unviewed_position_start=1&url=%5Breferrer_url%5D&correlator=%5Btimestamp%5D",
			VPRE001:"http://pubads.g.doubleclick.net/gampad/ads?sz=700x394&iu=%2F5885%2FVPRE001&ciu_szs=&impl=s&gdfp_req=1&env=vp&output=xml_vast2&unviewed_position_start=1&url=[referrer_url]&correlator=[timestamp]",
			LIMELIGHT_URL: "http://berrics.vo.llnwd.net/o45/",
			init:function(options) {
				
				console.log(Modernizr);
		
				var $this = this;
				
				//populate default data
				var data = $.data($this,{
					
					"target":$this,
					"options":$.extend({
						
						"PosterDomain":"http://img.theberrics.com/video/stills/",
						"PosterImage":"5898cf7f99028ddf37d93c4aba4fc88f.jpg",
						"MediaFileId":"4e98c904-f300-4269-b732-0d39323849cf",
						"LazyLoad":null,
						"VideoWidth":700,
						"VideoHeight":396,
						"PlayCount":0,
						"PlayAction":"PreRoll",
						"PreRoll":null,
						"PostRoll":null,
						"DailyopId":3786,
						"BufferInterval":false,
						"ControlsTimeout":false,
						"GoogleAdsManager":false,
						"Playback":"FLASH"
						
						
					},options)
					
				});

				//methods.determinePlayback($this);
				methods.initBrowser($this);
				return this;
				
			},
			initBrowser:function(context) { 
				
				var data = $.data(context);	
				
				console.log("INIT BROWSER");
				
				if(/(probably)/ig.test(Modernizr.video.h264)) {
				
					console.log("USE H264");
					data.options.Playback = "HTML";
					
				} else {
					
					console.log("USE FLASH")
					data.options.Playback = "FLASH";
					
				}
				
				console.log(Modernizr.video);
				
				methods.initDiv(context);
				
			},
			initMobile:function(context) { },
			
			returnHtml:function(context) {
				
				var data = $.data(context);
				
				var div = $("<div class='berrics-html-video-div' />")
								.append("<div class='click-element'/>")
								.append("<div class='pause-overlay' />")
								.append("<video />")
								.append(
										$("<div class='controls' />")
										.append(
												$("<div class='inner' />")
												.append(
														$("<div class='button playpause-div' />")
														.append("<input type='button' value='' class='playpause-button'/>")
												)
												.append(
														$("<div class='button seekback-div' />")
														.append("<input type='button' value='' class='seekback-button'/>")	
												)
												.append(
														$("<div class='button seekforward-div' />")
														.append("<input type='button' value='' class='seekforward-button'/>")	
												)
												.append(
														$("<div class='tracking' />")
														.append("<div class='play-marker'/>")
														.append("<div class='buffer-bar'/>")
														.append("<div class='duration-bar'/>")
												)
												.append("<input type='text' disabled='disabled' value='' class='duration'/>")
												.append(
														$("<div class='button fullscreen-div' />")
														.append("<input type='button' value='' class='fullscreen-button'/>")
												)
												.append("<div class='slowmotion-button'/>")
								)
							);
							
				
				
				
			
				$(div).find("video,.berrics-html-video-div").css({
					
					"background-color":"#000"
					
				}).attr({
					
					"width":data.options.VideoWidth+"px",
					"height":data.options.VideoHeight+"px"
					
				});
				
				return div;
				
			},
			requestVideoData:function(context) {
				
				var data = $.data(context);
				
				var opt = {
					"type":"post",
					"dataType":"JSON",
					"url":"/media/json_video_service",
					"success":function(d) {
					
						data.options.ServerData = d;
						
						switch(data.options.Playback) {
						case "FLASH":
							methods.flashFallBack(context);
							break;
						case "HTML":
							methods.html5VideoPlayer(context);
							break;
						default:
								console.log("BerricsHtmlVideo.requestVideoData AJAX CALLBACK could not find a valid playback type");
							break;
						}
						//methods.bootstrapVideo(context);
						
						
					},
					"data":{
						"data":{
							"json":JSON.stringify({	
								"media_file_id":data.options.MediaFileId,
								"dailyop_id":data.options.DailyopId	
							})
						
						}
					}
						
				};
				
				$.ajax(opt);
				
			},
			bootstrapVideo:function(context) {
				
				var data = $.data(context);
				
				data.target.unbind('click');
				
				
				
				switch(data.options.Playback) {
				
					case "HTML":
						methods.html5VideoPlayer(context);
						break;
					default:
							console.log("Flash fallback");
						methods.flashFallBack(context);
						break;
				
				}
				
			},
			initDiv:function(context) { 
				
				var data = $.data(context);
				data.target.find('.overlay').css({
    				
    				"opacity":.6
    				
    			});
				data.target.hover(function() { 
					
					data.target.find('.overlay').fadeIn();
					
				},function() {
					
					data.target.find('.overlay').fadeOut();
					
				});
				data.target.click(function() { 
					
					methods.requestVideoData(context);
					data.target.unbind('click');
					
				});
			},
			initVideoEvents:function(context) { 
				
				var data = $.data(context);
				var video = data.target.find("video");
				var click_element = data.target.find('.click-element');
				var pause_overlay = data.target.find('.pause-overlay');
				
				video.unbind();
				pause_overlay.unbind().css({"opacity":.4}).hide();
				click_element.unbind().hide();
				
				video.bind('loadstart',function() { 
					//stub
				}).bind('timeupdate',function() {
					
					methods.handleTimer(context);
					
				}).bind("pause",function() { 
					
					console.log("Video Pause Event");
					console.log(video.get(0).paused);
					//show the pause overlay
					
					data.target.find(".pause-overlay").show();
					data.target.find('.playpause-button').removeClass('button-state-play').addClass('button-state-pause');
					
				}).bind('play',function() { 
					
					console.log("Play Event Fired")
					data.target.find('.playpause-button').addClass('button-state-play').removeClass('button-state-pause');

				});
				
				//bind the other elements
				
				//the main controls hover
				data.target.unbind('mousemove').bind('mousemove',function(e) {
					
					data.target.find('.controls').fadeIn('fast');
					clearTimeout(data.options.ControlsTimeout);
					data.options.ControlsTimeout = setTimeout(function() { 
						
						data.target.find('.controls').fadeOut();
						
					},1750);
					
				}).resize(function() { 
					
					methods.handleResize(context);
					
				});
				
				
				
				//pause overlay
				pause_overlay.click(function() { 
					
					console.log("Pause overlay click");
					pause_overlay.hide();
					video.get(0).play();
					
					
				});
				
				//playbutton
				data.target.find('.playpause-button').unbind().click(function() { 
					
					console.log("Play-Pause button clicked");
					
					methods.togglePause(context);
					
					
					
				});
				
				
				
				//fullscreen
				data.target.find(".fullscreen-button").unbind().click(function() { 
					
					methods.toggleFullscreen(context);
					
				});
				
				//hovers
				data.target.find('.button').hover(
						function(e) {						
							
							$(e.currentTarget).addClass('button-hover');
							
						},
						function(e) { 
							
							$(e.currentTarget).removeClass('button-hover');
							
						}
				);
				
				
				
			},
			toggleFullscreen:function(context) { 
				
				var data = $.data(context);
				var video = data.target.find("video");
			
				
			},
			togglePause:function(context) {
				
				var data = $.data(context);
				var video = data.target.find("video");
				
				if(video.get(0).paused == false) {
				
					video.get(0).pause();
					
				} else {
					
					video.get(0).play();
					
				}
				
				
			},
			createHover:function(context) { 
				
				
				
			},
			handleResize:function(context) { 
				
				var data = $.data(context);
				
				//get the left and right shim
				
				
				
			},
			handleTimer:function(context) { 
				
				var data = $.data(context);
				var video = data.target.find("video");
				
				var ve = video.get(0);
				var duration = ve.duration;
				var ct = ve.currentTime;
				var percentPlayed = (ct * 100) / duration;
				var sliderPixel = Math.ceil((percentPlayed * 5));


				// lets setup the timeline timer

				var total_min = Math.floor(duration / 60);

				var total_seconds = Math.floor(duration
						- (total_min * 60));

				var played_min = 0;

				if (ct >= 59) {

					played_min = Math.floor(ct / 60);

				}

				var played_seconds = ct;

				played_seconds = Math.floor(ct - (played_min * 60));

				// clean up the seconds

				if (played_seconds < 10) {

					played_seconds = "0" + played_seconds;

				}

				if (total_seconds < 10) {

					total_seconds = "0" + total_seconds;

				}
				
				
				data.target.find('.controls .duration').val(played_min+":"+played_seconds+" / "+total_min+":"+total_seconds);
				
				if(ct>=duration) { 
				
					console.log("Handle Timer Firing End Event");
					
					return methods.handleVideoEnd(context);
					
				}
				
				//video.get(0).addEventListener('') 
				
				
			},
			handleBuffer:function(context) {
				
				var data = $.data(context);
				var video = data.target.find("video");
				var duration = video.get(0).duration;
				
				try {
					
					var buffer_end = video.get(0).buffered.end(0);
					
				} catch(e) {
					
					console.log("Handle Buffer: get buffer error");
					console.log(e);
					
				}
				
				
				var percentBuffered = Math.ceil((buffer_end * 100) / duration);
				
				if(percentBuffered >= 100) {
					
					clearInterval(data.options.BufferInterval);
					console.log("Buffer Interval Completed");
					
				}
				
				//console.log("Percent Buffered: "+percentBuffered);
				
			},
			handleVideoPlay:function(context) {
			
				var data = $.data(context);
			
				clearInterval(data.options.BufferInterval);
				data.options.BufferInterval = false;
				
				if(data.options.PlayAction!='Exit') {
					
					data.options.BufferInterval = setInterval(function() { 
						
						methods.handleBuffer(context);
						
					},500);
				
				}
				
				methods.initVideoEvents(context);
				
				
				switch(data.options.PlayAction) {
				
					case "PreRoll":
						
						//data.options.PlayAction = "Video";
						//return methods.handleVideoPlay(context);
						
						
						if(data.options.ServerData.MediaFile.preroll === null || data.options.ServerData.MediaFile.preroll.strlen<=0) {
							
							console.log("Pre Roll Not Found. Change Action and re-run Method");
							data.options.PlayAction = "Video";
							return methods.handleVideoPlay(context);
							
						} 
						//play the preroll!
						console.log("Play PreRoll");
						methods.loadGoogleAd(context);
						break;
					case "PostRoll":
						break;
					case "Exit":
						
							methods.realtedVideoScreen(context);
							
						break;
					case "Video":
					default:
						
						var video = data.target.find("video");
						
						video.html('').attr({"src":null});
						
						var video_element = $(video).get(0);
						
						video.attr({
							
							"src":methods.LIMELIGHT_URL + data.options.ServerData.MediaFile.limelight_file,
							"controls":false
							
						});
						
						video_element.play();
						
						break;
				}
				
				
				
			},
			handleVideoEnd:function(context) {
				
				var data = $.data(context);
				
				if(data.options.GoogleAdsManager) {
					
					console.log("GoogleAdsManager Set! Try and unload and remove it");
					data.options.GoogleAdsManager.unload();
					data.options.GoogleAdsManager = false;
					
					
				}
				
				
				switch(data.options.PlayAction) {
				
					case "PreRoll":
						
						data.options.PlayAction = "Video";
						
						break;
						
					case "Video":
						
						data.options.PlayAction = "Exit";
						
						
						break;
				}
				
				
				
				methods.handleVideoPlay(context);
				
			},
			html5VideoPlayer:function(context) {

				console.log("Html5 Video Player");
				
				var data = $.data(context);
				
				data.target.html(methods.returnHtml(context));

		    	methods.handleVideoPlay(context);
				
			},
			flashFallBack:function(context) {
					
					var data = $.data(context);

					var e = data.target;
					$(e).unbind("click");
					
					var swf_width = data.options.VideoWidth || 700;
					var swf_height = data.options.VideoHeight || 400;
					
					var fparams = {
							
						media_file_id: data.options.ServerData["MediaFile"]["id"],
						xid:e.attr("xid"),
						legacy_preroll:data.options.ServerData["MediaFile"]["preroll"],
						legacy_postroll:data.options.ServerData["MediaFile"]["postroll"],
						server:window.location.hostname,
						preroll_server:'GOOGLE',
						postroll_server:'GOOGLE',
						loader:'/swf/player/BerricsPlayerFallback.swf?rev=John1.13'
							
					};
					
					if(data.options.ServerData["dailyop_id"]) {
						
						fparams.dailyop_id = data.options.ServerData["dailyop_id"];	
					
					}
					
					fparams.override_data = escape(JSON.stringify(data.options.ServerData));
					
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
							"/swf/player/BerricsPlayerLoader.swf?testing", $(e).attr("id"),
							swf_width, swf_height,
							swfVersionStr, xiSwfUrlStr,
							fparams, params, attributes);
					
				
			},
			loadGoogleAd:function(context) {
				
				var data = $.data(context);
				var adsLoader = new google.ima.AdsLoader();
				
				adsLoader.addEventListener(
				    google.ima.AdsLoadedEvent.Type.ADS_LOADED,
				    function(e) {
				    	
				    	data.options.GoogleAdsManager = e.getAdsManager();
				    	
				    	console.log("Google Adsmanager Start");
				    	
				    	//handle the end of the ad
				    	data.options.GoogleAdsManager.addEventListener(
				    			 google.ima.AdEvent.Type.COMPLETE,
				    			function(ee) {
				    				
				    				console.log("Ad Completed Playing");
				    		
				    			},
				    			false
				    	);
				    	
				    	//configure the click element
				    	data.options.GoogleAdsManager.setClickTrackingElement(data.target.find(".click-element").show().get(0));
				    	
				    	//play the ad
				    	data.options.GoogleAdsManager.play(data.target.find("video").get(0));
			
				    },
				    false);
				adsLoader.addEventListener(
				    google.ima.AdErrorEvent.Type.AD_ERROR,
				    function(e) { 
				    	
				    	console.log("Google Video Ad Error: ");
				    	console.log(e.getError());
				    	
				    	if(data.options.PlayAction=="PreRoll") {
				    		
				    		data.options.PlayAction="Video";
				    		
				    	} else {
				    	
				    		data.options.PlayAction = "Exit";
				    		
				    	}
				    	
				    	return methods.handleVideoPlay(context);
				    	
				    	
				    },
				    false);
				
				var ad_url;
				
				switch(data.options.PlayAction) {
					
					case "PreRoll":
						ad_url = data.options.ServerData.MediaFile.preroll;
						break;
					case "PostRoll":
						ad_url = data.options.ServerData.MediaFile.postroll;
						break;
				
				}
				console.log(ad_url);
				 adsLoader.requestAds({
					  adTagUrl: ad_url,
					  adType: "video"
					});
				 
				 console.log(adsLoader);
				
			},
			realtedVideoScreen:function(context) {
				
				var data = $.data(context);
				
				$.ajax({
					
					"url":"/dailyops/related/"+data.options.DailyopId,
					"success":function(d) {
						
						var ele = data.target;
					
						methods.destroy(context);
						
						$(ele).html(d);
						
						$(ele).find(".icon").css({"opacity":.5});

						//make the replay button clickable
						
						format_berricsRelatedVideoScreen();
					}
					
				});
				
			},
			destroy:function(context) { 
				
				var data = $.data(context);
				
				try {
					
					clearInterval(data.options.BufferInterval);
					data.options.BufferInterval = false;
				}
				catch(e) {
					
				}
				
				$.removeData(context);
				
			}
			
			
	};
	
	
	$.fn.BerricsHtmlVideo = function(method) {
	
		if ( methods[method] ) {
			
	      return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
	      
	    } else if ( typeof method === 'object' || ! method ) {
	    	
	      return methods.init.apply( this, arguments );
	      
	    } else {
	    	
	      $.error( 'Method [' +  method + '] does not exist' );
	      
	    }    
		
	};
	

})(jQuery);