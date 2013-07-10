<script type='text/javascript'>
$(document).ready(function() { 

	if(document.location.hash) {

		setImage(Number(document.location.hash.replace(/#/,'')));

	} else {


		setImage(1);
		
	}
	
	
	
	initHovers();

	initThumbs();
	
});

function initThumbs() {

	$('.page-thumb').click(function() { 

		setImage(Number($(this).attr("display_weight")));

	});
	
}

function setImage(display_weight) {


	//unbind clicks
	$('.right-arrow,.left-arrow').unbind('click').removeClass('disabled');
	
	var file = $('.page-thumb[display_weight='+display_weight+']').attr('file');

	$("#tile-view").css({
		"background-image":"url(http://img01.theberrics.com/images/"+file+")"
	});

	var next = $('.page-thumb[display_weight='+Number(display_weight+1)+"]").attr("file") || '';
	var prev = $('.page-thumb[display_weight='+Number(display_weight-1)+"]").attr("file") || '';
	
	//check for next image
	if(next.length>0) {

		$('.right-arrow').click(function() { 

			setImage(Number(display_weight+1));
			
		});
		
	} else {

		$('.right-arrow').addClass('disabled');
		
	}
	
	//check for previous image
	if(prev.length>1) {

		$('.left-arrow').click(function() { 

			setImage(Number(display_weight-1));

		});
		

	} else {

		$('.left-arrow').addClass('disabled');	

	}

	document.location.hash = display_weight;

	//$(document).scrollTop(110);

}

function initHovers() {

	$('.right-arrow').hover(

		function() { 

			if($(this).hasClass('disabled')) {

			} else {

				$(this).addClass('right-arrow-over');

			}
			
			
			
		},
		function() { 

			if($(this).hasClass('disabled')) {

			} else {


				$(this).removeClass('right-arrow-over');
		
				
			}
			
		}
			
	);

	$('.left-arrow').hover(

			function() { 

				if($(this).hasClass('disabled')) {

				} else {

					$(this).addClass('left-arrow-over');

				}
				
				
				
			},
			function() { 

				if($(this).hasClass('disabled')) {

				} else {


					$(this).removeClass('left-arrow-over');
			
					
				}
				
			}
				
		);
	
}
</script>
<div id='catalog-wrapper'>
<div id='catalog'>
	<div id='catalog-heading'>
		<img src='/theme/catalog/img/catalog-heading.jpg' border='0'/>
		<br />
		Contact <a href="mailto:apparel@theberrics.com">apparel@theberrics.com</a> for more info
	</div>
	<div id='tile-view-wrapper'>
		
		<div id='tile-view'>
			<div class='right-arrow'></div>
			<div class='left-arrow'></div>
		</div>
	</div>
	<div id='thumb-strip'>
		
	</div>
	<div id='thumb-grid'>
		<?php 
			foreach($post['DailyopMediaItem'] as $item):
		?>
		<div class='page-thumb' display_weight='<?php echo $item['display_weight']; ?>' file='<?php echo $item['MediaFile']['file']; ?>'>
			<?php echo $this->Media->mediaThumb(array(
			
				"MediaFile"=>$item['MediaFile'],
				"w"=>125
			
			));?>
		</div>
		<?php 
		
			endforeach;
		
		?>
		<div style='clear:both;'></div>
	</div>
</div>

</div>
