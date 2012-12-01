(function( $ ){

  var methods = {
    LIMELIGHT_URL: "http://berrics.vo.llnwd.net/o45/",
    CONTROLS:function() { 

      var HTM = "<div class='controls'>\
                  <div class='inner'>\
                    <div class='play-btn'></div>\
                    <div class='slowmo-btn'></div>\
                    <div class='slider'>\
                      <div class='tracking-bar'>\
                        <div class='buffer'></div>\
                        <div class='prog-bar'></div>\
                        <div class='seekhead'><div class='time-bubble'><div class='inner'></div></div></div>\
                        <div class='playhead'><div class='time-bubble'><div class='inner'></div></div></div>\
                      </div>\
                    </div>\
                    <div class='volume'>\
                      <div class='inner'>\
                        <div class='vol'></div>\
                        <div class='vol'></div>\
                        <div class='vol'></div>\
                        <div class='vol'></div>\
                        <div class='vol'></div>\
                        <div class='vol'></div>\
                      </div>\
                    </div>\
                    <div class='fullscreen-btn'></div>\
                  </div>\
                </div>";

        return HTM;

    },
    init : function( options ) { 

      var $this = this;

      var $that = $($this);

      var service_uri = "/media_service/video_player_request";

      //build the request data for the video_play_request
      var req = {};
      req.data = {};

      if($that.attr("data-media-file-id")) {

        req.data.media_file_id = $that.attr("data-media-file-id");

      }

     if($that.attr("data-dailyop-id")) {

        req.data.dailyop_id = $that.attr("data-dailyop-id");

      }

      var data = $.data($this,{

            "target":$this,
            "parent":$that.parent(),
            "request":false,
            "bufferInterval":false,
            "controlsTimeout":false,
            "playingAd":false,
            "GoogleAdsManager":false,
            "videoFormat":"mp4"

          });

      methods.initHtml($this);
      //get the video data
      $.ajax({

        "type":"post",
        "dataType":"json",
        "data":req,
        "url":service_uri,
        "success":function(d) { 

          data.request = d;

          //check if the browser supports h.264
          if(/(probably)/ig.test(Modernizr.video.h264)) {
            
            console.log("USE H264");

          } else {
            
            console.log("USE OGV");
            
            data.videoFormat="ogv";
            
          }
          
          
          methods.handleVideoPlay($this);
        }


      });

      return $this;

    },
    initHtml:function(context) {

      var $data = $.data(context);

      var $this = $data.target;

      $this.html($("<div class='video-div' />").append($("<div class='loader' /><div class='click-element' /><div class='pause-overlay'><div class='play-icon'></div></div><video autoplay='true' />")));

      var video_div = $this.find(".video-div");

      video_div.append(methods.CONTROLS());

      //build the controls
      var video = $this.find("video");

      video.attr({

        "controls":false,
        "autoplay":true

      });

      console.log($data.parent);

      $this.find('.loader').show();

    },
    initFlash:function(context) {



      
    },
    initHtmlEvents:function(context) {

      var $data = $.data(context);

      var $this = $data.target;

      var video = $this.find("video");

      var video_ele = video.get(0);

      var controls = $this.find(".controls");

      var play_btn = controls.find('.play-btn');

      var slowmo_btn = controls.find('.slowmo-btn');

      var fullscreen_btn = $this.find('.fullscreen-btn');

      var slider = controls.find('.slider');

      var pause_overlay = $this.find(".pause-overlay");
      
      var tracking_bar = $this.find('.tracking-bar');

      video.unbind().
      bind('loadstart',function(e) { }).
      bind('timeupdate',function(e) { 
          methods.handleTimer($this);
      }).
      bind('pause',function(e) {

          
            play_btn.removeClass('paused');
          pause_overlay.show();

      }).
      bind('play',function(e) { 

        $this.find('.loader').hide();

        play_btn.addClass('paused');

        pause_overlay.hide();

        if(!$data.bufferInterval) {

          $data.bufferInterval = setInterval(
            function() { methods.handleBuffer(context) },500
          );

        }

      });

      pause_overlay.unbind().bind('click',function() { 

        video_ele.play();

      });

      //bind the play button
      play_btn.unbind().bind('click',function() { 

          if(play_btn.hasClass('paused')) {

            video_ele.pause();

          } else {

            
            video_ele.play();

            if(slowmo_btn.hasClass("active")) {

              video_ele.playbackRate = 1;
              slowmo_btn.removeClass("active");

            }
          }

      });

      //bind the slow motion button

     slowmo_btn.unbind().bind('click',function() { 

          var rate = 1;
          
          switch(video_ele.playbackRate) {
          
            case 1:
              rate = .25;
            break;
            
          }
          
          video_ele.playbackRate = rate;
          
          if(rate==1) {

            slowmo_btn.removeClass('active');

          } else {

            slowmo_btn.addClass("active");
            
          }

     });

     fullscreen_btn.unbind().
     bind('click',function(e) { 

      $this.find('.video-div').toggleFullScreen();
      
        //$this.toggleFullScreen();
        //$this.get(0).webkitRequestFullscreen();
        //  alert("fuck");

     });

     $this.find('.volume .vol').unbind().
     bind('click',function(e) { 

      var ind = $(e.target).index();

      var vol = (ind*20);

      var total_vol = $this.find('.vol').length;

      $this.find('.volume .vol').removeClass('off');

      for(var i = 1;i<=total_vol;i++) {

        if((i-1)>ind) {

          $this.find('.volume .vol').eq((i-1)).addClass('off');

        } 

      }


      if(vol<100) {

        vol = "."+vol;

      } else {

        vol = 1;

      }

      video_ele.volume = vol;

     });

     tracking_bar.unbind().
     hover(
      function() {

        $this.find('.seekhead').show();

      },
      function() {

        $this.find('.seekhead').hide();

      }
    ).bind('mousemove',function(e) { 

      //slider bars offeset
      var so = $this.find('.tracking-bar').offset();

      var px = e.pageX;
 
      var mx = px-so.left;

      var bw = $this.find('.tracking-bar').width();

      var dur = video_ele.duration;

      var tp = (dur/100);

      var bp = Math.floor((mx/bw)*100);

      var ct = bp*tp;

      $this.find('.seekhead .time-bubble .inner').html(methods.formatVideoTime(ct));

      $this.find('.seekhead').css({"left":(mx-1)+"px"});

      console.log("Mouse X: "+mx);

    }).bind('click',function(e,ui) { 
      
        var duration = video.get(0).duration;
       
        //tracking offset to body
        var bO = $this.find('.tracking-bar').offset();
        //mouse position relative to tracking bar
        var tPos = (e.pageX - bO.left);
        
        //tracking bar width
        var wBar = $this.find('.tracking-bar').width();
        //percentage of mouse position in tracking bar
        var bPercent = Math.floor((tPos/wBar)*100);
        //percentage of the duration of the video
        var tPercent = (duration/100);
        
        video_ele.currentTime = bPercent*tPercent;
        
    });

     //show and hide the controls
     $this.unbind("mousemove").bind("mousemove",function(e) { 

        controls.fadeIn("fast");
        clearTimeout($data.controlsTimeout);
        $data.controlsTimeout = false;
        $data.controlsTimeout = setTimeout(function() { 

          controls.fadeOut("normal");

        },1750);

     });

    },
    handleTimer:function(context) {

        var $data = $.data(context);

        var $this = $data.target;

        var video = $this.find("video");
        
        var prog_bar = $this.find('.slider .prog-bar');

        var ve = video.get(0);
        var duration = ve.duration;
        var ct = ve.currentTime;
        var percentPlayed = (ct * 100) / duration;


        prog_bar.css({"width":percentPlayed+"%"});

        var sliderPixel = Math.floor((percentPlayed * ($data.target.find('.tracking-bar').width()/100)));

        if(sliderPixel>0) {

            $this.find(".playhead").css({

              "left":sliderPixel+"px"

             });

            var timeStr = methods.formatVideoTime(ct);

            $this.find('.playhead .time-bubble .inner').html(timeStr);

        }

        

        //console.log("Slider Pixel: "+sliderPixel);
        
       // data.target.find('.controls .duration').val(methods.formatVideoTime(ct)+" | "+methods.formatVideoTime(duration));
        
        //data.target.find(".time-bar").css({"width":percentPlayed+"%"});
        
        
        
        if(ct>=duration) { 
        
          console.log("Handle Timer Firing End Event");
          
          return methods.handleVideoEnd(context);
          
        }
        

    },
    handleBuffer:function(context) {

      var $data = $.data(context);

      var $this = $data.target;

      var video = $this.find('video');

      var ve = video.get(0);

      var duration = ve.duration;

      var buffer_bar = $this.find('.slider .buffer');

      try {
          
        var buffer_end = ve.buffered.end(0);
        
      } catch(e) {
        
        console.log("Handle Buffer: get buffer error");
        console.log(e);
        
      }

      var percentBuffered = Math.ceil((buffer_end * 100) / duration);

      buffer_bar.css({

        'width':percentBuffered+"%"

      });

      if(percentBuffered >= 100) {

        buffer_bar.css({"width":"100%"})

        //clear the buffer interval

        clearInterval($data.bufferInterval);
        $data.bufferInterval = false;
        console.log("Clear Video Buffer Interval");

        console.log($data.bufferInterval);

      }


    },
    playVideo:function(context) {

      var $data = $.data(context);

      var video = $data.target.find('video');

      var src = false;

      console.log("Play Video Request Data");
      
      console.log($data.request[0]);

      switch($data.videoFormat) {

        case "ogv":
          src = methods.LIMELIGHT_URL+$data.request[0]['MediaFile']['limelight_file_ogv'];
          break;
        default:
          src = methods.LIMELIGHT_URL+$data.request[0]['MediaFile']['limelight_file'];
          break;

      }

      video.attr({
          "src":src
      });

      video.load();

      //video.get(0).play();

    },
    loadGoogleAd:function(context) { 

        var $data = $.data(context);
      
        var adsLoader = new google.ima.AdsLoader();

        adsLoader.addEventListener(
          google.ima.AdsLoadedEvent.Type.ADS_LOADED,
          function(e) {
            
            $data.GoogleAdsManager = e.getAdsManager();
            
            console.log("Google Adsmanager Start");
            
            //handle the end of the ad
            $data.GoogleAdsManager.addEventListener(
                 google.ima.AdEvent.Type.COMPLETE,
                function(ee) {
                  
                  console.log("Ad Completed Playing");
              
                },
                false
            );
            
            //configure the click element
            $data.GoogleAdsManager.setClickTrackingElement($data.target.find(".click-element").show().get(0));
            
            //play the ad
            $data.GoogleAdsManager.play($data.target.find("video").get(0));
    
          },
          false);

        adsLoader.addEventListener(
            google.ima.AdErrorEvent.Type.AD_ERROR,
            function(e) { 
              
              console.log("Google Video Ad Error: ");
              console.log(e.getError());
              
              
              return methods.handleVideoEnd(context);
              
              
            },
            false);


        var adUrl = $data.request[0]['AdUrl'];

        console.log(adUrl);
         adsLoader.requestAds({
            adTagUrl: adUrl,
            adType: "video"
          });
         
         console.log(adsLoader);

    },
    handleVideoPlay:function(context) {

      var $data = $.data(context);

      var req = $data.request;

      var video = false;

      if(req[0]) video = req[0];

      if(!video) {

        console.log("No Request Data Found In Handle Video Play");
        return;

      }

      methods.initHtmlEvents(context);

      if(video['AdUrl']) {

        console.log("Video Ad Should Be Loaded");

        methods.loadGoogleAd(context);

      } else {

        methods.playVideo(context);

      }

    },
    handleVideoEnd:function(context) {

      var $data = $.data(context);

      var video = $data.target.find("video");

      $data.target.find('.loader').show();

      if($data.GoogleAdsManager) {

        $data.GoogleAdsManager.unload();
        $data.GoogleAdsManager = false;
        $data.target.find(".click-element").hide();
        $data.target.find('video').html('').attr("src","");

      }

      if($data.request.length >0) {

        $data.request.shift();

        console.log("Shifted Request Data");

        console.log($data.request);

        methods.handleVideoPlay(context);

      } else {

        console.log("Show related video screens");

      }

    },
    formatVideoTime:function(seconds) {
      
        var min = Math.floor(seconds / 60);
        var sec = Math.floor(seconds - (min * 60));
        
        if(sec<10) sec = "0" + sec;
        
        return min+":"+sec;
        
    }

  };

  $.fn.videoDiv = function( method ) {
    
    // Method calling logic
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on jQuery.tooltip' );
    }    
  
  };

})( jQuery );
