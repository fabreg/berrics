<script>

$(document).ready(function() { 


	$('.quick-inv').click(function() { 

		var id = $(this).attr("canteen_product_id");
		
		openDetails(id,this);
		$(this).remove();
	});
	

	
});

function openDetails(id,ele) {

	var div = $(ele).parent().parent();

	var $newDiv = $("<tr ><td colspan='11' inv='"+id+"' style='padding:0px;' align='right'>Loading</td></tr>");
	
	$(div).after($newDiv);

	$.ajax({
	
		"url":"/canteen_products/ajax_inv/"+id,
		"success":function(d) {

			$('td[inv='+id+']').html(d);
		
		}

	});

	
}


</script>
<div class='index form'>
	<h2>Canteen Products</h2>
	
	<fieldset>
		<legend>Filter</legend>
		<?php 
		
			echo $this->Form->create("CanteenProduct",array("url"=>array("action"=>"filter")));
		?>
		<div style='width:450px;'>
			<?php 
				echo $this->Form->input("name");
			?>
		</div>
		<div style='width:450px;'>
			<?php 
				echo $this->Form->input("sub_title");
			?>
		</div>
		<div style='float:left;'>
			<?php echo $this->Form->input("canteen_category_id",array("options"=>$canteenCategories,"empty"=>true)); ?>
		</div>
		<div style='float:left;'>
			<?php echo $this->Form->input("brand_id",array("options"=>$brands,"empty"=>true)); ?>
		</div>
		<div style='clear:both;'></div>
			<div style='float:left;'>
			<?php //echo $this->Form->input("active"); ?>
		</div>
		<div style='float:left;'>
			<?php //echo $this->Form->input("featured"); ?>
		</div>
		<div style='clear:both;'></div>
		<?php 
			echo $this->Form->end("Run Filter");
		?>
	</fieldset>
	
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
					
	<table cellspacing='0' style='font-size:14px;'>
		<tr>
			<th>Thumb Image</th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("featured"); ?></th>
			<th><?php echo $this->Paginator->sort("display_weight"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("style_code"); ?></th>
			<th><?php echo $this->Paginator->sort("style_code_image"); ?></th>
			<th><?php echo $this->Paginator->sort("CanteenCategory.name"); ?></th>
			<th><?php echo $this->Paginator->sort("Brand.name"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th>-</th>
		</tr>
		<?php 
		
			foreach($products as $prod):
				$p = $prod['CanteenProduct'];
				$c = $prod['CanteenCategory'];
				$b = $prod['Brand'];
		?>
		<tr>
			<td width='1%' nowrap>
				<?php if(isset($prod['CanteenProductImage'][0])): ?>
				<?php echo $this->Media->productThumb($prod['CanteenProductImage'][0],array("w"=>50)); ?>
				<?php else: ?>
				No Image
				<?php endif; ?>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
					
					switch($p['active']) {
					
						case 1:
							$txt =  "<span style='color:green;'>YES</span>";
						break;
						default:
							$txt = "<span style='color:red;'>NO</span>";
						break;
					}
					
				?>
				<a href='/canteen_products/toggle_active/<?php echo $p['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'><?php echo $txt; ?></a>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
				
					switch($p['featured']) {
					
						case 1:
							$txt = "<span style='color:green;'>YES</span>";
						break;
						default:
							$txt = "<span style='color:red;'>NO</span>";
						break;
					}
				?>
				<a href='/canteen_products/toggle_featured/<?php echo $p['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'><?php echo $txt; ?></a>
			</td>
			<td align='center' nowrap width='1%'>
				<?php 
				
					echo $p['display_weight'];
					
				?>
			</td>
			<td align='center' width='1%' nowrap><?php echo $this->Time->niceShort($p['modified']); ?></td>
			
			<td align='center' nowrap width='1%' ><?php echo $p['style_code']; ?></td>
			<td align='center' nowrap width='1%' >
			<?php if(!empty($p['style_code_image'])): ?>
			<img border='0' src='http://img.theberrics.com/i.php?src=/product-img/<?php echo $p['style_code_image']; ?>&w=50' />
			<?php else: ?>
			NO IMAGE
			<?php endif; ?>
			</td>
			<td align='center' width='1%' nowrap ><?php echo $c['name']; ?></td>
			<td align='center' width='1%' nowrap ><?php echo $b['name']; ?></td>
			<td align='left' nowrap ><?php echo $p['name']; ?> - <?php echo $p['sub_title']; ?></td>
			
			<td class='actions'>
				<a href='/canteen_products/edit/<?php echo $p['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
				<a href='/canteen_products/edit/<?php echo $p['id']; ?>/<?php echo base64_encode($this->here); ?>' target='_blank'>Edit In New Window</a>
				<a target='_blank' href='http://dev.theberrics.com/canteen/item/<?php echo $p['uri']; ?>'>Dev Link</a>
				<a href='javascript:return false;' class='quick-inv' canteen_product_id='<?php echo $p['id']; ?>'>Quick View: Options & Inv</a>
				<?php if(!$p['ljg_inv'] && $p['brand_id']==3): ?>
				<a href='/canteen_products/ljg_products/<?php echo $p['id']; ?>/1/callback:<?php echo base64_encode($this->here); ?>'>Attach & Create LGJ Inventory</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
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
</div>