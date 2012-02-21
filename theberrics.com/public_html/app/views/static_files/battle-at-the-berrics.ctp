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
<div style='padding-bottom:5px;'>
	<a href='/battle-at-the-berrics-5'>
		<img border='0' src='/img/layout/batb/batb5-tile.jpg' />
	</a>
</div>
<ul id='batb-list'>
	<li>
		<div class='inner'><a href='/battle-at-the-berrics-4' title='Battle At The Berrics 4: U.S. VS. THEM'><span>Battle At The Berrics 4: U.S. VS. THEM</span><img src='/img/layout/batb/4.jpg' border='0' /></a></div>
	</li>
	<li>
		<div class='inner'><a href='/battle-at-the-berrics-3' title='Battle At The Berrics 3'><span>Battle At The Berrics 3</span><img src='/img/layout/batb/3.jpg'  border='0' /></a></div>
	</li> 
	<li>
		<div class='inner'><a href='/battle-at-the-berrics-2' title='Battle At The Berrics 2'><span>Battle At The Berrics 2</span><img src='/img/layout/batb/2.jpg'  border='0' /></a></div>
	</li>
	<li>
		<div class='inner'><a href='/battle-at-the-berrics-1' title='Battle At The Berrics 1'><span>Battle At The Berrics 1</span><img src='/img/layout/batb/1.jpg' border='0' /></a></div>
	</li>	
</ul>