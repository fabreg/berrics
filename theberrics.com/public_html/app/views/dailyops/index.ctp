<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

switch($this->theme) {

	case "battle-commander-carlin":
		$this->set("title_for_layout","BATTLE COMMANDER: JIMMY CARLIN");
	break;
	default:
		$this->set("title_for_layout","Daily Ops");
	break;
}




?>
<?php if(date("Y-m-d")=="2012-05-05"): ?>
<style>

body {

	bacgkround-color:black;
	background-image:url(/theme/cinco-de-mayo/img/cinco-body.jpg);

}

.d-post-bit {

	background-color:transparent;

}
.d-post-bit .container-top {

	background-color:transparent;
	background-image:url(/theme/cinco-de-mayo/img/cinco-post-top.jpg);

}
.d-post-bit .container {

	background-color:transparent;
	background-image:url(/theme/cinco-de-mayo/img/cinco-post-bg.jpg);

}

.d-post-bit .bottom {

	background-image:url(/theme/cinco-de-mayo/img/cinco-post-bottom.jpg);

}

.d-post-bit .container-top .title h2 a {

	color:#781212;

}

</style>
<?php endif; ?>
<div id='dailyops'>
<?php 
if(!isset($this->params['section'])):
?>

<?php 
endif;
?>
<?php

foreach($dailyops as $k=>$dop):

?>

<?php 

	if($k == 0) {
		
		echo "<div class='top-date-heading'><h1>&nbsp;&nbsp;&nbsp;DAILY OPS: <span class='date-top' style=''>".strtoupper(date("l, F j, Y",strtotime($dop['Dailyop']['publish_date'])))."</span></h1></div>";
		
		echo "<div style='text-align:center; padding-bottom:3px;'><a href='/battle-at-the-berrics-5'><img border='0' src='/theme/battle-at-the-berrics-5/img/week11-winner.jpg' /></a></div>";
		
		//echo "<div><a href='/identity/login/send_to_facebook/".base64_encode("/pizza_party")."'><img border='0' src='/img/layout/pizza_miller.jpg'/></a></div>";
		
		
	}
	?>

	
	<?php 
	echo $this->element("dailyops/post-bit",array("dop"=>$dop));
	
	if($k == 0) {

		echo $this->element("banner-placements/dops-post-bottom");

	} 
		
	echo "<div style='height:35px;'></div>";	
		
?>

<?php 

endforeach;

?>

<?php if(isset($yn3)): ?>
<div>
<?php foreach($yn3 as $yp): ?>
<div style='float:left;'>
<?php echo $this->element("dailyops/post-thumb-large",array("dop"=>$yp)); ?>
</div>
<?php endforeach; ?>
<div style='clear:both; height:30px;'></div>
</div>
<?php endif; ?>



	<div id='paging-menu'>
		<div class='left'>
		<?php 
		
			if($newer_date && !preg_match('/^(\/dailyops)/',$_SERVER['REQUEST_URI'])) {
				$newer_date = strtotime($newer_date);
				echo $this->Html->link("<span> ".date("F jS, Y",$newer_date)."</span>",date("/Y/m/d",$newer_date),array("escape"=>false,"title"=>date("F jS, Y",$newer_date)));
				
			}
			
		?>
		</div>
		<div class='right'>
		<?php 
			
			if($older_date) {
				
				$older_date = strtotime($older_date);
				echo $this->Html->link("<span>".date("F jS, Y",$older_date)."</span>",date("/Y/m/d",$older_date),array("escape"=>false,"title"=>date("F jS, Y",$older_date)));
				
			}
			
		?>
		</div>
		<div style='clear:both'></div>
	</div>
</div>

<?php 

echo $this->element("dailyops/date-bit");

?>