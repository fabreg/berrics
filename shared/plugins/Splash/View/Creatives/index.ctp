<?php 
if(!$this->request->is("ajax")):
?>
<div class='page-header'>
	<h1>Splash Creatives</h1>
</div>
<?php endif; ?>
<?php echo $this->Admin->adminPaging(); ?>
<div>
	<ul class='nav nav-tabs'>
		<li class='dropdown'>
			<a href='#' rel='noAjax' data-toggle='dropdown' class="dropdown-toggle">Actions <b class='caret'></b></a>
			<ul class='dropdown-menu'>
				<li>
					<a rel='noAjax'  href='<?php echo $this->Html->url(array("action"=>"add","controller"=>"creatives","plugin"=>"splash")); ?>'><i class='icon icon-plus-sign'></i> Add New Creative</a>
				</li>
				<li>
					<a rel='noAjax' href='<?php echo $this->Html->url(array("action"=>"add","controller"=>"creatives","plugin"=>"splash")); ?>'><i class='icon icon-plus-sign'></i> Add New Creative</a>
				</li>
			</ul>
		</li>
		<li>
			<a href='#search' rel='noAjax' data-toggle='tab'>Search</a>
		</li>
	</ul>
	<div class='tab-content'>
		<div class='tab-pane' id='search'>
			<div class='well'>
				<?php echo $this->Form->create("SplashCreative",array("url"=>array("action"=>"search","controller"=>"creatives","plugin"=>"splash"),"id"=>"search-form")); ?>
				<?php echo $this->Form->input("page_title"); ?>
				<button class='btn btn-primary'>Search</button>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<div class='index'>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort("id"); ?></th>
				<th><?php echo $this->Paginator->sort("modified"); ?></th>
				<th><?php echo $this->Paginator->sort("active"); ?></th>
				<th><?php echo $this->Paginator->sort("page_title"); ?></th>
				<th>-</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($pages as $v): ?>
			<tr>
				<td><?php echo $v['SplashCreative']['id']; ?></td>
				<td><?php echo $this->Time->niceShort($v['SplashCreative']['modified']); ?></td>
				<td><?php
					
					switch($v['SplashCreative']['active']) {
						
						case 1:
							echo "<span class='label label-success'>Active</span>";
						break;
						default:
							echo "<span class='label label-important'>In-Active</span>";
						break;
					}
				
				?></td>
				<td><?php echo $v['SplashCreative']['page_title']; ?></td>
				<td class='actions'>
					<?php if($this->request->is("ajax")):  ?>
					
						<button class='btn btn-success attach-button' type='button' value='<?php echo $v['SplashCreative']['id']; ?>'><i class='icon icon-white icon-plus'></i> Attach</button>
					
					<?php else: ?>
					<?php echo $this->Html->link("Edit",array("action"=>"edit",$v['SplashCreative']['id'])); ?>
					<a href='http://dev.theberrics.com/splash/view/<?php  echo $v['SplashCreative']['hash_key']; ?>' class='btn btn-success btn-small' target='_blank'>
						<i class="icon icon-white icon-eye-open"></i> Preview</a>
					<a href="<?php echo $this->Admin->url(array("action"=>"copy",$v['SplashCreative']['id'])); ?>" class="btn btn-small btn-info">
						<i class="icon icon-white icon-pencil"></i> Copy
					</a>
					<?php 
						echo $this->Form->postLink("Delete",array(
																"plugin"=>"splash",
																"controller"=>"creatives",
																"action"=>"delete"
															),
															array(
																"data"=>array(
																	"SplashCreative.id"=>$v['SplashCreative']['id']		
																),
																"class"=>"btn btn-danger btn-small"
															),"Do you really want to delete this creative?"); 
						
					?>
					<?php endif; ?>
					
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>