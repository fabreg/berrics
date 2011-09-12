<?php 

$p = GatewayAccount::providers();

?>
<div class='index'>
	<h2>Gateway Accounts</h2>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("provider"); ?></th>
			<th>-</th>
		</tr>
		<?php 
			foreach($accounts as $a):
		?>
		<tr>
			<td align='center'><?php echo $a['GatewayAccount']['id']; ?></td>
			<td align='center'>
			<?php 
			
				switch($a['GatewayAccount']['active']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					default:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?>
			</td>
			<td align='center'><?php echo $this->Time->niceShort($a['GatewayAccount']['modified']); ?>
			<td><?php echo $a['GatewayAccount']['name']; ?></td>
			<td  align='center'><?php echo $p[$a['GatewayAccount']['provider']]; ?></td>
			<td class='actions'>
				<a href='/gateway_accounts/edit/<?php echo $a['GatewayAccount']['id']; ?>'>Edit</a>
			</td>
		</tr>
		<?php 
			endforeach;
		?>
	</table>
</div>