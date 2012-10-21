<script>
var _date_in = '<?php echo $this->params['date_in']; ?>';
$(document).ready(function() { 

	
	//$("#unified-side-menu").html("Should go in here");


	$("#send-news").click(function() { 
	
		document.location.href = "mailto:news@theberrics.com";
		
	});

	$("#unified-side-menu").find(".paging a").click(function() { 

		loadUnifiedMenu($(this).attr("href"));
		
		return false;
		
	});

	$("#events-side-menu").find(".paging a").click(function() { 

		loadEventMenu($(this).attr("href"));
		
		return false;
		
	});

	$("#news-side-menu").find(".paging a").click(function() { 

		loadNewsMenu($(this).attr("href"));
		
		return false;
		
	});

	
});

function loadUnifiedMenu(href) {

	$("#unified-side-menu").load(href+"?date_in="+_date_in,{},function() { 

		$("#unified-side-menu").find(".paging a").click(function() { 

			loadUnifiedMenu($(this).attr("href"));
			
			return false;
			
		});

	});
	
}


function loadEventMenu(href) {

	$("#events-side-menu").load(href+"?date_in="+_date_in,{},function() { 

		$("#events-side-menu").find(".paging a").click(function() { 

			loadEventMenu($(this).attr("href"));
			
			return false;
			
		});

	});
	
}

function loadNewsMenu(href) {

	$("#news-side-menu").load(href+"?date_in="+_date_in,{},function() { 

		$("#news-side-menu").find(".paging a").click(function() { 

			loadNewsMenu($(this).attr("href"));
			
			return false;
			
		});

	});
	
}


</script>
<div id='happy_news'>
<?php echo $this->element("news/header"); ?>
<div style='clear:both;'></div>
	<div id='left-col'>
		<?php echo $content_for_layout; ?>
	</div>
	<div id='right-col'>
		<div class='inner'>
			<?php 
				if($this->params['action'] == "view"):
			?>
			<img src='/img/layout/news/top-news.jpg' />
			<div id='news-side-menu'>
				<?php if(isset($latest_posts)) echo $this->element("news/latest_menu"); ?>
			</div>
			<?php 
				endif;
			?>
			<img src='/img/layout/news/unified-header.jpg' />
			<div id='unified-side-menu'>
				<?php if(isset($unified_posts)) echo $this->element("news/unified_menu_element"); ?>
			</div>
			<img src='/img/layout/news/upcoming-header.jpg' />
			<div id='events-side-menu'>
				<?php if(isset($event_posts)) echo $this->element("news/events_menu"); ?>
			</div>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>