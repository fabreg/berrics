<?php 

$a = $article['Article'];
$m = $article['MediaFile'];

?>
<div class='main-news-bit'>
	<div class='preview-image'>
		
		<?php 
		
			$thumb = $this->Media->mediaThumb(array(
				
							"MediaFile"=>$m,
							"w"=>410,
							"h"=>270,
							"zc"=>1
						
			));
			
			echo $this->Aberrica->articleLink($a,$thumb,array("escape"=>false));
			
		?>
	</div>
	<div class='article-summary'>
		<div class='inner'>
			<h2>
				<?php echo $this->Aberrica->articleLink($a,$a['title']); ?>
			</h2>
			<div class='article-links'>
				<?php echo date("M d, Y",strtotime($a['publish_date'])); ?> 
			<!-- 	| <?php echo $this->Aberrica->articleLink($a,"PERMALINK"); ?>  -->
			</div>
		</div>
	</div>
</div>