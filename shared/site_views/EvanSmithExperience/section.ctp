<?php 

echo $this->Html->css(array("landing","/shadowbox/shadowbox.css"),"stylesheet");

$this->set("title_for_layout","The Berrics - The Evan Smith Experience");

 ?>
 <script src='/shadowbox/shadowbox.js'></script>
 <script>
jQuery(document).ready(function($) {
	
	var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1400px, initial-scale=0"

		});

		$('div[data-href]').click(function() { 

			var url = $(this).attr("data-href");
	
			window.open(url);
			
			return true;

		});
		Shadowbox.init();
});
 </script>
<div id="evan-smith-experience">
	<div class="evan-smith">
		<div id="post">
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
		</div>
	</div>
	<div class='creative-life' data-href='http://www.creativelifesupport.com/'>
		
	</div>
	<div class="dc-shoe" data-href='http://www.dcshoes.com/product/index.jsp?productId=13233676'>
		
	</div>
	<div class="dc-shoe-info" data-href='http://www.dcshoes.com/product/index.jsp?productId=13233676'>
		
	</div>
	<div class="element" data-href='http://elementskateboards.com'></div>
	<div class="photos">
			
		<div class="thumbs">
			<?php 
				for($i=1;$i<=22;$i++):
			 ?>
				<div class="thumb">
					<a href='/theme/evan-smith-experience/img/full/<?php echo $i; ?>.jpg' rel='shadowbox[Evan]'><img src="/theme/evan-smith-experience/img/t<?php echo $i; ?>.jpg" alt=""></a>
				</div>
			<?php
			endfor;
			?>
		</div>

	</div>
	<div class="interview" data-href='/interrogation/evan-smith.html'>
		
	</div>
	<div class="enter" data-href='http://theberrics.com/2013/03/20'></div>
</div>