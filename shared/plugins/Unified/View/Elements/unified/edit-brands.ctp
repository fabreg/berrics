<script>
jQuery(document).ready(function($) {
	
	loadBrandList();


	$("#attached-brands ul").sortable({
			axis:"y",
			 update: function( event, ui ) {

			 	var $i = 1;
			 	console.log("fuck");
			 	$(".brand-li").each(function() { 

			 		$(this).find('input.brand-display-weight').val($i);
			 		$i++;

			 	});


			 }
		});
		$("#attached-brands ul").disableSelection();

});

function attachBrand (e) {
	
	var $ele = $(e);

	var tr = $(e).parent().parent();

	var table = $('#new-brands table tbody');

	var row = $("<tr><td></td><td></td></tr>")
	
	var numNew = table.find('tr').length+1000;

	var inputs = $("<input />").attr({

		"type":"hidden",
		"name":"data[UnifiedStoreBrand]["+numNew+"][brand_id]",
		"value":tr.attr("data-brand-id")

	});

	row.find("td:eq(0)").append(tr.attr("data-brand-name"));
	row.find("td:eq(1)").append(inputs);

	table.append(row);

	showBrandChange();

	tr.remove();
}

function removeBrand (argument) {
	
}

function loadBrandList () {
	
	var data = {

		data:{

			Brand:new Array()

		}

	};

	$('#attached-brands ul li').each(function() { 
	
		var id = $(this).attr("data-brand-id");

		data.data.Brand[$(this).index()] = {

			id:id

		};

	});

	var o = {

		url:"<?php echo $this->Html->url(array("controller"=>"brands","action"=>"brand_list","plugin"=>"unified")) ?>",
		success:function(d) {
	
			$("#brand-list").html(d);
			initBrandList();
			initBootstrap();

		},
		data:data,
		type:"post"

	};

	$.ajax(o);

}

function initBrandList () {
	
	$("#brand-filter").unbind().bind('keyup',function(e) { 
	
		var str = $("#brand-filter").val();

		if(str.length<=0) {

			$("td.td-brand-name").parent().show();

		} else {
	
			$("td.td-brand-name").parent().hide();
			$("td.td-brand-name:icontains("+str+")").parent().show();
		}

	});

	$("#brand-list ul li a").unbind().bind('dblclick',function() { 
		$("#attached-brands ul").append($(this).parent());
		return false
	});

}

function showBrandChange() {

	$("#brand-change-alert").show();

}

</script>
<style>
#brand-change-alert {

	display: none;

}
</style>
<div class="row-fluid">
	<div class="span6">
		<h3>
			Brands
		</h3>
	<div class="alert alert-danger" id='brand-change-alert'>
		Changes Have Been Made - <button class="btn btn-primary btn-mini"><i class="icon icon-white icon-edit"></i> Click Here To Save</button> <button class="btn btn-danger btn-mini">Click Here To Reset</button>
	</div>
	<div id="new-brands">
		<table cellspacing="0">
			<tbody>
				
			</tbody>
		</table>
	</div>
	<div id="attached-brands">
		<?php if (count($this->request->data['UnifiedStoreBrand'])<=0): ?>
			<div id='no-brands-alert' class="alert">No Brands Are Attached To Your Store</div>
		<?php else: ?>
			<ul class='nav nav-tabs nav-stacked'>
				<?php foreach ($this->request->data['UnifiedStoreBrand'] as $k => $v): ?>
				<li data-brand-id='<?php echo $v['Brand']['id']; ?>' class='brand-li'>
					<a>
						<i class="icon icon-reorder"></i>	<?php echo $v['Brand']['name']; ?>
						<?php echo $this->Form->input("UnifiedStoreBrand.{$k}.id"); ?>
						<?php echo $this->Form->input("UnifiedStoreBrand.{$k}.display_weight",array("class"=>"brand-display-weight","type"=>"hidden")); ?>
						<div class="pull-right">
							<button class="btn btn-danger btn-mini" name='submit-btn[remove-brand]' value='<?php echo $v['id']; ?>'>
								<i class="icon icon-white icon-remove-sign"></i> Remove
							</button>
						</div>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	</div>
	</div>
	<div class="span6">
		<h3>Search Brands</h3>
		<div id="brand-list">
			
		</div>
	</div>

</div>