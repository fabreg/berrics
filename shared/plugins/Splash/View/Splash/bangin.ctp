<script>
var tiles = <?php echo json_encode($tiles); ?>;
jQuery(document).ready(function($) {
	
	lazyLoad();

	$('.tile').each(function(i) {
	
		setTimeout(function() { 
			


			cycleTile($('.tile:eq('+i+')'));

		},randTime());

	});

});

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
}
function cycleTile($tile) {
	
	if(!isScrolledIntoView($tile)) {
	
		setTimeout(function() { 

			cycleTile($tile);

		},randTime());
		
		console.log('skipped');

		return;

	}

	var tile = randomTile();

	var oldTile = $tile.find('.tile-inner:eq(0)');

	if(tile.length<=0) return;

	if(oldTile.length<=0) {

		$tile.append(tile);
		return;

	}

	var z = $tile.find('.tile-inner').css('z-index')+1;
	
	var html = $(tile).css({
			//'z-index':z,
			'display':'none'
	});	

	html.find('img').attr({'src':html.find('img').attr('data-original')});

	
	console.log(html);

	$tile.append(html);
	
	oldTile.fadeOut(function() { 
	
		oldTile.remove();

	});

	html.fadeIn('slow',function() { 

		lazyLoad();

		
		setTimeout(function() { 

			cycleTile($tile);

		},randTime());
		
	});
}

function randTime () {
	
	var n = Math.floor(Math.random()*16);
		
	if(n<5) return randTime();

	return n*1000;
	

}

function randomTile () {
		
	var n = Math.floor(Math.random()*(tiles.length+1));

	return tiles[n];

}

</script>
<style>

body {

	padding:0;
	height:100%;
	background-color: #000;
	background-image:none;
}

.container-fluid {

	padding:0;

}

#bangin {

	width:100%;
	height:100%;
	overflow: hidden;
	position:relative;
}	

#bangin .tile {

	float:left;
	opacity: .6;
	position:relative;
	width:275px;
	height:157px;
}

#bangin .tile:hover {

	opacity: 1;

}

#bangin .tile-inner {

	position: absolute;
	

}

#bangin .inner {

	width:120%;
	height:120%;
	margin-top:-1%;
}

.enter {

	position: absolute;
	bottom:0px;
	width:100%;
	height:50px;
	background-color: #f5f302;
	text-align: center;

}

/* Large desktop */
@media (min-width: 1200px) { 



 }
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) {  }
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) { 

	#bangin .inner {

		width:150%;

	}

 }
 
/* Landscape phones and down */
@media (max-width: 480px) { 


	#bangin .inner {

		width:150%;

	}

 }

</style>
<div id='bangin' class="clearfix">
	<div class="inner">
		<?php 

			foreach ($tiles as $k => $v): 
			if($k>75) continiue;
		?>
		<div class="tile">
			<?php echo $v; ?>	
		</div>
	<?php endforeach ?>
	</div>
	<div class="enter">
		<div class="inner">
			<a href='/dailyops'>ENTER THE BERRICS</a>
		</div>
	</div>
</div>