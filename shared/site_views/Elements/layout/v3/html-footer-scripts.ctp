<?php 



		echo $this->Html->script(array(
			
		));
?>
<script>
	FB.XFBML.parse();
	/*

	
	*/
	jQuery(document).ready(function($) {
		$('img.lazy').lazyload({

			load:function(e) {

				var img = $('img').eq(e);

				$(img.get(0)).attr({

					"width":"",
					"height":""

				});

			}

		});
	});
	
</script>