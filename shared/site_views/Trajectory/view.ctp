<script>

$(document).ready(function() { 


	$('.brand-thumb').hover(
		function() { 

			$(this).css({
				"opacity":.8
			});

		},
		function() { 
			$(this).css({
				"opacity":1
			});
		}
	);

	
});

</script>
<div id='trajectory'>
	<?php 
	
		//print_r($episodes);
	
	?>
	<div class='posts'>
		<?php 
		
			echo $this->element("dailyops/post-bit",array("dop"=>$viewing));
		
		?>
	</div>
	<div>
		<img src='/img/layout/trajectory/eps_header.png' />
	</div>
	<div class='related-posts'>
		<?php 
			
			foreach($episodes as $ep):
				if($ep['Dailyop']['id'] != $viewing['Dailyop']['id']):
		?>
			<?php 
			
				echo $this->element("dailyops/post-thumb-large",array("dop"=>$ep));
			
			?>
		<?php 
		
				endif;
			endforeach;	
		
		?>
	</div>
	<div style='clear:both;'></div>
	<div>
		<img src='/img/layout/trajectory/companies_header.png' />
	</div>
	<div class='brand-menu'>
		<?php 
		
			foreach($posts as $post):
		
		?>
			<div style='float:left; padding:3px;' class='brand-thumb'>
				<a href='/trajectory/<?php echo $post['Dailyop']['uri']; ?>'>
					<img src='http://img01.theberrics.com/images/<?php echo $post['DailyopMediaItem'][1]['MediaFile']['file']; ?>' border='0' />
				</a>
			</div>
		<?php 
		
			endforeach;
		
		?>
		<div style='clear:both;'></div>
	</div>
</div>