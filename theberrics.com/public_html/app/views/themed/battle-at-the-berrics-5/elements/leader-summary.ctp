<?php 

$pos = 1;

?>
<div class='leader-summary'>
	<div class='leader-summary-heading'>
		<?php 
			
			switch($this->params['pass'][0]) {
				
				case "overall":
					echo "OVERALL";
				break;
				default:
					echo "WEEKLY";
				break;
				
			}
		
		?>
	</div>
	<div class='leaders'>
		<table cellspacing='0'>
			<?php foreach($leaders as $k=>$v): ?>
			<tr>
				<td width='1%'><?php echo $pos; ?>.</td>
				<td><a href='/battle-at-the-berrics-5/scorecard/<?php echo $v['User']['id']; ?>'><?php $name = strtoupper($v['User']['first_name'])." ".strtoupper($v['User']['last_name']); echo $this->Text->truncate($name,35); ?></a></td>
				<td width='1%' class='score'><?php echo $v[0]['total']; ?></td>
			</tr>
			<?php 
				//lets check the final scores
				$next_score = $leaders[($k+1)][0]['total'];
				if($next_score < $v[0]['total']) {
					
					$pos ++;
					
				}
				endforeach; 
				
			?>
		</table>
	</div>
</div>
<pre>
<?php // print_r($leaders); ?>
</pre>