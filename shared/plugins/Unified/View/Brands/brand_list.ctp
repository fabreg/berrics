<div class="brand-filter">
	<input type="text" id='brand-filter'>
</div>
<table cellspacing='0'>
	<?php foreach ($brands as $k => $v): ?>
	<tr data-brand-id='<?php echo $v['Brand']['id']; ?>' data-brand-name="<?php echo $v['Brand']['name']; ?>">
		<td width='1%'><button class="btn btn-success btn-mini" type='button' onclick='attachBrand(this);'><i class="icon icon-white icon-plus-sign"></i></button></td>
		<td class='td-brand-name'>
			<?php echo $v['Brand']['name']; ?>
		</td>
	</tr>
	<?php endforeach ?>
</table>