<div class='index'>
	<h2>Gateway Transactions</h2>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("approved"); ?></th>
			<th><?php echo $this->Paginator->sort("GatewayAccount.name"); ?></th>
			<th><?php echo $this->Paginator->sort("cc_hash"); ?></th>
			
			<th><?php echo $this->Paginator->sort("currency_id"); ?></th>
			<th><?php echo $this->Paginator->sort("amount"); ?></th>
		</tr>
		<?php foreach($gatewayTransactions as $trans): 
					$t = $trans['GatewayTransaction'];
		?>
		<tr>
			<td align='center' width='1%' nowrap><?php echo $t['id'] ?></td>
			<td align='center' width='1%' nowrap><?php echo $this->Time->niceShort($t['created']); ?></td>
			<td align='center' width='1%' nowrap><?php echo $this->Time->niceShort($t["modified"]); ?></td>
			<td align='center' width='1%' nowrap><?php echo $t["approved"]; ?></td>
			<td><?php echo $trans["GatewayAccount"]["name"]; ?></td>
			<td align='center' width='1%' nowrap><?php echo $t['cc_hash']; ?></td>
			
			<td align='center' width='1%' nowrap><?php echo $t["currency_id"]; ?></td>
			<td align='center' width='1%' nowrap><?php echo $t["amount"]; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>