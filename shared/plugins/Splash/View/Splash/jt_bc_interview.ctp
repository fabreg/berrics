<?php 

$this->set("title_for_layout","The Berrics - BATTLE COMMANDER INTERROGATION");

?>
<style>
body {

  background-color:#000;
  background-image:none;

}


#myCarousel {

  max-width:1500px;
  margin:auto;

}

.shim {

  height:300px;

}

.enter {

  text-align: center;
  margin-top:35px;
}

.enter a {

  color:#fff;
  font-size:32px;
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
</style>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    
    $('#myCarousel').on('slid', function() {
        
        var img = $(".active img",this);

       img.attr({

          "src":img.attr("data-lazy-src")

       });
        
    });

  });
</script>
<div class="title">
  <h1>
    BATTLE COMMANDER INTERROGATION - JAMIE THOMAS
  </h1>
</div>
<div id="myCarousel" class="carousel slide">
  <!-- Carousel items -->
  <div class="carousel-inner">
    <div class="item active"><img src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-1.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-2.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-3.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-4.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-5.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-6.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-7.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-8.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-9.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-10.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-11.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-12.jpg" alt=""></div>
    <div class="item"><img src='/img/v3/jt-interview/blank.jpg' data-lazy-src="/img/v3/jt-interview/JT-INTERROGATION-FINAL-13.jpg" alt=""></div>
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