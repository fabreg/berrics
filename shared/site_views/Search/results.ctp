<?php 
$pag_nav = "<ul>";
//$pag_nav .= "<li>".$this->Paginator->prev("&laquo;",array("tag"=>false),null,array("tag"=>"a"))."</li>";
$pag_nav .=  $this->Paginator->numbers(array(
						"before"=>null,
						"after"=>null,
						"separator"=>null,
						"tag"=>"li",
						"currentClass"=>"active"
					));
//$pag_nav = preg_replace("(view)", $this->request->params['slug'], $pag_nav);
$pag_nav .= "</ul>";

 ?>
 <script type="text/javascript">
jQuery(document).ready(function($) {
	$('li.active').each(function() { 
		var str = $(this).html();
		$(this).html($("<a />").append(str));
	});
});

</script>
<div>
		<div class="row-fluid">
		<div class="span12">
			<?php echo $this->element("banners/728") ?>
		</div>
	</div>
	<h1>
		<?php echo strtoupper(base64_decode($this->request->pass[0])); ?> 
		<small><?php echo $this->request->params['paging']['Dailyop']['count']; ?> RESULTS</small>
	</h1>
</div>
<div id="search-results">

	<div class="row-fluid">
		<div class="span12">
			<div class="pagination pull-right">
				<?php 
					
					echo $pag_nav; 
				?>
			</div>
		</div>
	</div>
	<div class="thumb-collection">
		<?php foreach ($posts as $k => $v): ?>
		<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
	<?php endforeach ?>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<div class="pagination pull-right">
				<?php 
					
					echo $pag_nav; 
				?>
			</div>
		</div>
	</div>
</div>
<?php 

pr($this->request->params);

 ?>