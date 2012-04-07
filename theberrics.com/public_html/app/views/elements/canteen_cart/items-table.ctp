<?php 



?>
<div class='cart-items'>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th width='1%'>&nbsp;</th>
				<th><?php echo strtoupper(Lang::instance()->p("CommonFields","items",$user_locale)); ?></th>
				<th><?php echo strtoupper(Lang::instance()->p("CommonFields","price",$user_locale)); ?></th>
			</tr>	
		</thead>
		<tbody>
			<?php foreach($this->data['CanteenOrderItem'] as $k=>$item): ?>
			<tr>
				<td align="center" valign="center">&nbsp;</td>
				<td valign='top' >
					<div class='delete' hash='<?php echo $item['hash']; ?>'>REMOVE</div>
					<?php foreach($item['ChildCanteenOrderItem'] as $key=>$c): ?>
						<div class='item-wrapper'>
							<div class='img-thumb'>
								<?php 
									echo $this->Media->productThumb($c['CanteenProduct']['ParentCanteenProduct']['CanteenProductImage'][0],array("w"=>40,"h"=>40));							
								?>
							</div>
							<?php echo $c['CanteenProduct']['ParentCanteenProduct']['name']; ?><?php echo (!empty($c['CanteenProduct']['ParentCanteenProduct']['sub_title'])) ? " - ".$c['CanteenProduct']['ParentCanteenProduct']['sub_title']:""; ?>
							<?php if(!empty($c['CanteenProduct']['opt_label'])): ?> <span class='brand'>BY: <?php echo strtoupper($c['CanteenProduct']['ParentCanteenProduct']['Brand']['name']); ?></span>
							<br /><span class='product-option'><?php echo strtoupper($c['CanteenProduct']['opt_label']); ?>:<?php echo strtoupper($c['CanteenProduct']['opt_value']); ?></span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</td>
				<td class='price'><?php echo $this->Number->currency($item['sub_total'],$user_currency_id); ?></td>
			</tr>	
			<?php endforeach; ?>
			<tr>
				<td align='center'>
					<img alt='' border='0' src='/img/layout/canteen/ups-logo.png' />
				</td>
				<td colspan='2'>
				<div class='brand'>SHIPPING</div>
				<div>
					<?php echo $this->Form->input("CanteenOrder.shipping_option",array("type"=>"select","options"=>$shipping_codes)); ?>
				</div>
				</td>
				
			</tr>
		</tbody>
	</table>	
</div>