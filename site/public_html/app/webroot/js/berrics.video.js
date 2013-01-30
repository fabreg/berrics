(function($) {

	var methods = {
		playerHtml : "<div class='berrics-html5-video'><video class='berrics-video' playCount='0' preRollStatus='0' postRollStatus='0' mediaFileStatus='0'></video>"
				+ "<div class='controls'>"
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
				+ "</div>"
				+"</div>",
		init : function(context, opt) {

			var $this = $(context);

			// build the append the HTML for the player
			if (opt.append) {
				$this.append(this.playerHtml);
			} else {
				$this.html(this.playerHtml);
			}

			// attach data
			$.data($this,
					{

						obj : this,
						target : $this,
						video : $this.find("video").get(0),
						settings : opt,
						chrome : navigator.userAgent.toLowerCase().indexOf('chrome') > -1

					});
			
			
			

			// handle some clicks and hovers
			
			///play button
			$this.find('.controls .playbutton').click(function() {
				
				var data = $.data($this);
				
				var v = data.video;
				
				if(v.paused == false) {
				
					v.pause();
					
				} else {
					
					v.play();
					
				}
				
			}).hover(
				function() {
					
					$(this).addClass('play-hover');
					
				},
				function() {
					
					$(this).removeClass('play-hover');
					
				}
			);
			
			
			///mute button
			$this.find('.controls .mutebutton').click(function() { });
			
			
			$this.hover(

				function() {
	
					$(this).find('.controls').fadeIn();
	
				}, function() {
	
					$(this).find('.controls').fadeOut();
	
				}

			).find('.slider .progress').click(function(e) {

				var v = $.data($this).video;

				var offset = $(this).offset();

				var x = e.pageX - offset.left;

				var click_percent = (x * 100) / 500;

				var goTo = (v.duration * (click_percent / 100));

				v.currentTime = goTo;

				v.play();

			});

			// bind the events
			$this.find("video").attr({"preload":"auto"}).css( {

				width : opt.videoWidth + "px",
				height : opt.videoHeight + "px"

			}).bind('ended', function(e) {

				$.data($this).obj.clearBufferInterval($this);
				
				var count = $.data($this).target.find("video").attr("playCount");
				
				count = parseInt(count)+1;
				
				
				
				$.data($this).target.find("video").attr({"playCount":count});
				
				$.data($this).obj.initVideo($this);

			}).bind(
					'timeupdate',
					function(e) {

						var v = $.data($this).target.find('video');

						var t = v.attr("currentTime");

						var duration = v.attr("duration");

						var percentPlayed = (t * 100) / duration;

						var sliderPixel = Math.ceil((percentPlayed * 5));

						$.data($this).target.find(".marker").css( {

							"left" : sliderPixel + "px"

						});

						// lets setup the timeline timer

						var total_min = Math.floor(duration / 60);

						var total_seconds = Math.floor(duration
								- (total_min * 60));

						var played_min = 0;

						if (t >= 59) {

							played_min = Math.floor(t / 60);

						}

						played_seconds = t;

						played_seconds = Math.floor(t - (played_min * 60));

						// clean up the seconds

						if (played_seconds < 10) {

							played_seconds = "0" + played_seconds;

						}

						if (total_seconds < 10) {

							total_seconds = "0" + total_seconds;

						}

						$.data($this).target.find(".timer").html(
								played_min + ":" + played_seconds + " | "
										+ total_min + ":" + total_seconds);

					}).bind("contextmenu", function() {
				return false;
			}).bind('canplaythrough', function(e) {

				if (!$.data($this).chrome) {

					//e.target.play();

				}

			}).bind("play", function(e) {

				$.data($this).obj.startBufferInterval($this);
				$.data($this).target.find(".playbutton").addClass("play").removeClass('pause');

			}).bind('pause', function() {
				
				$.data($this).target.find(".playbutton").addClass("pause").removeClass('play');
				
			});

			
			alert("Berrics Video");
			
			//bootstrap the video process
			this.initVideo($this);
			
			// start up the buffer checking
			this.startBufferInterval($this);
			
			/*
			if(opt.preRollAd) {
			
				$.data($this).target.find("video").attr({
					
					"src":opt.preRollAd.video,
					"type":"video/mp4",
					"autoplay":false
					
					
				});
				
			} else {
				
				$.data($this).target.find('video').attr( {
					"src" : opt.file,
					"type" : "video/mp4",
					"autoplay" : false
				});
				
			}
			*/
			

			$.each($.browser, function(i, val) {
				$("<div>" + i + " : <span>" + val + "</span></div>").appendTo(
						document.body);
			});
		},
		checkBuffer : function(context) {

			var data = $.data(context);

			var v = data.video;

			var buffer_end = v.buffered.end(0);

			var duration = data.target.find('video').attr('duration');

			var percentBuffered = Math.ceil((buffer_end * 100) / duration);

			// show the progress on the slider

			data.target.find('.slider .progress').css( {

				"width" : (percentBuffered * 5) + "px",
				"height" : "10px"

			});

			data.target.find(".controls .loaded").html(
					"Loading:" + percentBuffered + "%");

			// $("#loaded").html("Loaded: "+percentBuffered);

			// if we're on chrome then let's start the video after the buffer
			// has reached our min seconds

			if (percentBuffered >= data.settings.bufferPercentage && !data.autostarted) {

				data.video.play();
				$.data(context,"autostarted",true);
				
			}
			
			$('body').append(percentBuffered + "<br />");

		},
		startBufferInterval : function(context) {
			
			if (!$.data(context).bufferCheckInterval) {
				
				$.data(context, "bufferCheckInterval", setInterval(this.checkBuffer, 500, context));
				
				//$.data(context, "bufferCheckInterval", setInterval(function() { $.data(context).obj.checkBuffer(context); }, 500));
			}

		},
		clearBufferInterval : function(context) {

			clearInterval($.data(context).bufferCheckInterval);
			$.data(context, "bufferCheckInterval", false);

		},
		initVideo:function(context) {
			
			var data = $.data(context);
			var playCount = parseInt(data.target.find("video").attr("playCount"));
			alert("Init Video Count:"+playCount);
			switch(playCount) {
			
				case 0:
					
					
					if(data.settings.preRollAd && !data.settings.preRollStatus) {
						
						data.obj.runPreroll(context);
						
					} else {
						
						data.obj.runVideo(context);
						
					}
				break;
				case 1:
					
					alert("Play count 1");
					data.obj.runVideo(context);
				break;
				default:
					alert("Play Count Not Found");
				break;
			}
			
		},
		runPreroll:function(context) {
			
			var data = $.data(context);
			
			data.target.find('video').attr({
				
				"src":data.settings.preRollAd.video,
				"type":"video/mp4",
				"preRollStatus":1
			});
			
			$('body').append("<img src='"+data.settings.preRollAd.pixel+"' />");
			
			$.data(context,"advertising",true);
			
		},
		runPostroll:function(context) {
			
		},
		runVideo:function(context) {
			
			var data = $.data(context);
			
			data.target.find("video").attr({
				
				"src":data.settings.mediaFile.brightcove_url,
				"type":"video/mp4",
				"mediaFileStatus":1
				
				
			});
			
			$.data(context,"advertising",false);
			$.data(context).obj.startBufferInterval(context);
			
		},
		destroy : function() {
		}

	};

	$.fn.berricsHtmlPlayer = function(options) {

		var $this = $(this);

		var defaults = {

			videoWidth : "728",
			videoHeight : "500",
			bufferPercentage : 10,
			file : "http://brightcove.vo.llnwd.net/d13/unsecured/media/17214305001/17214305001_724203162001_Shane-ONeill-BC-Deck-Slate.mp4?pubId=17214305001&videoId=724195989001",
			append : false,
			autostarted:false,
			advertising:false,
			playCount:0,
			preRollAd:false,
			postRollAd:false,
			preRollStatus:false,
			postRollStatus:false,
			mediaFileStatus:false
		};

		var opt = $.extend( {}, defaults, options);

		methods.init($this, opt);

	};
	
	$.fn.berricsVideo = function(options) {
		
		
	};

})(jQuery);