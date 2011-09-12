<style>

#batb-list {

	list-style:none;
	margin:0px;
	padding:0px;

}

#batb-list li {

	float:left;
	height:313px;
	width:350px;
	background-image:url(/img/layout/batb/batb-tile-bg.jpg);
	background-repeat:no-repeat;
	cursor:pointer;
	margin-left:3px;
	margin-bottom:10px;

}

#batb-list li span {

	display:none;

}

#batb-list li .inner {

	text-align:center;
	height:100%;
	margin:auto;
}

</style>
<script>
$(document).ready(function() { 


	$("#batb-list li").hover(

		function() { 

			$(this).find("img").css({"opacity":.5});
			
		},
		function() { 

			$(this).find("img").css({"opacity":1});
			
		}

	).click(function() { 


		var ref = $(this).find("a").attr("href");

		document.location.href = ref;
		
	}).find("img").css({"padding-top":"60px"});

	$("#batb-list li img:eq(1)").css({"padding-top":"30px"})
	
});
</script>
<ul id='batb-list'>
	<li>
		<div class='inner'><a href='/younited-nations-2' title='YOUnited Nations 2'><span>YOUnited Nations 2</span><img src='/img/layout/younited-nations/younited-nations2.jpg'  border='0' /></a></div>
	</li> 
	<li>
		<div class='inner'><a href='/younited-nations' title='YOUnited Nations'><span>YOUnited Nations</span><img style="margin-top:29px;" src='/img/layout/younited-nations/younited-nations.jpg' border='0' /></a></div>
	</li>
</ul>