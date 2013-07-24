<script>
$(document).ready(function() { 

	$('form').prepend("<div id='tab-nav'><ul></ul><div style='clear:both;'></div></div>");
	
	$('fieldset').each(function() { 
		var l = $(this).find("h3");
		$('#tab-nav ul').append("<li>"+$(l).text()+"</li>");
	});

	$('#tab-nav li').css({
		"float":"left",
		"margin-right":"5px",
		"list-style":"none",
		"border":"1px solid #000",
		"padding":"5px",
		"cursor":"pointer"
	}).click(function() { 

		var ind = $(this).index();

		selectSet(ind);
		
	});

	selectSet(0);

	detectHash();
	
});

function hideAllSets() {

	$('fieldset').hide();

	$('#tab-nav li').css({
		"background-color":""
	});
	
}

function selectSet(ind) {

	hideAllSets();

	$("#tab-nav li:eq("+ind+")").css({
		"background-color":"#e9e9e9"
	});

	$("fieldset:eq("+ind+")").show();
	
}

function detectHash() {

	var h = unescape(document.location.hash);

	if(h.length>1) {

		h = h.replace(/#/,'');

		h = h.toLowerCase();
		
		$('#tab-nav li').each(function() { 

			var t = $(this).text().toLowerCase();

			if(t==h) {

				selectSet($(this).index());

			}
			
		});
		
	}
	
}

</script>
<style>
#tab-nav li {

-moz-border-radius-topleft: 10px;
-moz-border-radius-topright: 10px;
-moz-border-radius-bottomright: 0px;
-moz-border-radius-bottomleft: 0px;
-webkit-border-radius: 10px 10px 0px 0px;
border-radius: 10px 10px 0px 0px;

}
</style>
<div class='form index'>
<h2><?php echo $this->request->data['CanteenProduct']['name']; ?> - <?php echo $this->request->data['CanteenProduct']['sub_title']; ?></h2>
<h3>Editing Product ID: <?php echo $this->request->data['CanteenProduct']['id']; ?></h3>
<?php 
	echo $this->Form->create("CanteenProduct",array("enctype"=>"multipart/form-data","id"=>"CanteenProductEditForm"));
	echo $this->Form->input("id");
?>
<div class="tabbable">
	<ul class="nav nav-tabs">
		<li class='active'><a href="#general" data-toggle="tab">General Info</a></li>
		<li><a href="#images" data-toggle="tab">Images</a></li>
		<li><a href="#options" data-toggle="tab">Options & Inventory</a></li>
		<li><a href="#pricing" data-toggle="tab">Pricing</a></li>
		<li><a href="#style-code" data-toggle="tab">Style Code Options</a></li>
		<li><a href="#meta" data-toggle="tab">Meta Data</a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="general">
		<h3>General Info</h3>
		<?php echo $this->element("canteen_product/general-info"); ?>
		</div>
		
		<div class="tab-pane" id="images">
		<h3>Images</h3>
		<?php echo $this->element("canteen_product/images"); ?>
		</div>


		<div class="tab-pane" id="options">
		<h3>Options & Inventory</h3>
		<?php echo $this->element("canteen_product/qty-options"); ?>
		</div>
		
		<div class="tab-pane" id="pricing">
		<h3>Pricing</h3>
		<?php 
			echo $this->element("canteen_product/pricing");
		?>
		</div>
	
		<div class="tab-pane" id="style-code">
		<h3>Style Code Options</h3>
		<?php echo $this->element("canteen_product/style-code-options")?>
		</div>
	
		<div class="tab-pane" id="meta">
		<h3>Meta Data</h3>
		<?php echo $this->element("canteen_product/meta-data"); ?>
		</div>

	</div>
</div>
		
	<!-- 
	
		<h3>Warehouse Info</h3>
		<?php echo $this->element("canteen_product/wh-info"); ?>
	
 	-->
<div style='clear:both;'></div>
<?php 
	echo $this->Form->end();
?>
</div>
	
	<?php if(count($this->request->data['ValidateMessage'])>0): ?>
	
		<h3>Errors</h3>
		<div>
			<ul>
				<?php foreach($this->request->data['ValidateMessage'] as $v): ?>
				<li><?php echo $v; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	
	<?php endif; ?>