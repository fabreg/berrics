(function( $ ){

  var methods = {
    LIMELIGHT_URL: "http://berrics.vo.llnwd.net/o45/",
    init : function( options ) { 

      var $this = this;

      var $that = $($this);

      //get the video data
      $.ajax({

        "type":"post",
        "dataType":"json",
        "data":{

          "data":{
            "json":JSON.stringify({
                    "media_file_id":$that.attr("data-media-file-id")
                  })
          }

        },
        "url":"/media/json_video_service",
        "success":function(d) { 

                var data = $.data($this,{

                  "target":$this,
                  "parent":$that.parent(),
                  "request":d

                });

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

      $this.html($("<div class='video-div' />").append($("<video />")));

      //build the controls


      var controls = $($("<div class='controls' />")).append(
                        $("<div class='inner' />").append(
                            $("<div class='bar' />").append($("<div class='slider' />"))
                          )
                      );

      var video = $this.find("video");

      video.attr({

        "src":methods.LIMELIGHT_URL+$data.request.MediaFile.limelight_file,
        "controls":true,
        "autoplay":true


      });

      console.log($data.parent);

    },
    initFlash:function(context) {
      
    },
    bindHtmlControls:function(context) {

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
