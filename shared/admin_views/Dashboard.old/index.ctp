<script>

$(document).ready(function() { 


	$("#dailyops-dash select").change(function() { 

		runPostFilters();

	});

	$("a[rel=reset-post-filters]").click(function() { 

		resetPostFilters();
		return false;
	});

	$('.post-row').hover(

		function() { 

			$(this).addClass('post-row-over');
			
		},
		function() { 

			$(this).removeClass('post-row-over');

		}

	);
	
});

function runPostFilters() {

	var d = $("#FilterDay").val();
	var s = $("#FilterSection").val();

	$('.post-row').show();

	if(s != undefined) {

		$('.post-row[section_id!="'+s+'"]').hide();

	}
	
	if(d != undefined) {

		$('.post-row[date!="'+d+'"]').hide();
		
	}

	

	
}

function resetPostFilters() {

	document.getElementById("FilterDay").selectedIndex = -1;
	document.getElementById("FilterSection").selectedIndex = -1;
	runPostFilters();
}

</script>
<style>

.row {

	clear:both;
	width:99%;
	margin:auto;
}

.row .left {

	width:32%;
	float:left;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border:1px solid #cccccc;
	-webkit-box-shadow: 2px 5px 5px #616161;
	-moz-box-shadow: 2px 5px 5px #616161;
	box-shadow: 2px 5px 5px #616161;
}


.row .center {

	margin-left:33%;
	margin-right:33%;
		-moz-border-radius: 10px;
	border-radius: 10px;
	border:1px solid #cccccc;
	-webkit-box-shadow: 2px 5px 5px #616161;
	-moz-box-shadow: 2px 5px 5px #616161;
	box-shadow: 2px 5px 5px #616161;
}


.row .right {

	width:32%;
	float:right;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border:1px solid #cccccc;
	-webkit-box-shadow: 2px 5px 5px #616161;
	-moz-box-shadow: 2px 5px 5px #616161;
	box-shadow: 2px 5px 5px #616161;
}

.row .inner {

	padding:5px;

}

.row-header {
	
	padding:5px;
	text-indent:3px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	font-weight:bold;
	font-size:140%;
	text-shadow: 1px 4px 4px #595959;
	filter: dropshadow(color=#595959, offx=1, offy=4);
	color:white;
	background-color:#5f6d7d;
	margin-bottom:5px;
	
}

.row ul {

	margin-left:30px;

}
#dailyops-dash {

	width:99%;
	margin:auto;
	margin-top:20px;
	-moz-border-radius: 10px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	border:1px solid #cccccc;
	-webkit-box-shadow: 2px 5px 5px #616161;
	-moz-box-shadow: 2px 5px 5px #616161;
	box-shadow: 2px 5px 5px #616161;
}

#dailyops-dash .inner {
	
	padding:5px;

}

#dailyops-dash ul {

	margin:0px;
	padding:0px;
	list-style:none;
}

#dailyops-dash .index ul {

	font-style:italic;

}

.uri {
	
	font-size:75%;

}
#dailyops-dash .left {
	
	float:right;
	width:19%;

}

#dailyops-dash .right {

	float:left;
	width:80%;

}

#FilterDay,#FilterSection {

	width:100%;

}

.post-row-over td {

	background-color:#e4ffe1;

}

#panel .left {

	float:left;
	width:49%;

}

#panel .right {

	float:right;
	width:49%;

}

#panel ul {


	padding:0px;
	margin:0px;
	margin:10px;
	margin-left:30px;
}

#panel h2 {
	
	margin-top:10px;
	margin-bottom:5px;
	text-indent:3px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	font-weight:bold;
	font-size:140%;
	text-shadow: 1px 4px 4px #595959;
	filter: dropshadow(color=#595959, offx=1, offy=4);
	color:white;
	background-color:#5f6d7d;
}

</style>

<?php 

	echo $this->element("dashboard/tab-nav");

?>
<div>
<?php //pr($approvedTransStats); ?>
</div>
<div id='dailyops-dash'>
	<div class='inner'>
		<div class='row-header'>
			DailyOps Overview
		</div>
		<div class='index'>
		<div class='left'>
			<div class='form'>
					<table cellspacing='0'>
						
						<tr>
							<th>Filter Date</th>
						</tr>
						<tr>
							<td width='1%' algin='center'>
							<ul>
								<li><a href='' rel='reset-post-filters' >Reset Filters</a></li>
								</ul>
								<?php 
							
									$days = array();
									
									foreach($upcoming_posts as $key=>$post) {
										$t = strtotime($post['Dailyop']['publish_date']);
										$days[date("Y-m-d",$t)] = date("D, M d, Y",$t);
										$upcoming_posts[$key]['Dailyop']['Date'] = date("Y-m-d",$t);
									}
									
									foreach($days as $k=>$v) {
										
										$count = Set::extract("/Dailyop[Date={$k}]",$upcoming_posts);
										
										$days[$k] .= " (".count($count).")";
										
									}
									
									echo $this->Form->input("FilterDay",array("options"=>$days,"size"=>count($days),"label"=>false));
												
								?>
								<ul>
								<li><a href='' rel='reset-post-filters' >Reset Filters</a></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>Filter Section</th>
						</tr>
						<tr>
							<td width='1%' algin='center'>
								<ul>
								<li><a href='' rel='reset-post-filters' >Reset Filters</a></li>
								</ul>
								<?php 
									$sec = array();
									
									foreach($upcoming_posts as $post) $sec[$post['Dailyop']['dailyop_section_id']] = $post['DailyopSection']['name']; 
									
									asort($sec);
									
									foreach($sec as $k=>$v) { 
										
										$count = Set::extract("/Dailyop[dailyop_section_id=".$k."]",$upcoming_posts);
										
										$sec[$k] .= " (".count($count).")";
										
									}
									
									echo $this->Form->input("FilterSection",array("options"=>$sec,"size"=>count($sec),"label"=>false));
											
								?>	
								<ul>
								<li><a href='' rel='reset-post-filters' >Reset Filters</a></li>
								</ul>
							</td>
						</tr>
						<tr>
							<th>Links</th>
						</tr>
						<tr>
							<td width='20%' class='actions'>
								<ul>
									
									<li><a href='/dailyops/add' >Add Post</a></li>
									<li><a href='/dailyops/' >View All Posts / Search Posts</a></li>
									<li><a href='/media_files/add_video' >Upload Video</a></li>
									<li><a href='/media_files/add_images' >Upload Images</a></li>
								</ul>
							</td>
						</tr>
					</table>
					</div>
		</div>
		<div class='right'>
		<table cellspacing='0'>
						<tr>
							<th>Status</th>
							<th>Publish Date</th>
							<th>Title & Sub Title</th>
							<th>Section</th>
							<th>Theme</th>
							<th>Actions</th>
						</tr>
						<?php 
						
							foreach($upcoming_posts as $post):
							$d = $post['Dailyop'];
							$s = $post['DailyopSection'];
						?>
						
							<tr class='post-row' date='<?php echo date("Y-m-d",strtotime($d['publish_date'])); ?>' section_id='<?php echo $d['dailyop_section_id']; ?>'>
								<td>
									<?php 
										
									
										if(!empty($post['Validate']['msg'])) {
											
											echo $post['Validate']['msg'];
											
										} else {
										
											echo "<div style='color:green; text-align:center; font-size:110%; font-weight:bold;'>:^)</div>";
											
										}
										
									
										
									
									?>
								</td>
								<td><?php echo date("D",strtotime($d['publish_date'])); ?>, <?php echo date("M dS,Y [H:i:s]",strtotime($d['publish_date'])); //$this->Time->niceShort($d['publish_date'])?></td>
								<td>
									<?php 
									
										echo $d['name'];
										
										if(!empty($d['sub_title'])) { 
											
											echo " - ".$d['sub_title'];
											
										}
									
									?>
									<br />
									<span class='uri'><?php echo $s['uri']; ?>/<?php echo $d['uri']?> <em><a href='http://dev.theberrics.com/<?php echo $s['uri']; ?>/<?php echo $d['uri']?>' target='_blank'>(VIEW ON DEV)</a></em></span>
								</td>
								<td align='center'><?php echo $s['name']; ?></td>
								<td align='center'><?php echo $d['theme_override']; ?></td>
								<td class='actions'>
									<a href='/dailyops/edit/<?php echo $d['id']; ?>/<?php echo base64_encode("/dashboard/"); ?>'>Edit</a>
								</td>
							</tr>
						
						<?php 
						
							endforeach;
						
						?>
					</table>
		</div>	
					
		</div>
		
		<div style='clear:both;'></div>
	</div>
</div>