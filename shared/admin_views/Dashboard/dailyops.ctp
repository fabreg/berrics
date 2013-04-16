<?php 

$num = array();

for($i=1;$i<=100;$i++) $num[$i] = $i;

?>
<script>

$(document).ready(function() { 


	$( "#DailyopStartDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#dop-date-form").submit(function() { 

		var d = "/"+$("#DailyopStartDate").val();

		var c = "/count:"+$("#DailyopCount").val() || 7;
		
		document.location.href="<?php echo $this->Admin->url(array("controller"=>"dashboard","action"=>"dailyops")); ?>"+d+c;
		
		return false;

	});

	
	$('.fix-video-file-button').click(function() { 

		var $this = $(this);

		var o = {
					"id":$this.val()
				};

		uploadVideoFile(o,false);
		
	});

	$('.fix-video-image-button').click(function(e) { 


		var $this = $(e.target);

		var id = $this.val();

		uploadVideoImage(id);


	});

	$('.dailyops-config').each(function() {

		var date = $(this).attr('data-date');

		$(this).load("/dailyops_configs/edit_date/"+date,function() {
			
			initBootstrap();
			
			initSubmitForm($(this));

		});


	});


	$(document).bind('videoFileUploadComplete',function() { 

		document.location.reload(true);

	});
	
});

function initSubmitForm($ele) {

			var $form = $ele;
			$ele.find('.dailyops-config-form').ajaxForm({

				"beforeSumbit":function() { 
				
					$ele.find('.submit-config-btn').hide();
					$ele.find('.config-progress').show();

					return true;
				},
				success:function(d) {

					$ele.html(d);
					initBootstrap();
					initSubmitForm($ele);
				}

			});

}

</script>
<style>
.post,.splash-creative {
	margin-bottom: 3px;
	padding: 3px;
	border-bottom: 1px solid #e9e9e9;
}

.col .post:last-child,.col .splash-creative:last-child {
	border-bottom: none;
}

.post-errors {

	border-radius:12px;
	border:1px solid #e9e9e9;
	background-color:white;

	margin:auto;
	width:99%;
	margin-top:10px;
	margin-bottom:10px;

}

.post-errors .inner {

		padding:8px;

}

.post-errors .heading {

	background-color:#f7f7f7;
	padding:5px;
	border-bottom:1px solid #e9e9e9;
	font-weight:bold;
	border-radius:inherit;
	border-bottom-right-radius:0px;
	border-bottom-left-radius:0px;
}

.dailyops-config-form {

	

}

.dailyops-config-form .control-group .control-label,
.dailyops-config-form .control-group select {

	font-size:12px;

}

</style>
<div>
		<div>
			<h3>Content</h3>
		</div>
		<div class='row-fluid'>
			<?php 
			
					echo $this->Form->create("Dailyop",array("id"=>"dop-date-form","class"=>"form-inline"));
					
				?>
				<div class='span2'>
				
					
						<?php echo $this->Form->input("start_date"); ?>
						
					
				
			</div>
			<div class='span2'>
			<?php echo $this->Form->input("count",array("label"=>"Num. Days","options"=>$num)); ?>
			</div>
			
			<div class='span3'>
				<br /><button class='btn btn-primary'><i class='icon icon-white icon-calendar'></i> Change Date</button>
			</div>
			<?php 
					echo $this->Form->end();
				
			?>
		</div>
		<div class='row-fluid'>
			<?php while((strtotime($start_date)) <= (strtotime($end_date))): ?>
				<div class='dop-table'>
				<table cellspacing='0'>
				<thead>
					<tr>
						<th>
							<h4>
								<?php echo date("l",strtotime($start_date)); ?>
								,
								<?php echo date("F jS Y",strtotime($start_date)); ?>
								<small>
									<?php 
										$uri = date("Y/m/d",strtotime($start_date));
									?>
									<a href="http://dev.theberrics.com/<?php echo $uri; ?>?showall" class="btn btn-success btn-mini" target='_blank'>Preview Day</a>
								</small>
							</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<h4>
								Splash Pages <a
									href='<?php echo $this->Admin->url(array("plugin"=>"splash","controller"=>"dates","action"=>"edit",$start_date,"cb"=>base64_encode($this->here))); ?>'
									class='btn btn-primary btn-mini'>Edit</a>
							</h4>
						</td>
					</tr>
					<tr>
						<td>
							<div class='dop-row clearfix'>
								<div class='col'>
		
									<?php if(!isset($dops[$start_date]['splash'])): ?>
									<div class='alert alert-danger'>No Splash Pages Assigned</div>
									<?php else: ?>
									<?php foreach($dops[$start_date]['splash'] as $splash): ?>
									<div class='splash-creative'>
										<strong><?php echo $splash['SplashCreative']['page_title']; ?> </strong>
										<div style='margin-top: 3px;'>
											<?php 
											switch($splash['SplashCreative']['active']) {
													
												case 1:
													echo "<span class='label label-success'>Active</span>";
													break;
												default:
													echo "<span class='label label-important'>In-Active</span>";
													break;
											}
											?>
											<a class='btn btn-success btn-mini' href='http://dev.theberrics.com/splash/<?php echo $splash['SplashCreative']['hash_key']; ?>' target='_blank'><i
												class='icon icon-white icon-eye-open'></i> Preview</a> <a
												class='btn btn-mini btn-primary'
												href='<?php echo $this->Admin->url(array("plugin"=>"splash","controller"=>"creatives","action"=>"edit",$splash['SplashCreative']['id'],"cb"=>base64_encode($this->here))); ?>'><i
												class='icon icon-white icon-edit'></i> Edit</a>
												<button type='button' value='<?php echo $splash['SplashDate']['id']; ?>' class='btn btn-danger btn-mini'><i class='icon icon-remove icon-white'></i> Remove</button>
										</div>
									</div>
									<?php endforeach; ?>
									<?php endif; ?>
								</div>
						
						</td>
					</tr>
					<tr>
						<td>
							<div class="dailyops-config" data-date='<?php echo $start_date; ?>'>
								
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<h4>
								Posts <a
									href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"add","publish_date"=>$start_date)); ?>'
									class='btn btn-primary btn-mini'>Create Post</a>
									 <a
									href='<?php echo $this->Admin->url(array("controller"=>"dailyops","action"=>"add_news_post","publish_date"=>$start_date)); ?>'
									class='btn btn-primary btn-mini'>Create News Post</a>
							</h4>
		
						</td>
					</tr>
					<tr>
						<td>
							<div class='col'>
								<?php if(!isset($dops[$start_date]['posts'])): ?>
								<div class='alert alert-danger'>No Posts Assigned</div>
								<?php else: ?>
								<?php foreach($dops[$start_date]['posts'] as $post): ?>
								<?php 
									echo $this->element("dailyops/post",array("post"=>$post));
								?>
								<?php endforeach; ?>
								<?php endif; ?>
							</div>
		
							</div>
						</td>
					</tr>
				</tbody>
				</table>
				</div>
				<?php 
		
				$start_date = date("Y-m-d",strtotime("+1 Day",strtotime($start_date)));
					
				endwhile;
		
				?>		
		</div>
</div>
<?php 

//print_r($dops);

?>