<?php 




?>
<style>

#filter-form {
	
	display:none;
	width:500px;
	
}

#filter-form div.text input {

	font-size:13px;
	padding:1px;

}

</style>
<script>
$(document).ready(function() { 


	$("#check-all").change(function() { 


		if(this.checked) {

			$(".order-check").attr("checked",true);

		} else {

			$(".order-check").attr("checked",false);
			
		}

		
	});


	$("#batch-form").submit(function() { 

		//var data = {};
		
		$('.order-check').each(function() { 

			if(this.checked) {

				//data[$(this).val()] = $(this).val();
				$("#batch-form").append("<input type='hidden' value='"+$(this).val()+"' name='data[CanteenOrder][]'/>");
						
			}
			
		});

		return true;

	});

	

	
});
</script>
<div class='form index'>
	<h2>Canteen Orders &nbsp;&nbsp;&nbsp;<span style='font-size:14px; font-weight:bold;'></span></h2>
	<div style='font-size:20px;'>
		<a href='/canteen_orders/search'>Search</a> | <a href='/canteen_orders'>Clear</a>
	</div>
	<p>
	<?php
		echo $this->Paginator->counter(array(
						'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
		));
	?>	
	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<div style='padding:10px;'>
	<?php 
		echo $this->Form->create("CanteenBatch",array("url"=>"/canteen_batches/add_to_batch/","id"=>"batch-form"));
		echo $this->Form->input("CanteenBatch.id",array("options"=>$batches,"label"=>"Batch","empty"=>"Add To New Batch"));
		echo $this->Form->end("Add Selected To Batch");
	?>
	</div>
	<?php echo $this->element("canteen_orders/index-table"); ?>
</div>