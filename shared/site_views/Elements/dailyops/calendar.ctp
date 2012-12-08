<?php 

if(!isset($year)) $year = date("Y");
if(!isset($month)) $month = date("m");

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
?>
<div id='calendar-index'>
	
	<div class="">
		<div>
			
		</div>
		<div>
			<?php echo date("F",$dstamp); ?> <?php echo date("Y",$dstamp) ?>
		</div>
		<div>
			
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
					$cls = "";
					$data_date = date("Y/m/d",$dstamp);
					$data_active = false;
					$dtoken = strtoupper(date("D",$dseed));
				
					if($dtoken == $d && (date("F",$dstamp) == date("F",$dseed))) {
						
						$p = array();
						$dchk = date("Y-m-d",$dseed);
						$cls = "";
						$cell_content = '';
						$day_label = "<div class='day-label'>".date("j",$dseed)."</div>";
						$dseed = strtotime("+1 Day",$dseed);

					}

					if($d == "SUN") echo "<tr>";

					echo "<td valign='top' align='left' data-timestamp='{$dseed}' data-date='{$data_date}'>{$day_label}{$cell_content}</td>";
					
					if($d == "SAT") echo "</tr>";
				
				}
		
			
			}
		
		?>
	</tbody>
</table>
</div>