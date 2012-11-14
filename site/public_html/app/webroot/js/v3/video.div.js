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
                      <div class='playhead'></div>\
                    </div>\
                  </div>\
                  <div class='volume'>\
                    <div class='inner'>\
                      <div class='vol-0'></div>\
                      <div class='vol-20'></div>\
                      <div class='vol-40'></div>\
                      <div class='vol-60'></div>\
                      <div class='vol-80'></div>\
                      <div class='vol-100'></div>\
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

      var data = $.data($this,{

            "target":$this,
            "parent":$that.parent(),
            "request":false,
            "bufferInterval":false,
            "controlsTimeout":false,
            "playingAd":false,
            "GoogleAdsManager":false

          });

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
            methods.initHtml($this);
            

          } else {
            
            console.log("USE FLASH");
            methods.initFlash($this);
            
          }

        }


      });

    },
    initHtml:function(context) {

      var $data = $.data(context);

      var $this = $data.target;

      $this.html($("<div class='video-div' />").append($("<div class='click-element' /><div class='pause-overlay'/><video autoplay='true' />")));
        
      var video_div = $this.find(".video-div");

      video_div.append(methods.CONTROLS());

      //build the controls
      var video = $this.find("video");

      video.attr({

        "controls":false,
        "autoplay":true

      });

      methods.initHtmlEvents(context);

      methods.handleVideoPlay(context);

      console.log($data.parent);

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

      var slider = controls.find('.slider');

      var pause_overlay = $this.find(".pause-overlay");
      

      video.unbind().
      bind('loadstart',function(e) { }).
      bind('timeupdate',function(e) { 
          methods.handleTimer($this);
      }).
      bind('pause',function(e) {

          play_btn.addClass('paused').removeClass('playing');
        
          pause_overlay.show();

      }).
      bind('play',function(e) { 

        play_btn.addClass('playing').removeClass('paused');

         pause_overlay.hide();

        if(!$data.bufferInterval) {

          $data.bufferInterval = setInterval(
            function() { methods.handleBuffer(context) },500
          );

        }


      });

      pause_overlay.click(function() { 

        video_ele.play();

      });

      //bind the play button
      play_btn.click(function() { 

          if(play_btn.hasClass('paused')) {

            video_ele.play();

            if(slowmo_btn.hasClass("active")) {

              video_ele.playbackRate = 1;
              slowmo_btn.removeClass("active");

            }

          } else {

            video_ele.pause();

          }

      });

      //bind the slow motion button

     slowmo_btn.click(function() { 

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

      //  var sliderPixel = Math.ceil((percentPlayed * (data.target.find('.tracking').width()/100)));

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

      video.attr({
          "src":methods.LIMELIGHT_URL+$data.request[0]['MediaFile']['limelight_file']
      });

      video.get(0).play();


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


        var adUrl = $data.request[0]['Preroll'] || $data.request[0]['Postroll'];

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

      if(video['Preroll'] || video['Postroll']) {

        console.log("Video Ad Should Be Loaded");

        methods.loadGoogleAd(context);

      } else {

        methods.playVideo(context);

      }

    },
    handleVideoEnd:function(context) {

      var $data = $.data(context);

      if($data.GoogleAdsManager) {

        $data.GoogleAdsManager.unload();
        $data.GoogleAdsManager = false;

      }
      console.log("Request data");
      console.log($data.request);

      if($data.request.length >0) {

        $data.request.shift();

        console.log("Shifted Request Data");

        console.log($data.request);

        methods.handleVideoPlay(context);

      } else {

        console.log("Show related video screens");

      }

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
