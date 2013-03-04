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