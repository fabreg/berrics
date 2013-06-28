<?php 
$tag_array = Set::extract("/Tag/name",$this->data);

$tag_str = implode(",",$tag_array);

//make a select array for the sort order
$sort = array();

for($i=1;$i<=99;$i++) {

	$sort[$i]=$i;

}

ClassRegistry::init("Dailyop");

?>

<script>

$(document).ready(function() { 

	$( "#DailyopPubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#DailyopPubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});

	$('.top-checks div[class*=span]').addClass("check-well");
	$('.top-checks .check-well input[type=checkbox]').change(function() { styleChecks(); });
	
	styleChecks();

	$('.remove-tag').click(function(e) {

		var tag_id = $(this).parent().attr("id");

		jQuery.ajax({
		  url: $(this).attr("href"),
		  type: 'POST',
		  dataType: 'html',
		  success: function(data, textStatus, xhr) {
		    
		  	$("#"+tag_id).remove();

		  },
		  error: function(xhr, textStatus, errorThrown) {
		   	alert("an error occured");
		  }
		});
		
		return false;
	});

	$.ajax({

		"url":'<?php echo $this->Html->url(array("controller"=>"dailyops","action"=>"dupe_uri_check",$this->request->data['Dailyop']['id'],$this->request->data['Dailyop']['dailyop_section_id'],$this->request->data['Dailyop']['uri'])); ?>',
		"success":function(d) { 
			if(d==0) {

				$("label[for=DailyopUri]").append(" <span class='label label-important label-small'>DUPE FOUND</span>");

			}
		}

	});

});

function styleChecks() {

	$('.check-well').removeClass('checked').each(function(e) { 
		
		var $that = $(this);

		var chk = $that.find('input[type=checkbox]');
		
		if(chk.is(':checked')) {

			$that.addClass('checked');
			
		}

	});

	
	
}



</script>
<style type="text/css">
	
.close.remove-tag {

	float:right;

}
</style>
	<?php 
			$this->Form->formSpan = "span12";
			
			echo $this->Form->create("Dailyop",array("url"=>array("action"=>"handle_tab_save",$this->request->data['Dailyop']['id'])));
			
			echo $this->Form->input("element",array("type"=>"hidden","value"=>"edit-general"));
	?>
<h3>General</h3>
<?php echo $this->Session->flash(); ?>
<div class='row-fluid'>
	<div class='span6 pull-right'>
			<div class='row-fluid'>
				<div class='span6'>
					<?php 
					echo $this->Form->input("pub_date",array("type"=>"text","label"=>"Publish Date"));
					?>
				</div>
				<div class='span6'>
					<?php 
					echo $this->Form->input("pub_time",array("type"=>"text","label"=>"Publish Time"));
					?>
				</div>
			</div>
			<?php 
			echo $this->Form->input("display_weight",array("options"=>$sort));
			?>
			<div class='top-checks'>
					<div class='row-fluid'>
						<div class='span6 '>
							<?php 
							if(!in_array(CakeSession::read("Auth.User.id"),array("51ce185a-bf7c-48cc-986c-0e36c6659e49")))) {

									echo $this->Form->input("active",array("label"=>"Active","help"=>"<small>Activate/DeActivate Post</small>"));

							}
							
								
							
							?>
						</div>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("promo",array("help"=>"<small>Do not show post in related searches</small>"));
								
							?>
						</div>
					</div>
					<div class='row-fluid'>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("hidden",array("help"=>"<small>Hide post from archive</small>"));
								
							?>
						</div>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("news_post",array("help"=>"<small>Aberrican Times Post</small>"));
								
							?>
						</div>
					</div>
					<div class='row-fluid'>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("fix_later",array("help"=>"<small>Needs to be fixed</small>"));
								
							?>
						</div>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("featured_archive",array("help"=>"<small>Featured Archive Post</small>"));
								
							?>
						</div>
					</div>
					<div class='row-fluid'>
						<div class='span6 '>
							<?php 
							echo $this->Form->input("hide_media",array("help"=>"<small>Hide Media Element</small>"));
								
							
							?>
						</div>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("slide_show",array("help"=>"<small>Post is a slideshow</small>"));
								
							?>
						</div>
					</div>
					<div class='row-fluid'>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("contest_post",array("help"=>"<small>Contest Post</small>"));
								
							?>
						</div>
						<div class='span6 '>
							<?php 
							
							echo $this->Form->input("pinned",array("help"=>"<small>Pinned to the top of the DailyOps</small>"));
								
							?>
						</div>
					</div>
				</div>

		<div class='form-actions'>
			<?php echo $this->Form->submit("Update"); ?>
		</div>
	</div>
	<div class='span6 pull-left' style='margin-left:0px;'>
				<?php
				if(isset($this->params['pass'][1])) {
					
					echo $this->Form->input("postback",array("type"=>"hidden","value"=>$this->params['pass'][1]));
					
				}
				echo $this->Form->input('id');
				?>
				<div class='row-fluid'>
					<div class='span6'>
						<?php 
							echo $this->Form->input("theme_override",array("options"=>$themes,"empty"=>true,"help"=>"<small>These are themes that reside on the dev server</small>"));
						?>
					</div>
					<div class='span6'>
						<?php 
						echo $this->Form->input("misc_category",array("options"=>Arr::dailyopsMiscCategories(),"empty"=>true,"label"=>"Misc. Category","help"=>"<small style='color:red;'>Used for special posts including the news * LEGACY</small>"));
						?>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span6'>
						<?php 
						echo $this->Form->input('dailyop_section_id');
						?>
					</div>
					<div class='span6'>
						<?php echo $this->Form->input("ondemand_title_id",array("empty"=>true,"label"=>"On-Demand Title")); ?>
					</div>
				</div>
				<div class='row-fluid'>
					<div class='span6'>
						<?php 
						echo $this->Form->input('post_template');
						?>
					</div>
					<div class='span6'>
						
					</div>
				</div>
				<?php 
				
				echo $this->Form->input('name');
				echo $this->Form->input("sub_title");
				
				?>
				<div class="row-fluid">
					<div class="span8">
						<?php echo $this->Form->input("uri"); ?>
					</div>
					<div class="span4">
						<div class="control-group">
							<label for="" class='controls-label'>&nbsp;</label>
							<div class="controls">
								<?php 
									$dev_domain = "dev.";
									if(preg_match('/^(v3\.)/',$_SERVER['HTTP_HOST'])) {

										$dev_domain = "v3.";

									}
								 ?>
								<a target='_blank' href="http://<?php echo $dev_domain; ?>theberrics.com/<?php echo $this->request->data['DailyopSection']['uri']; ?>/<?php echo $this->request->data['Dailyop']['uri']; ?>" class="btn btn-success btn-mini">Preview Post On DEV</a>
							</div>
						</div>
					</div>
				</div>
				<?php
				echo $this->Form->input('add_tags',array("type"=>"text","label"=>"Add Tags (Comma sperate to attach multiple tags)"));
				
				?>
				<div><strong>Tags</strong></div>
				<div class="alert alert-info">
					<strong>Legend</strong> <br />
					<i class="icon icon-user"></i>USER 
					<i class="icon icon-flag"></i>BRAND
					<i class="icon icon-briefcase"></i>UNIFIED
					<i class="icon icon-star"></i>CATEGORY
				</div>
				<div class="clearfix">

					<?php if (count($this->request->data['Tag'])>0): ?>
						<?php foreach ($this->request->data['Tag'] as $key=>$val): ?>
							<div class="well well-small" style="float:left; margin-right:3px;" id='tag-<?php echo $val['id']; ?>'>
								<?php if (!empty($val['user_id'])): ?>
									<span class="dropdown">
										<button class="btn btn-primary btn-mini" data-toggle='dropdown'><i class="icon icon-user icon-white"></i></button>
										<ul class="dropdown-menu">
											<li>
												<a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'edit', $val['user_id']),false); ?>" target='_blank'>Edit User</a>
											</li>
											<li></li>
										</ul>
									</span>
								<?php endif ?>
								<?php if (!empty($val['brand_id'])): ?>
									<span class="dropdown">
										<button class="btn btn-small btn-primary"><i class="icon icon-flag icon-white"></i></button>
									</span>
								<?php endif ?>
								<?php if (!empty($val['unified_store_id'])): ?>
									<span class="dropdown">
										<button class="btn btn-small btn-primary"><i class="icon icon-briefcase icon-white"></i></button>
									</span>
								<?php endif ?>
								<?php if ($val['category']): ?>
									<button class="btn btn-small btn-primary">
										<i class="icon icon-star icon-white"></i>
									</button>
								<?php endif ?>
								<a href="<?php echo $this->Admin->url(array("action"=>"edit","controller"=>"tags",$val['id'])); ?>"><?php echo $val['name']; ?></a>&nbsp;
								<a href="<?php echo $this->Html->url(array("action"=>"handle_remove_tag",$this->request->data['Dailyop']['id'],$val['id'])); ?>" class="remove-tag btn btn-mini">x</a>
							</div>
						<?php endforeach ?>
					<?php else: ?>
						<span class="label label-important">No Tags Attached</span>
					<?php endif ?>
				</div>
			<div class='form-actions'>
			<?php echo $this->Form->submit("Update"); ?>
		</div>
	</div>
</div>
<?php echo $this->Form->end(); ?>