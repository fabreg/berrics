<script type="text/javascript">
jQuery(document).ready(function($) {
	$('li.active').each(function() { 
		var str = $(this).html();
		$(this).html($("<a />").append(str));
	});
});

</script>

<?php 
$pag_nav = "<ul>";
//$pag_nav .= "<li>".$this->Paginator->prev("&laquo;",array("tag"=>false),null,array("tag"=>"a"))."</li>";
$pag_nav .=  $this->Paginator->numbers(array(
						"before"=>null,
						"after"=>null,
						"separator"=>null,
						"tag"=>"li",
						"currentClass"=>"active",
						"modulus"=>6
					));

if(preg_match('/(view\/)/',$pag_nav)) {

	$pag_nav = preg_replace("(view)", "media/".$this->request->params['uri'], $pag_nav);

} else {

	$pag_nav = preg_replace("(media\/)", "media/".$this->request->params['uri']."/", $pag_nav);

}

$pag_nav .= "</ul>";

 ?>
	<div class="row-fluid">
		<div class="span4">
			<h2>
				POSTS <small><?php echo $this->request->params['paging']['Dailyop']['count']; ?></small>
			</h2>
		</div>
		<div class="span8">
			<div class="pagination pull-right">
				<?php 
					
					echo $pag_nav; 
				?>
			</div>
		</div>
	</div>
<div class="thumb-collection">
	<?php foreach ($posts as $k => $v): ?>
		<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)) ?>
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