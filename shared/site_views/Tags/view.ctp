<?php

$title_for_layout = "The Berrics - ".strtoupper($tag['Tag']['name']);

$this->set(compact("title_for_layout"));

$pag_nav = "<ul>";
//$pag_nav .= "<li>".$this->Paginator->prev("&laquo;",array("tag"=>false),null,array("tag"=>"a"))."</li>";
$pag_nav .=  $this->Paginator->numbers(array(
						"before"=>null,
						"after"=>null,
						"separator"=>null,
						"tag"=>"li",
						"currentClass"=>"active"
					));
$pag_nav = preg_replace("(view)", $this->request->params['slug'], $pag_nav);
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
<div id='tags-section'>
	<div class="row-fluid">
		<div class="span12">
			<div class='heading'>
				<h1><?php echo strtoupper($tag['Tag']['name']); ?></h1>
			</div>
		</div>
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
	<div class="row-fluid">
		<div class="span12">
			<div class="thumb-collection clearfix">
				<?php foreach ($posts as $k => $v): ?>
					<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
				<?php endforeach ?>	
			</div>
		</div>
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
		