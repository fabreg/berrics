<?php 

$this->Html->script(array("berrics.htmlvideo"),array("inline"=>false));

?>
<script>
$(document).ready(function() { 

	$("#test-click").click(function() { 

		var vid = '<source src="http://berrics.vo.llnwd.net/o45/<?php echo $video['limelight_file']; ?>" type="video/mp4" />';

		$('video').html(vid);
		
	});

	$('#test-plugin').click(function() { 

		$('.video-test').BerricsHtmlVideo({"LazyLoad":false});

	});

	
});
</script>
<?php 
	$video = $post['DailyopMediaItem'][0]['MediaFile'];
?>
<div class='video-test' id="randomid">

</div>
<input type='button' value='test' id='test-plugin'/>
<div class='berrics-html5'>
	<video width='700' height='396' controls style='background-color:#000;'>
		
	</video>
</div>
<input type='button' value='test' id='test-click'/>
<pre>
<?php print_r($video); ?>
</pre>