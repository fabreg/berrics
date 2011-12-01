<?php 

if($_SERVER['REQUEST_URI']=="/"):

	$this->Html->css(array("theotis-splash"),"stylesheet",array("inline"=>false));

endif;

?>
<div id='theotis-section'>
	<div class='top-img'>
		<img alt='Skull Candy Presents: 31 Days Of Theotis' border='0' src='/theme/31-days-of-theotis/img/top.jpg' />
	</div>
	<div class='top-content'>
		<div class='inner'>
		<?php 
			if(isset($viewing['Dailyop']['id'])) echo $this->element("dailyops/post-bit",array("dop"=>$viewing));
			
		
		?>
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
								$clue_day = "";
								
								$dtoken = strtoupper(date("D",$dseed));
							
								if($dtoken == $d) {
									
									$p = array();
									$dchk = date("Y-m-d",$dseed);
									$chk = Set::extract("/Dailyop[check_date={$dchk}]",$posts);
									if(count($chk)>0) $p = $chk[0];	
									
									
									
									$cell_content = $this->element("theotis/cell-content",array("p"=>$p,"day"=>date("d",$dseed)));
									$clue_day = date("d",$dseed);
									$dseed = strtotime("+1 Day",$dseed);
									
								}

								if($d == "SUN") echo "<tr>";
	
								echo "<td valign='top' align='left' day='{$dseed}'>{$cell_content}</td>";
								
								if($d == "SAT") echo "</tr>";
							
							}
					
						
						}
					
					?>
				</tbody>
			</table>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div class='t-bottom'></div>
</div>
<?php if($_SERVER['REQUEST_URI'] == "/"): ?>
<div class='enter-the-berrics'>
	<a href='/dailyops'>ENTER THE BERRICS</a>
</div>
<?php endif; ?>