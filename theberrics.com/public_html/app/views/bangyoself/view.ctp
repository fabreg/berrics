<?php 

$this->set("right_column","");

?>
<style>
/*
OVERRIDE THE LAYOUT
*/

body {

	background-image:url(/img/layout/by3/body-bg.jpg);

}

#left-col {

	width:895px;
	margin:auto;
	background-color:black;
	float:none;
	padding-top:5px;
}
#bang-yoself {

	width:885px;
	margin:auto;
	background-image:url(/img/layout/by3/bg.jpg);
	min-height:500px;
	padding-bottom:35px;
	border-bottom:solid 4px black;
}

#bang-yoself img {

	padding:0px;
	margin:0px;
	border:none;
	display:block;
}

#bang-yoself .left {

	float:left;
	width:501px;
	
}

#bang-yoself .right {

	float:right;

}
#bang-yoself .entry-form-div {

	background-image:url(/img/layout/by3/slice3.jpg);
	height:186px;
	position:relative;
}

#bang-yoself .entry-form {

	width:400px;
	margin-left:80px;
	padding-top:120px;
}

#bang-yoself .entry-form-info {

	float:left;
	width:250px;
	position:relative;
	height:150px;
	background-image:url(/img/layout/by3/name-email.png);
	background-repeat:no-repeat;
	
	
}

#bang-yoself .entry-form-info ul {

	list-style:none;
	padding:0px;
	margin:0px;
	color:black;
	font-size:16px;
	
}

#bang-yoself .entry-form-info .first-name {

	position:absolute;
	top:-8px;
	left:56px;
	
}

#bang-yoself .entry-form-info .last-name {

	position:absolute;
	top:14px;
	left:56px;
	
}


#bang-yoself #video-upload {

	float:right;
	width:146px;
	
}


#bang-yoself .login {

	position:relative;
	

}


#bang-yoself .login .button {

	position:absolute;
	top:120px;
	left:150px;
	
}

#video-upload-progress {

	font-size:11px;
	color:black;
	font-weight:bold;

}

#bang-yoself #assets {

	background-image:url(/img/layout/by3/slice5.jpg);
	background-repeat:no-repeat;
	height:114px;
	width:383px;
	position:relative;
	
}

#assets .starter {

	position:absolute;
	width:133px;
	height:80px;
	top:24px;
	left:18px;	
}

#assets .ender {

	position:absolute;
	width:135px;
	height:80px;
	
	top:24px;
	right:80px;

}


#bang-yoself .confirmation {

	position:absolute;
	top:115px;
	left:100px;
	width:350px;
	text-align:center;
	color:black;

}

#top-banner {

	margin-left:150px;
		
}

</style>
<div id='bang-yoself'>
	<div class='left'>
		<img src='/img/layout/by3/slice1.jpg' alt='LRG Presents: Bang Yoself! 3' border='0' style='clear:both;' />
		<img src='/img/layout/by3/slice2.jpg' alt='' border='0' style='clear:both;' />
		<div class='entry-form-div'>
			<?php 
			
			if(time()<strtotime("2011-09-06 02:00:00")) {
				
				
						if($this->Session->check("Auth.User")) {
							
							if($entry_check) {
								
								echo $this->element("bangyoself/confirmation");
								
							} else {
								
								echo $this->element("bangyoself/entry-form");
								
							}
							
						} else {
							
							echo $this->element("bangyoself/login");
							
						}
	
				
			} else {
				
				
				echo "<div style='text-align:center; padding-top:110px; padding-left:15px; color:black;'>Closed!</div>";
				
			}
			
	
	?>
		</div>
	</div>
	<div class='right'>
		<img src='/img/layout/by3/slice4.jpg' alt='' border='0' />
		<div id='assets'>
			<div class='starter'>
				<a href='/widgets/video_slate_generator' target='_blank'><img src='/img/layout/clear.png' height='100%' width='100%' /></a>
			</div>
			<div class='ender'>
			
			<a href='/img/layout/by3/BANGIN-PNG.png' target='_blank'><img src='/img/layout/clear.png' height='100%' width='100%' /></a>
			</div>
		</div>
		<div style='padding-left:13px; padding-top:15px;'>
			<script type="text/javascript">
  var ord = window.ord || Math.floor(Math.random() * 1e16);
  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/BY3;sz=300x250;ord=' + ord + '?"><\/script>');
</script>
<noscript>
<a href="http://ad.doubleclick.net/N5885/jump/BY3;sz=300x250;tile=2;ord=[timestamp]?">
<img src="http://ad.doubleclick.net/N5885/ad/BY3;sz=300x250;tile=2;ord=[timestamp]?" width="300" height="250" />
</a>
</noscript>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>
