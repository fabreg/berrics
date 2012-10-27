<?php 

$misc = Arr::dailyopsMiscCategories();

$weight = array();

for($i=1;$i<=100;$i++) $weight[$i] = $i;

?>
<script>

$(document).ready(function() {


	$( "#DailyopPublishDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#DailyopDisplayWeight").each(function() { 

		$(this).change(function() { 
			
			var num = $(this).attr("form_number");

			$("#form"+num).submit();
			
		});

	});
	
});

</script>
<style>
table td, table th {

	font-size:12px;

}

table td select {
	
	font-size:12px;

}
</style>
<div class='page-header'>
	<h1>News Manager</h1>
</div>
<div>
	<ul class='nav nav-tabs'>
		<li class='dropdown'>
			<a class='dropdown-toggle' data-toggle='dropdown' href='#'>Actions <b class='caret'></b></a>
			<ul class='dropdown-menu'>
				<li>
					<a href='<?php echo $this->Admin->url(array("action"=>"add_news_post")); ?>'><i class='icon icon-plus-sign'></i> Create New Post</a>
				</li>
			</ul>
		</li>
		<li>
			<a href='#filter' data-toggle='tab'>Filter</a>
		</li>
	</ul>
	<div class='tab-content'>
		<div class='tab-pane' id='filter'>
			<div class='well well-small'>
				<?php 
			
					echo $this->Form->create("Dailyop",array("url"=>array("action"=>"search_news")));
					echo $this->Form->input("misc_category",array("options"=>$misc,"empty"=>true));
					echo $this->Form->input("publish_date",array("type"=>"text"));
					echo $this->Form->end("Filter");
					
				?>
			</div>
		</div>
	</div>
</div>
<div class='index form'>
	
	<?php 
		echo $this->Admin->adminPaging();
	?>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("active"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("publish_date"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("User"); ?></th>
			<th><?php echo $this->Paginator->sort("misc_category"); ?></th>
			<th><?php echo $this->Paginator->sort("display_weight"); ?></th>
			<!-- <th><?php echo $this->Paginator->sort("best_of"); ?></th> -->
			<th>-</th>
		</tr>
		<?php 
			foreach($posts as $key=>$p):
		?>
		<tr>
			<td><?php echo $p['Dailyop']['id']; ?></td>
			<td  align='center'>
				<?php 
				
					switch($p['Dailyop']['active']) {
						
						case 1:
							echo "<span style='color:green;'>Yes</span>";
						break;
						default:
							echo "<span style='color:red;'>No</span>";
						break;
						
					}
				
				?>
			</td>
			<td><?php echo $this->Time->niceShort($p['Dailyop']['modified']); ?></td>
			<td><?php echo $this->Time->niceShort($p['Dailyop']['publish_date']); ?></td>
			<td>
				<?php echo $p['Dailyop']['name']; ?>
				<div>
					<small><?php echo $p['Dailyop']['sub_title']; ?></small>
				</div>
			</td>
			<td><?php echo $p['User']['first_name']; ?> <?php echo $p['User']['last_name']; ?></td>
			<td><?php echo $misc[$p['Dailyop']['misc_category']]; ?></td>
			<td align='center'><?php 
			
				echo $this->Form->create("Dailyop",array("url"=>array("action"=>"updateDisplayWeight"),"id"=>"form".$key));
			?>
			<div class='row-fluid'>
				<div class='span6'>
					<?php 
					echo $this->Form->input("display_weight",array("options"=>$weight,"value"=>$p['Dailyop']['display_weight'],"label"=>false,"div"=>false,"form_number"=>$key));
					echo $this->Form->input("id",array("value"=>$p['Dailyop']['id']));
					echo $this->Form->input("postback",array("value"=>base64_encode($this->here),"type"=>"hidden"));
					
					?>
				</div>
				<div class='span6'>
					<button class='btn btn-primary btn-mini'>Go</button>
				</div>
			</div>
			<?php 
				
				echo $this->Form->end();
			
			?></td>

			<!-- <td>
				<?php 
				
					echo $this->Form->create("Dailyop",array("url"=>array("action"=>"updateBestOfWeight"),"id"=>"form".$key));
					echo $this->Form->input("best_of",array("type"=>"checkbox","checked"=>$p['Dailyop']['best_of'],"label"=>false,"div"=>false));
					echo $this->Form->input("best_of_weight",array("options"=>$weight,"label"=>false,"div"=>false,"value"=>$p['Dailyop']['best_of_weight']));
					
					echo $this->Form->input("id",array("value"=>$p['Dailyop']['id']));
					echo $this->Form->input("postback",array("value"=>base64_encode($this->here),"type"=>"hidden"));
					echo $this->Form->submit("GO",array("div"=>false));
					echo $this->Form->end();
				
				?>
			</td>
			 -->
			<td class='actions'>
				<a href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"edit",$p['Dailyop']['id'])); ?>'>Edit</a>
				<a href='http://dev.theberrics.com/news/<?php echo $p['Dailyop']['uri']; ?>' target='_blank'>Preview</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>