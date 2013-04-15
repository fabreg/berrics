<?php 

$this->set("title_for_layout","The Berrics - MTN DEW");


$pag_nav = "<ul>";
//$pag_nav .= "<li>".$this->Paginator->prev("&laquo;",array("tag"=>false),null,array("tag"=>"a"))."</li>";
$pag_nav .=  $this->Paginator->numbers(array(
						"before"=>null,
						"after"=>null,
						"separator"=>null,
						"tag"=>"li",
						"currentClass"=>"active"
					));
$pag_nav = preg_replace("(\/mtn_dew\/section)", "/mtn-dew", $pag_nav);
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
<div id="mtn-dew">
	<div class="row-fluid">
		<div class="span6">
			<h3>
				Posts (<?php echo $this->request->params['paging']['Dailyop']['count']; ?>)
			</h3>
		</div>
		<div class="span6">
			<div class="pagination pull-right">
				<?php 
					
					echo $pag_nav; 
				?>
			</div>
		</div>
	</div>
	<div class='dailyops-day' data-date='<?php echo date('Y-m-d',strtotime($dateIn)) ?>' data-next-uri='<?php echo date("/Y/m/d",strtotime("-1 Day",strtotime($dateIn))); ?>' data-timestamp='<?php echo strtotime($dateIn)*1000; ?>'>
<?php echo $this->element("banners/728") ?>
<?php 

	$lazy = true;

	foreach ($posts as $k => $v): 
?>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php if ($k==2): ?>
			<?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
	<?php endif ?>
	<?php endforeach ?>
	<?php 
		$lazy = true;
		foreach ($posts['news'] as $k => $v):
	 ?>
		<?php if ($k==2): ?>
			<?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
		<?php endif ?>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>$lazy)); ?>
	<?php endforeach ?>
</div>
<div class="row-fluid">
		<div class="span6">
			<h3>
				<?php echo $this->request->params['paging']['Dailyop']['count']; ?> Posts
			</h3>
		</div>
		<div class="span6">
			<div class="pagination pull-right">
				<?php 
					
					echo $pag_nav; 

				?>
			</div>
		</div>
	</div>
</div>