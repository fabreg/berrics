<?php

$this->set("right_column","");


?>
<style>
body {

	background-image:url(/img/layout/by3/body-bg.jpg);

}

#top-banner-container {


/*display:none;*/
}

#left-col {

	width:100%;
	float:none;

}

#right-col {

	display:none;

}

#bang-yoself-3 {

	width:884px;
	margin:auto;
	border:solid 5px black;
	background-image:url(/img/layout/by3/voting/bg.jpg);
	background-position:center 191px;
	min-height:850px;
}

#bang-yoself-3 .top-header {

	background-image:url(/img/layout/by3/voting/header.jpg);
	height:191px;
	background-repeat:no-repeat;
}

#bang-yoself-3 .video {
	
	
	width:758px;
	background-color:#000;
	margin-left:58px;
}


#bang-yoself-3 .votes {

	margin-top:10px;
	margin-bottom:10px;
	padding-left:16px;
} 
#bang-yoself-3 .votes .finalist {

	float:left;
	margin-left:26px;
	margn-right:26px;
	margin-top:8px;
	margin-bottom:8px;
}



#bang-yoself-3 .footer {

	padding-bottom:30px;

}

#bang-yoself-3 .footer .left {

	width:49%;
	float:left;

}
#bang-yoself-3 .footer .left img {

	margin-left:20px;

}

#bang-yoself-3 .footer .right {
	
	float:right;
	width:340px;
}

#body-container {

	margin-top:-28px;

}

#bang-yoself-3 .d-post-bit,#bang-yoself-3 .d-post-bit .container-top {

	background-color:#000;
	width:758px;
}

#bang-yoself-3 .d-post-bit .display-media {

	margin-left:25px;

}

#bang-yoself-3 .d-post-bit h2 {

	

}

#bang-yoself-3 .d-post-bit .sub-title {

	

}

#bang-yoself-3 .d-post-bit .container, 
#bang-yoself-3 .d-post-bit .container-top,
#bang-yoself-3 .d-post-bit .bottom {

	background-image:none;

}

#bang-yoself-3 .d-post-bit .title {

	margin-top:7px;

}

</style> 
<div id='bang-yoself-3'>
	<div class='top-header'>
		 
	</div> 
	<div class='video-wrapper'>
		<div class='video'>
			<?php if(isset($viewing)): ?>
			
				<?php echo $this->element("dailyops/post-bit",array("dop"=>$viewing)); ?>
			<?php endif;?>
		</div>
	</div>
	<div class='votes'>
		<?php 
			foreach($posts as $post):
				
		?>
		<div class='finalist'>
			<a href='/<?php echo $post['Post']['DailyopSection']['uri']; ?>/<?php echo $post['Post']['Dailyop']['uri']; ?>'>
				<?php 
					
					//get the second media item and show it
					$img = $post['Post']['DailyopMediaItem'][1]['MediaFile']['file'];
				?>
				<img border='0' alt='' src='http://img.theberrics.com/images/<?php echo $img; ?>' />
			</a>
		</div>
		<?php  
				
			endforeach;
		?>
		<div style='clear:both;'></div>
	</div>
	<div class='footer'>
		<div class='left'>
		<img border='0' alt='' src='/img/layout/by3/voting/prize-tile.jpg' />
		</div>
		<div class='right'>
			<script type="text/javascript">
			  var ord = window.ord || Math.floor(Math.random() * 1e16);
			  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/BY3;sz=300x250;ord=' + ord + '?"><\/script>');
			</script>
		</div>
		<div style='clear:both;'></div>
	</div>
</div>

<?php 
if(preg_match('/^(\/dailyops)/',$_SERVER['REQUEST_URI'])):
?>
<div id="dailyops" style='width:790px; margin:auto;'>
<div id='paging-menu'>
<div class='right'>
<a href="/2011/09/16" title="September 15th, 2011"><span>September 16th, 2011</span></a>
</div>
</div>
</div>
<?php 
endif;
?>
