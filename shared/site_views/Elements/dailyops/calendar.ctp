<?php 

if(!isset($year)) $year = date("Y");
if(!isset($month)) $month = date("m");

if($this->request->params['controller'] == "dailyops" && $this->request->params['action'] == "index") {

	if(isset($this->request->params['year'])) $year = $this->request->params['year'];
	if(isset($this->request->params['month'])) $month = $this->request->params['month'];

}


	$days = array(

				"SUN",
				"MON",
				"TUE",
				"WED",
				"THU",
				"FRI",
				"SAT"
			
			);
$dseed = $dstamp = strtotime("{$year}-{$month}-01");

$next_link = "";
$prev_link = "";

$prev_link = "<a href='/dailyops/calendar/".date("Y/m",strtotime("-1 Month",strtotime("{$year}-{$month}-01")))."'>&lt;&lt;</a>";

$next_link = "<a href='/dailyops/calendar/".date("Y/m",strtotime("+1 Month",strtotime("{$year}-{$month}-01")))."'>&gt;&gt;</a>";


?>
<h2>CONTENT CALENDAR</h2>
	<div class="cal-nav">
		<div class='prev'>
			<?php echo $prev_link ?>
		</div>
		<div class='next'>
			<?php echo $next_link ?>
		</div>
		<div class='date-label'>
			<?php echo strtoupper(date("F",$dstamp)); ?> <br /> <?php echo date("Y",$dstamp) ?>
		</div>
		
	</div>
<table cellspacing='0' class='table table-bordered'>
	<thead>
		<tr>
			<?php foreach($days as $d) echo "<th align='center'>{$d[0]}</th>"; ?>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			while($dseed<strtotime("+1 Month",$dstamp)) {

				foreach($days as $d) {

					$cell_content = "&nbsp;";
					$clue_day = "";
					$day_label = "";
					$cls = "disabled";
					$data_date = date("Y/m/d",$dseed);
					$data_active = 0;
					$dtoken = strtoupper(date("D",$dseed));
				
					if($dtoken == $d && (date("F",$dstamp) == date("F",$dseed))) {
						
						if(isset($content[date("Y-m-d",$dseed)])) {

							$data_active = 1;
							$cell_content = "<a href='".date("/Y/m/d",$dseed)."'>".date("j",$dseed)."</a>";
							$cls = "active";
						} else {

							$cell_content = date("j",$dseed);
							$cls = "disabled-day";
						}
						$p = array();
						$dchk = date("Y-m-d",$dseed);
						
						
						//$day_label = "<div class='day-label'>".date("j",$dseed)."</div>";
						$dseed = strtotime("+1 Day",$dseed);

					}

					if($d == "SUN") echo "<tr>";

					echo "<td class='{$cls}' valign='top' align='left' data-timestamp='{$dseed}' data-date='{$data_date}' data-active='{$data_active}'>{$day_label}{$cell_content}</td>";
					
					if($d == "SAT") echo "</tr>";
				
				}
		
			
			}
		
		?>
	</tbody>
</table>
