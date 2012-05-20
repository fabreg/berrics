<table cellspacing='0'>
	<?php foreach($xml->Package as $key=>$val): ?>
		<?php foreach($val as $k=>$v): ?>
	<tr>
		<td align='right' width='20%'><?php echo $k; ?></td>
		<td><?php 
			
		if(count($v)>1) {
			
			echo "<ul>";
			foreach($v as $kk=>$vv) {
				
				echo "<li>";	
				echo "{$kk}:{$vv}";
				if($kk=="SpecialServices") {
					
					foreach($vv->SpecialService as $Service) {
						
						echo "<table cellspacing='0'>";
						foreach($Service as $sk=>$sv) {
							
							echo "<tr><td width='20%' align='right'><strong>{$sk}</strong></td><td>{$sv}</td></tr>";
							
						}
						echo "</table><br />";
						
					}
					
				}
				echo "</li>";
				
			}
			echo "</ul>";
			
		} else {
			
			echo $v;
		}
		?></td>
	</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>
</table>
<pre>
<?php 
//print_r($xml);
?>
</pre>