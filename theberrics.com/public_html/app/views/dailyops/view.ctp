<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

$m = $entry['DailyopMediaItem'][0]['MediaFile'];



?>
<script>

var agent = navigator.userAgent;

if( /PLAYSTATION/.test(navigator.userAgent)) {

	
	
}

function postRoll() {


	
}
$(document).ready(function() { 

	
	
});

function loadVideo(mediaFile) {

	
	
	
}





</script>
<style>
#thumbs .left {

	float:left;	
	margin-bottom:8px;
}
#thumbs .right {

	float:right;
	margin-bottom:8px;
}
</style>
<div>
	<?php 
	
		echo $this->element("dailyops/post-bit",array("dop"=>$entry));
	
	?>
</div>

<?php 

echo $this->element("banner-placements/dops-post-bottom");

?>

<div id='section-view'>
	<div class='title'>
	<?php 
			
				echo $this->Berrics->monthYearHeader($entry["Dailyop"]["publish_date"]);
				
			?>
	</div>
</div>
<div id='thumbs'>
		
	<?php 
			foreach($posts as $k=>$post):
			
			if($k%2) {
				
				$cls = 'right';
				
			} else {
				
				$cls = 'left';
				
			}
			
		?>
			<div class='<?php echo $cls; ?>'>
			<?php 
			
				echo $this->element("dailyops/post-thumb-large",array("dop"=>$post));
			
			?>
			</div>
		<?php 
			endforeach;
		?>
		<div style='clear:both;'></div>
	</div>
<?php 


pr($posts);


?>
