<div class='cart-items'>
	<table cellspacing='0' class='table table-striped table-bordered'>
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
				<td align="center" valign="middle">
				<div class='delete' hash='<?php echo $item['hash']; ?>'>
					<button class="btn btn-danger">
						<i class="icon icon-remove-sign"></i>
					</button>
				</div>
				</td>
				<td valign='top' >
					
					<?php foreach($item['ChildCanteenOrderItem'] as $key=>$c): ?>
						<div class='item-wrapper clearfix'>
							<div class='img-thumb'>
								<?php 
									echo $this->Media->productThumb($c['CanteenProduct']['ParentCanteenProduct']['CanteenProductImage'][0],array("w"=>45,"h"=>45),array("lazy"=>true));							
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