<?php 

$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));
$this->Html->scriptBlock("var date_nav_json=".json_encode($date_nav_array).";",array("inline"=>false));

switch($this->theme) {

	case "battle-commander-carlin":
		$this->set("title_for_layout","BATTLE COMMANDER: JIMMY CARLIN");
	break;
	default:
		$this->set("title_for_layout","Daily Ops");
	break;
}




?>
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
		
		echo "<div class='top-date-heading'><h1>&nbsp;&nbsp;&nbsp;DAILY OPS: <span class='date-top' style='color:#691400;'>".strtoupper(date("l, F j, Y",strtotime($dop['Dailyop']['publish_date'])))."</span></h1></div>";
		//echo "<div style='text-align:center;'><a href='/bang-yoself-3' title='Bang Yoself! 3'><img src='/img/layout/by3/BYS_toppost2.jpg' border='0' alt='Bang Yoself! 3' /></a></div>";
	}

	
	echo $this->element("dailyops/post-bit",array("dop"=>$dop));
	
	if($k == 0) {

		echo $this->element("banner-placements/dops-post-bottom");

	} 
		
	echo "<div style='height:35px;'></div>";	
	
	
?>

<?php 

endforeach;

?>
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