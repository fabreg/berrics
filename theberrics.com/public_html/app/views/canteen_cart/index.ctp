<style>

#canteen-cart {} 


#canteen-cart .items {

	width:86%;
	margin-left:85px;

}

#canteen-cart .items table {
	
	width:100%;
	font-size:12px;
	color:#333;	
	border:1px solid #999;
	border-right:none;
	border-bottom:none;
}

#canteen-cart .items table th {

	font-family:'Arial';
	font-size:10px;
	font-weight:bold;
	border:1px solid #999;
	border-left:none;
	border-top:none;
	padding:3px;
}

#canteen-cart .items table td {

	border:1px solid #999;
	border-left:none;
	border-top:none;
	padding:3px;
	color:black;
	font-family:'Courier';
	font-size:16px;
}

#canteen-cart .items table .price {

	text-align:center;
	width:1%;
	padding-left:25px;
	padding-right:25px;

}
#canteen-cart .items table td .brand {

	font-family:'Arial';
	font-size:11px;
	font-weight:bold;
	color:#777;
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
	text-indent:80px;
	padding-top:20px;
}

</style>
<div id='canteen-cart'>
	<div class='header'>
		<h1>THE CANTEEN // SHOPPING CART</h1>
	</div>
	<div class='container'>
		<div class='container-top'>
			<div class='items'>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>VISUAL</th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","items",$user_locale)); ?></th>
							<th width='1%' nowrap><?php echo strtoupper(Lang::instance()->p("CommonFields","qty",$user_locale)); ?></th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","price",$user_locale)); ?></th>
						</tr>	
					</thead>
					<tbody>
						<?php foreach($this->data['CanteenOrderItem'] as $item): ?>
						<tr>
							<td width='2%' align='center'>
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
							</td>
							<td align='center'><?php echo $item['quantity']; ?></td>
							<td class='price'><?php echo $this->Number->currency($item['price'],$user_currency_id); ?></td>
						</tr>	
						<?php endforeach; ?>
					</tbody>
				</table>	
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	
	
	<div class='checkout'>
		
	</div>
</div>