<?php 
echo $this->element("layout/v3/html-head-scripts");
$this->set("title_for_layout","The Berrics - BATTLE COMMANDER INTERROGATION");
$this->layout = "blank";

?>
<style>
body {

  background-color:#000;
  background-image:none;

}


#myCarousel {

  position:absolute;
  margin:auto;
  top:0px;
  left:0px;
  right:0px;
  bottom:40px;
}

.carousel .carousel-inner .item {

  text-align: center;

}

#myCarousel .item img {

  height:100%;
  margin:auto;
  width:auto;
}

.shim {

  height:300px;

}

.enter {
  position:absolute;
  text-align: center;
  height:40px;
  width:100%;
  bottom:0px;
  background-color:#333;
  line-height:47px;
}

.enter a {

  color:#fff;
  font-size:30px;
  
}
.title {


}

.title h1 {

  color:#fff;
  font-size: 26px;
  font-family: 'universcnb';
  font-weight: normal;
  text-align: center;

}

.carousel .carousel-control {

  font-family: 'Arial';
  font-size:42px;
  height:60px;
  width:60px;
  line-height:45px;

}

</style>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    
   $.fn.carousel.defaults = {
    interval: false,pause: 'hover'
  }

    $('#myCarousel').on('slid', function() {
        
        var img = $(".active img",this);

       img.attr({

          "src":img.attr("data-lazy-src")

       });
        
    });

  });
</script>

<div id="myCarousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="item active"><img src="/img/v3/boo-interview/booJohnson_Interview_1.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_2.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_3.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_4.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_5.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_6.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_7.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_8.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/boo-interview/booJohnson_Interview_9.jpg" alt=""></div>
  </div>
  <!-- Carousel nav -->
  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
<div class="enter">
    <a href="/dailyops">
      - ENTER THE BERRICS - 
    </a>
</div>
<div class="shim">
  
</div>