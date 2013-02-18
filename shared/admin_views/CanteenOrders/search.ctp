<script>

$(document).ready(function() { 

	$("#CanteenOrderStartDate,#CanteenOrderEndDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<style>

.date-ranges {


}

.date-ranges div.text {

	float:left;
	width:25%;
	clear:none;
}

</style>
<div class="page-header">
	<h1>Search Canteen Orders</h1>
</div>
<?php echo $this->Form->create('CanteenOrder',array(
	"id"=>'CanteenOrderForm',
	"url"=>$this->request->here
)); ?>
<div class="row-fluid">
	<div class="span6">
		<h3>Shipping Address</h3>
		<div class="well">
			<?php echo $this->Form->input("UserAddress.first_name"); ?>
			<?php echo $this->Form->input("UserAddress.last_name"); ?>
			<?php echo $this->Form->input("UserAddress.street_address"); ?>
			<?php echo $this->Form->input("UserAddress.apt"); ?>
			<?php echo $this->Form->input("UserAddress.postal_code"); ?>
			<?php echo $this->Form->input("UserAddress.country_code") ?>
			<?php echo $this->Form->input("UserAddress.state") ?>
			<?php echo $this->Form->input("UserAddress.email"); ?>
			<?php echo $this->Form->input("UserAddress.phone"); ?>
		</div>
	</div>
	<div class="span6">
		<h3>Order Information</h3>
		<div class="well">
			<?php echo $this->Form->input("id",array("type"=>"text")); ?>
			<?php echo $this->Form->input("order_status",array("options"=>$orderStatus,"empty"=>true)); ?>
		</div>
	</div>
</div>
<div class="form-actions">
	<button class="btn btn-primary">
		Run Search
	</button>
</div>
<?php echo $this->Form->end(); ?>