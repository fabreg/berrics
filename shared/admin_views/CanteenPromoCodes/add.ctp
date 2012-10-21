<?php 

$rates = array();

for($i=1;$i<=100;$i++) $rates[$i] = $i;

?>
<div class="canteenPromoCodes form">
<?php echo $this->Form->create('CanteenPromoCode',array("enctype"=>"multipart/form-data"));?>
	<fieldset>
		<legend><?php echo __('Add Canteen Promo Code'); ?></legend>
	<?php
		echo $this->Form->input('start_date');
		echo $this->Form->input('expire_date');
		echo $this->Form->input('name');
		echo $this->Form->input('rate',array("options"=>$rates));
		echo $this->Form->input('promo_type',array("options"=>CanteenPromoCode::promoTypeSelect()));
		echo $this->Form->input('promo_code');
		echo $this->Form->input("icon_file",array("type"=>"file"));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">

</div>