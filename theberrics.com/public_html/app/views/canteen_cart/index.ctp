<style>

#canteen-cart {} 


#canteen-cart .items {

	width:86%;
	margin-left:85px;

}

#canteen-cart .items table {
	
	width:100%;
	font-size:14px;
	color:#333;	
	border:1px solid #c1c1c1;
	border-right:none;
	border-bottom:none;
}

#canteen-cart .items table th {

	font-family:'Arial';
	font-size:10px;
	font-weight:bold;
	border:1px solid #c1c1c1;
	border-left:none;
	border-top:none;
	padding:8px;
	
}

#canteen-cart .items table td {

	border:1px solid #c1c1c1;
	border-left:none;
	border-top:none;
	padding:3px;
	color:black;
	font-family:'Courier';
	font-size:14px;
}

#canteen-cart .items table .price {

	text-align:center;
	width:130px;

}
#canteen-cart .items table td .brand {

	font-family:'Arial';
	font-size:11px;
	font-weight:bold;
	color:#777;
}

#canteen-cart .items table .qty {

	width:65px;
	
}

#canteen-cart .items table .product-option {

	font-style:italic;
	color:#000;
	font-size:13px;
	font-family:'Courier';

}

#canteen-cart .items table .product-img {

	padding-left:8px;
	padding-right:8px;

}

#canteen-cart .container {

	background-image:url(/img/layout/canteen/cart/cart-repeat-bg.jpg);
	margin-top:346px;
}

#canteen-cart .container-top {

	background-image:url(/img/layout/canteen/cart/cart-content-top.jpg);
	background-repeat:no-repeat;
	margin-top:-346px;

}

#canteen-cart .header {

	background-image:url(/img/layout/canteen/cart/cart-top.jpg);
	height:98px;

}
#canteen-cart .header h1 {

	margin:0px;
	padding:0px;
	font-weight:normal;
	font-size:20px;
	color:#646464;
	text-indent:82px;
	padding-top:17px;
}

#canteen-cart .checkout {

}

#canteen-cart .checkout .totals {

	float:right;
	width:210px;
	margin-right:62px;

}

#canteen-cart .checkout .totals dl {

	color:#000;
	font-family:'Courier';
	font-size:14px;
		border:1px solid #c1c1c1;
	border-top:none;
}

#canteen-cart .checkout .totals dt {

	width:120px;
	text-align:left;
	height:25px;
	line-height:25px;
	text-indent:10px;
}

#canteen-cart .checkout .totals dd {

	height:25px;
	line-height:25px;
	margin-top:-25px;
	margin-left:121px;
	
}

#canteen-cart .grand-total, #canteen-cart .grand-total-label {

	border:1px solid #000;
	font-weight:bold;

}

#canteen-cart .checkout .totals .grand-total {

	border-left:none;
	margin-top:-27px;
}
#canteen-cart .grand-total-label {
	
	border-right:none;

}

#canteen-cart .checkout .form {

	float:left;
	width:684px;

	margin-left:85px;
	margin-top:10px;
}
#canteen-cart .checkout .form .container {


	background-image:url(/img/layout/canteen/cart/form-repeat.jpg);
	margin-top:302px;

}

#canteen-cart .checkout .form .container-top {

	background-image:url(/img/layout/canteen/cart/form-top.jpg);
	margin-top:-302px;
	min-height:200px;
}
#canteen-cart .checkout .form .form-bottom {

	background-image:url(/img/layout/canteen/cart/form-bottom.jpg);
	height:24px;
}
</style>
<div id='canteen-cart'>
	<div class='header'>
		<h1>THE CANTEEN // SHOPPING CART</h1>
		<div style='padding-left:85px; padding-top:5px;'>
			<a href='/canteen'>
				<img border='0' alt='' src='/img/layout/canteen/cart/continue-shopping.png'/>
			</a>
		</div>
	</div>
	<div class='container'>
		<div class='container-top'>
			<div class='items'>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>VISUAL</th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","items",$user_locale)); ?></th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","qty",$user_locale)); ?></th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","price",$user_locale)); ?></th>
						</tr>	
					</thead>
					<tbody>
						<?php foreach($this->data['CanteenOrderItem'] as $k=>$item): ?>
						<tr>
							<td width='2%' align='center' valign='middle' class='product-img'>
								<?php 
							
									$img = Set::extract("/CanteenProductImage[thumb_image=1]",$item);
									
									if(count($img)<=0) {
										
										$img = Set::extract("/CanteenProductImage[front_image=1]",$item);
										
									}
									
									echo $this->Media->productThumb($img[0]['CanteenProductImage'],array("h"=>47,"w"=>47));
									
									echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_id",array("type"=>"hidden","value"=>$item['CanteenProduct']['id']));
									echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_option_id",array("type"=>"hidden","value"=>$item['CanteenProductOption'][0]['id']));
									echo $this->Form->input("CanteenOrderItem.{$k}.quantity",array("type"=>"hidden","value"=>$item['CanteenOrderItem'][0]['quantity']));
									
								?>
							</td>
							<td valign='top' >
								<span class='brand'><?php echo strtoupper($item['Brand']['name']); ?></span>
								<br />
								<?php echo $item['CanteenProduct']['name']; ?><?php echo (!empty($item['CanteenProduct']['sub_title'])) ? " - ".$item['CanteenProduct']['sub_title']:""; ?>
								<?php if(isset($item['CanteenProductOption'][0]['id'])): ?>
								<br /><span class='product-option'><?php echo strtoupper($item['CanteenProductOption'][0]['opt_label']); ?>:<?php echo strtoupper($item['CanteenProductOption'][0]['opt_value']); ?></span>
								<?php endif; ?>
							</td>
							<td align='center' class='qty'><?php echo $item['quantity']; ?></td>
							<td class='price'><?php echo $this->Number->currency($item['price'],$user_currency_id); ?></td>
						</tr>	
						<?php endforeach; ?>
					</tbody>
				</table>	
			</div>
			<div style='clear:both;'></div>
			<div class='checkout'>
				<div class='totals'>
					<dl class='totals-list'>
						<dt>Sub-Total..</dt>
						<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt>Shipping...</dt>
						<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['shipping'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt class='grand-total-label'>Total......</dt>
						<dd class='grand-total'><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
					</dl>
				</div>
				<div class='form'>
					<div class='container'>
						<div class='container-top'>
							
						</div>
					</div>
					<div class='form-bottom'></div>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div>
		<img border='0' alt='' src='/img/layout/canteen/cart/cart-bottom.jpg' />
	</div>
</div>