<?php 

$a = $article['Article'];
$p = $article['ArticleParagraph'];
$u = $article['User'];

$this->Html->script(array("articles/view","jquery.mb.mediaEmbedder"),array("inline"=>false));
$this->Html->css(array("articles/view"),"stylesheet",array("inline"=>false));
?>

<style>

</style>
<div id='article-view'>
	
	<div style='float:left; width:624px;'>
		<h1><?php echo $a['title']; ?></h1>
	<div>
	POSTED <?php echo date("h:i",strtotime($a['publish_date'])); ?> BY: <?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?> ON <?php echo date("m.d.Y",strtotime($a['publish_date'])); ?>
	</div>
	<?php 
	
		if(isset($article['Gallery'])) {
			
			$g = $article['Gallery'];
			
			//get the image position that we are on
			$img_pos = 0;
			if(isset($_GET['image'])) {
				
				$img_pos = ($_GET['image']);
				
			}
			
			//check to see that we are in range
			if(($img_post+1)>count($g)) {
				
				$img_post = 0;
				
			}
			
			//pick the image out
			$img = $g[$img_pos];
					
			//output the gallery widget
			echo $this->element("articles/gallery",array("img"=>$img,"gallery"=>$g));
			
		}
	
	?>
		<?php 
	
		foreach($p as $v) {
			
			echo $this->element("articles/paragraph",array("p"=>$v));
			
		}
	
		?>
	</div>
	<div style='float:right; width:300px;'></div>
	<div style='clear:both;'></div>
	
</div>

<?php 

pr($article);

?>