<?php 

echo $this->Html->css(array("landing"),"stylesheet");

 ?>
 <script>
jQuery(document).ready(function($) {
	
	var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1300px, initial-scale=0"

		});

		$('div[data-href]').click(function() { 

			var url = $(this).attr("data-href");
	
			window.open(url);
			
			return true;

		});

});
 </script>
<div id="evan-smith-experience">
	<div class="evan-smith">
		
	</div>
	<div class='creative-life' data-href='http://www.creativelifesupport.com/'>
		
	</div>
	<div class="dc-shoe" data-href='http://www.dcshoes.com/product/index.jsp?productId=13233676'>
		
	</div>
	<div class="dc-shoe-info" data-href='http://www.dcshoes.com/product/index.jsp?productId=13233676'>
		
	</div>
	<div class="element" data-href='http://elementskateboards.com'></div>
	<div class="photos"></div>
	<div class="interview" data-href=''></div>
	<div class="enter" data-href='http://theberrics.com/2013/03/20'></div>
</div>