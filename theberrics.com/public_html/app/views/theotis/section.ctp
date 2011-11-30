<div id='theotis-section'>
	<div class='top-img'>
		<img alt='Skull Candy Presents: 31 Days Of Theotis' border='0' src='/theme/31-days-of-theotis/img/top.jpg' />
	</div>
	<div class='top-content'>
		<div class='inner'>
		
		</div>
	</div>
	<div class='green-top'>
		
	</div>
	<div class='t-cal'>
		<div class='inner'>
			<?php 
			
				$days = array(
	
							"SUN",
							"MON",
							"TUE",
							"WED",
							"THU",
							"FRI",
							"SAT"
						
						);
			
			?>
			<table class='t-cal-table' cellspacing='0'>
				<thead>
					<tr>
						<?php foreach($days as $d) echo "<th>{$d[0]}</th>"; ?>
					</tr>
				</thead>
				<tbody>
					<?php 
						
						
						
						$dseed = $dstamp = strtotime("2011-12-01");
												
						while($dseed<strtotime("+1 Month",$dstamp)) {
	
							foreach($days as $d) {
							
								$cell_content = "&nbsp;";
								
								$dtoken = strtoupper(date("D",$dseed));
							
								if($dtoken == $d) {
									
									$cell_content = date("d",$dseed);
									$dseed = strtotime("+1 Day",$dseed);
									
								}

								if($d == "SUN") echo "<tr>";
	
								echo "<td valign='top' align='left'>{$cell_content}</td>";
								
								if($d == "SAT") echo "</tr>";
							
							}
					
						
						}
					
					?>
				</tbody>
			</table>
		</div>
	</div>
	<div class='t-bottom'></div>
</div>
