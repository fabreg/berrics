<?php 

//get the current month of the year
$currMonth = date("n",strtotime($dateIn));
$currYear = date("Y",strtotime($dateIn));
$currDay = date("d",strtotime($dateIn));
$this->Html->scriptBlock("var date_nav_json=".json_encode($date_nav_array).";",array("inline"=>false));

?>
<?php 

$this->Html->scriptStart(array("inline"=>false));

?>
	
	var dateIn = '<?php echo $dateIn; ?>';
	var currDay = '<?php echo $currDay; ?>';
	var currMonth = '<?php echo $currMonth; ?>';
	var currYear = '<?php echo $currYear; ?>';
	
<?php 

$this->Html->scriptEnd();
$this->Html->script(array("dailyops/date-bit"),array("inline"=>false));
$this->Html->css(array("dailyops/date-bit"),"stylesheet",array("inline"=>false));
?>
<div id='date-bit'>
<div class='inner'>
	<div class='left-arrow'>
		<img src='/img/layout/dops/date-bit-arrow-left.png' />	
	</div>
	<div class='right-arrow'>
		<img src='/img/layout/dops/date-bit-arrow-right.png' />	
	</div>
	<div class='slide-wrapper'>
		<div class='date-days'>
			
		</div>
	</div>
	<div class='jump-nav'>
		<div class='months'>
			<?php 
				$date = '';
				for($i=1;$i<=12;$i++) $date .= " <span month='{$i}'>".strtoupper(date("M",strtotime("2011-{$i}-01")))."</span>";
				echo ltrim($date,"|");
			?>
		</div>
		<div class='years'>
			<?php 
				$years = '';
				for($i=2007;$i<=date("Y",time());$i++) $years .= "<span year='{$i}'>{$i}</span>";
				echo $years;
			?>
		</div>
		<div style="clear:both;"></div>
	</div>
</div>
</div>