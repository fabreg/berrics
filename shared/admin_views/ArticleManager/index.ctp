<?php




?>
<script>
$(document).ready(function() { 


	$("a[rel=toggle-search]").click(function() { 

		$("#search").toggle();
		return false;

	});

	$("#ArticlePubDateStart").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	$("#ArticlePubDateEnd").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});
</script>
<style>
#ArticlePubDateStart,#ArticlePubDateEnd {

	width:200px;

}

</style>
<div class='index'>
	<h2>Aberrica.com - Articles</h2>
	<div class='form'>
		<fieldset>
			<legend><?php echo $this->Admin->link("Search","",array("rel"=>"toggle-search")); ?></legend>
			<div id='search' style='display:none;'>
				<?php 
				
					echo $this->Form->create("Article",array("url"=>array("action"=>"search","controller"=>"article_manager")));
					echo $this->Form->input("active");
					echo $this->Form->input("featured");
					echo $this->Form->input("my_articles",array("type"=>"checkbox","label"=>"Only Show Articles From ME!"));
					echo $this->Form->input("title");
					echo $this->Form->input("pub_date_start",array("type"=>"text","label"=>"Publish Date Start"));
					echo $this->Form->input("pub_date_end",array("type"=>"text","label"=>"Publish Date End"));
					echo $this->Form->input("article_type_id",array("empty"=>"* Show All"));
					echo $this->Form->input("AberricaCategory");
					echo $this->Form->end("Run Search");
				
				?>
			</div>
		</fieldset>
	</div>
		<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("featured"); ?></th>
			<th><?php echo $this->Paginator->sort("ArticleType","ArticleType.name"); ?></th>
			<th><?php echo $this->Paginator->sort("title"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort("view_count"); ?></th>
			<th><?php echo $this->Paginator->sort("User.id"); ?></th>
			<th>Actions</th>
		</tr>
		<?php 
		
			foreach($articles as $article):
			$a = $article['Article'];
			$u = $article['User'];
			$t = $article['ArticleType'];
		?>
		<tr>
			<td><?php echo $a['id']; ?></td>
			<td align='center'><?php 
			
				switch($a['active']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					case 0:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?></td>
			<td align='center'><?php 
			
				switch($a['featured']) {
					
					case 1:
						echo "<span style='color:green;'>Yes</span>";
					break;
					case 0:
						echo "<span style='color:red;'>No</span>";
					break;
				}
			
			?></td>
			<td><?php echo $t['name']; ?></td>
			<td><?php echo $a['title']; ?></td>
			<td><?php echo $this->Time->niceShort($a['modified']); ?></td>
			<td><?php echo $this->Time->niceShort($a['publish_date']); ?></td>
			<td align='center'><?php echo $a['view_count']; ?></td>
			<td><?php echo $u['email']; ?></td>
			<td class='actions'>
				<?php echo $this->Admin->link("Edit",array("controller"=>"article_manager","action"=>"edit",$a['id'])); ?>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>