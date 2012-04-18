<script>
$(document).ready(function() { 

	$('form').prepend("<div id='tab-nav'><ul></ul><div style='clear:both;'></div></div>");
	
	$('fieldset').each(function() { 
		var l = $(this).find("legend");
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
<h2>Editing Product ID: <?php echo $this->data['CanteenProduct']['id']; ?></h2>
<?php 
	echo $this->Form->create("CanteenProduct",array("enctype"=>"multipart/form-data","id"=>"CanteenProductEditForm"));
	echo $this->Form->input("id");
?>

	<fieldset>
		<legend>General Info</legend>
		<?php echo $this->element("canteen_product/general-info"); ?>
	</fieldset>
	<fieldset>
		<legend>Images</legend>
		<?php echo $this->element("canteen_product/images"); ?>
	</fieldset>


	<fieldset>
		<legend>Options & Inventory</legend>
		<?php echo $this->element("canteen_product/qty-options"); ?>
	</fieldset>
	<fieldset>
		<legend>Pricing</legend>
		<?php 
			echo $this->element("canteen_product/pricing");
		?>
	</fieldset>
	<fieldset>
		<legend>Style Code Options</legend>
		<?php echo $this->element("canteen_product/style-code-options")?>
	</fieldset>
	
	<fieldset>
		<legend>Meta Data</legend>
		<?php echo $this->element("canteen_product/meta-data"); ?>
	</fieldset>
	<!-- 
	<fieldset>
		<legend>Warehouse Info</legend>
		<?php echo $this->element("canteen_product/wh-info"); ?>
	</fieldset>
 	-->
<div style='clear:both;'></div>
<?php 
	echo $this->Form->end();
?>
</div>