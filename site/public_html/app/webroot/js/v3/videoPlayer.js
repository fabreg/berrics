(function( $ ){



  var methods = {
    init:function(opt) {

      var $this = $(this);

      if($this.is('[data-init]')) return;

      var options = {
        target:$this,
        beforeDataLoad:function() {},
        afterLoadData:function() {},
        videoEnd:function() {},
        requestData:{},
        playCount:0
      };

      if(opt) $.extend(options,opt);

      $this.data('videoPlayer',options);

      var $data = $this.data('videoPlayer');

      $data.testing = "testing:"+$this.index();

      switch($this.attr("data-platform")) {

        case 'android':
          methods.initAndroidVideo($this);
        break;
        case 'ios':
          methods.initAppleVideo($this);
        break;
        default:
          methods.initSwfVideo($this);
        break;

      }

      $this.attr("data-init",1);

    },
    initAppleVideo:function($context) {

      var $data = $context.data('videoPlayer');

      $data.target.bind('click',function() {

         if($(this).parent().parent().hasClass('featured-post')) {

          $(this).parent().parent().find('.post-top').show();

          $(this).parent().parent().find('.post-footer').show();

        }


        methods.playAppleVideo($context);

        $(this).unbind('click');

      });

    },
    playAppleVideo:function($context) { 

      if(!arguments[0]) $context = $(this);

      var $data = $context.data('videoPlayer');

      $data.target.find('.play-button').css({

        'background-image':"url(/img/v3/layout/loader-big.gif)"

      });

      methods.loadData($context,{

          success:function($ele) {

            $data.playCount = 0;

            var videoTag = $("<video />").attr({

              "controls":true

            }).bind('ended',function() { 

              methods.handleAppleVideoEnd($context);

            });

            $data.target.html(videoTag);

            var frag = $data.requestData[$data.playCount];

            if(frag.prerollUrl) {

              methods.loadGoogleAd($context,frag.prerollUrl);

            } else if(frag.Video) {

              videoTag.attr({

                "src":frag.Video.MediaFile.file_url,
                "autoplay":true

              });

              var vid = $data.target.find('video').get(0);

              vid.load();

              vid.play();

            }

          }

        });

    },
    handleAppleVideoEnd:function($context) {

      var $data = $context.data('videoPlayer');

      $data.playCount++;

      var frag = $data.requestData[$data.playCount];

      var video = $data.target.find('video');

      var vid = video.get(0);

      video.unbind().bind('ended',function() { 

        methods.handleAppleVideoEnd($context);

      });
      if(!frag) {

        handleVideoEnd($data.target.attr("data-media-file-id"),$data.target.attr("data-dailyop-id"));

      } else if(frag.postrollUrl) {

        methods.loadGoogleAd($context,frag.postrollUrl);

      } else if(frag.Video) {

        video.attr({

          "src":frag.Video.MediaFile.file_url

        });

        vid.load();

        vid.play();

      } 

    },
    initAndroidVideo:function($context) {

      var $data = $context.data('videoPlayer');

      var ele = $data.target;

      var videoTag = $("<video />").attr({

        "poster":ele.attr("data-poster-file"),
        'controls':true,
        

      });

      ele.html(videoTag);

      ele.prepend($("<div />").addClass("android-play-button"));

      methods.initAndroidVideoEvents($context);

      methods.loadData($context,{

        success:function($ele) {

          var frag = $data.requestData[$data.playCount];

          if(frag.prerollUrl) {

            methods.loadGoogleAd($context,frag.prerollUrl);

          } else if(frag.postrollUrl) {

            methods.loadGoogleAd($context,frag.postrollUrl);

          } else if(frag.Video) {

            videoTag.attr({

              "src":frag.Video.MediaFile.file_url

            });

          }

        }

      });

    },
    initAndroidVideoEvents:function($context) { 

      var $data = $context.data('videoPlayer');
      $data.target.find('.android-play-button').unbind().show().bind('click',function() { 
            
            $data.target.find('video').get(0).play();
      });
      $data.target.find('video').unbind()
      .bind('play',function() {
          //show overlay
          $data.target.find('.android-play-button').hide();
      }).bind('pause',function() {
          //hide overlay
          
          $data.target.find('.android-play-button').show();

      }).bind('ended',function() { 
          methods.handleAndroidVideoEnd($context);
      });

    },
    handleAndroidVideoEnd:function($context) {

      var $data = $context.data('videoPlayer');

      $data.playCount++;

      var frag = $data.requestData[$data.playCount];

      var video = $data.target.find('video');

      var vid = video.get(0);

      video.unbind('ended').bind('ended',function() { 

        methods.handleAndroidVideoEnd($context);

      });

      if(!frag) {

       

      } else if(frag.postrollUrl) {

        methods.loadGoogleAd($context,frag.postrollUrl);

      } else if(frag.Video) {

        $data.target.find('video').attr({

          "src":frag.Video.MediaFile.file_url

        });

        vid.load();

        vid.play();

      } 

    },
    initSwfVideo:function($context) {

      var $data = $context.data('videoPlayer');

      $data.target.bind('click',function() { 

        if($(this).parent().parent().hasClass('featured-post')) {

          $(this).parent().parent().find('.post-top').show();

          $(this).parent().parent().find('.post-footer').show();

        }

        methods.playSwfVideo($context);

        $(this).unbind('click');

      });

      $data.target.hover(
          function(e) { 
            $(this).find('.video-hover').fadeIn().parent().find('.play-button').animate({opacity:1});
          },
          function(e) { 
            $(this).find('.video-hover').fadeOut().parent().find('.play-button').animate({opacity:.6});
          });


    },
    playSwfVideo:function($context) {

      if(!arguments[0]) $context = $(this);

      var $data = $context.data('videoPlayer');

      $data.target.find('.play-button').css({

        'background-image':"url(/img/v3/layout/loader-big.gif)"

      });

      var flashVars = {

        'media_file_id':$data.target.attr("data-media-file-id"),
        "domain":window.location.hostname

      };

      if($data.target.attr('data-dailyop-id')) flashVars.dailyop_id = $data.target.attr('data-dailyop-id');
      if($data.target.attr('data-dailyop-display-weight')) flashVars.start_pos = $data.target.attr('data-dailyop-display-weight');
      if($data.target.attr('data-ondemand-title-id')) flashVars.ondemand_title_id = $data.target.attr('data-ondemand-title-id');

      var swfDiv = $("<div />").attr("id","swf-"+$data.target.attr("id"));

      $data.target.html(swfDiv);
      
      swfobject.embedSWF(
                "/swf/v3/VideoPlayerV3.swf?t=a",
                swfDiv.attr("id"),
                "100%",
                "394",
                "10",
                "/js/v3/expressInstall.swf",
                flashVars,
                {
                  "allowScriptAccess":'sameDomain',
                  "allowFullScreen":true,
                  "wmode":"direct",
                  "quality":"autohigh"
                }
                );

      /*
      methods.loadData($context,{

        success:function() { 

              $data.playCount = 0;

              var flashVars = {};

              for(var a in $data.requestData) {

                if($data.requestData[a].prerollUrl) flashVars.prerollUrl = encodeURIComponent($data.requestData[a].prerollUrl);

                if($data.requestData[a].postrollUrl) flashVars.postrollUrl = encodeURIComponent($data.requestData[a].postrollUrl);

                if($data.requestData[a].Video) {

                  if($data.requestData[a].Video.MediaFile.limelight_file) flashVars.file = $data.requestData[a].Video.MediaFile.limelight_file;
                  if($data.requestData[a].Video.MediaFile.id) flashVars.media_file_id = $data.requestData[a].Video.MediaFile.id;
                  if($data.requestData[a].Video.Dailyop.id) flashVars.dailyop_id = $data.requestData[a].Video.Dailyop.id;

                }


              }

              

        }

      });
      */

    },
    loadData:function($context) {

      var $data = $context.data('videoPlayer');

      var ele = $data.target;

      var $success = function($element) { 

        var $d = $element.data('videoPlayer');

        console.log($d);

      };

      if(arguments[1]) {

        if(arguments[1].success) $success = arguments[1].success;

      }

      var media_file_id = ele.attr("data-media-file-id");

      var dailyop_id = ele.attr("data-dailyop-id") || false;

      var uri = "/media_service/video_player_requestv2/media_file_id:"+media_file_id;

      if(dailyop_id) uri += "/dailyop_id:"+dailyop_id;

      var $o = {

        url:uri,
        dataType:'json',
        success:function(d) {

          $data.requestData = d;
          
          $success.call(this,ele);

        }

      };

      $.ajax($o);

    },
    loadGoogleAd:function($context,url) { 

        var $data = $context.data('videoPlayer');
      
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
            $data.GoogleAdsManager.setClickTrackingElement($("<div />"));
            
            //play the ad
            $data.GoogleAdsManager.play($data.target.find("video").get(0));

          },
          false);

        adsLoader.addEventListener(
            google.ima.AdErrorEvent.Type.AD_ERROR,
            function(e) { 
              
              console.log("Google Video Ad Error: ");
              console.log(e.getError());

              switch($data.target.attr("data-platform")) {

                case "android":
                  methods.handleAndroidVideoEnd($context);
                break;
                case "ios":
                  methods.handleAppleVideoEnd($context);
                break;  

              }

 
            },
            false);


        var adUrl = url;

         adsLoader.requestAds({
            adTagUrl: adUrl,
            adType: "video"
          });

    }

  };

  $.fn.videoPlayer = function( method ) {
    
    // Method calling logic
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Method ' +  method + ' does not exist on Berrics Video Player' );
    }    
  
  };

})( jQuery );
