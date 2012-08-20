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
				<td align="center" valign="center">
				<div class='delete' hash='<?php echo $item['hash']; ?>'>
					<img border='0' src='/img/layout/canteen/cart/remove-item-icon.png' />
				</div>
				</td>
				<td valign='top' >
					
					<?php foreach($item['ChildCanteenOrderItem'] as $key=>$c): ?>
						<div class='item-wrapper'>
							<div class='img-thumb'>
								<?php 
									echo $this->Media->productThumb($c['CanteenProduct']['ParentCanteenProduct']['CanteenProductImage'][0],array("w"=>45,"h"=>45));							
								?>
							</div>
							<?php 
							
								echo $c['title']; 

								if(!empty($c['brand_label'])):
							?>
							<span class='brand'>BY: <?php echo strtoupper($c['brand_label']); ?></span>
							<?php 
								endif;
							?>
							
							<?php if(!empty($c['sub_title'])): ?> 
							<br /><span class='product-option'><?php echo $c['sub_title']; ?></span>
							<?php endif; ?>
							<br /><span class='qty'>Qty: <?php echo $c['quantity']; ?></span>
						</div>
						<div style='clear:both;'></div>
					<?php endforeach; ?>
				</td>
				<td class='price'><?php echo $this->Berrics->currency($item['sub_total'],$user_currency_id); ?></td>
			</tr>	
			<?php endforeach; ?>
			<?php if(!empty($this->data['UserAccountCanteenPromoCode']['name'])): ?>
			<tr>
				<td>
					
				</td>
				<td colspan='2' valign='center'>
					<div style='float:left; margin-left:5px; margin-right:5px;'>
					<?php echo $this->Media->promoCodeIcon($this->data['UserAccountCanteenPromoCode'],array("w"=>45,"h"=>45)); ?>
					</div>
					<?php echo $this->data['UserAccountCanteenPromoCode']['name']; ?>
				</td>
			</tr>
			<?php endif;?>
			<?php if(!empty($this->data['ShippingCanteenPromoCode']['name'])): ?>
			<tr>
				<td>
					
				</td>
				<td colspan='2' valign='center'>
					<div style='float:left; margin-left:5px; margin-right:5px;'>
					<?php echo $this->Media->promoCodeIcon($this->data['ShippingCanteenPromoCode'],array("w"=>45,"h"=>45)); ?>
					</div>
					<?php echo $this->data['ShippingCanteenPromoCode']['name']; ?>
				</td>
			</tr>
			<?php endif;?>
			
			<?php if(!empty($this->data['PromotionCanteenPromoCode']['name'])): ?>
			<tr>
				<td>
					
				</td>
				<td colspan='2' valign='center'>
					<div style='float:left; margin-left:5px; margin-right:5px;'>
					<?php echo $this->Media->promoCodeIcon($this->data['PromotionCanteenPromoCode'],array("w"=>45,"h"=>45)); ?>
					</div>
					<?php echo $this->data['PromotionCanteenPromoCode']['name']; ?>
				</td>
			</tr>
			<?php endif;?>
		</tbody>
	</table>	
</div>