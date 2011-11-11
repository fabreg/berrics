<?php

//title for the page
$title_for_layout = "The Berrics - Headquarters";

//layout file
///un-comment the line below to use a blank layout template;
//$this->layout = "blank";

//meta keywords
$meta_k = '';

//meta description
$meta_d = '';

$this->set(compact("title_for_layout","meta_k","meta_d"));

$this->Html->css('headquarters','stylesheet',array("inline"=>false));

?>
<?php 

$this->Html->scriptStart(array("inline"=>false));

?>
$(document).ready(function() { 



	$("div[email]").css({"cursor":"pointer"}).click(function() { 

		document.location.href = "mailto:"+$(this).attr("email")+"@theberrics.com";

	});

	
});

<?php 

$this->Html->scriptEnd();

?>
</script>
<div>
<img src="/img/layout/headquarters/headquarters.jpg"/>
</div>
<div id='list' style="line-height:0px;">
	<div><img src="/img/layout/headquarters/headquarters_02.png"/></div>
	<div email='steveberra'><img src="/img/layout/headquarters/headquarters_03.png"/></div>
	<div email='erickoston'><img src="/img/layout/headquarters/headquarters_04.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_05.png"/></div>
	<div email='joel'><img src="/img/layout/headquarters/headquarters_06.png"/></div>
	<div email='lindsay'><img src="/img/layout/headquarters/headquarters_07.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_08.png"/></div>
	<div email='prince'><img src="/img/layout/headquarters/headquarters_09.png"/></div>
	<div email='greg'><img src="/img/layout/headquarters/headquarters_10.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_11.png"/></div>
	<div email='info'><img src="/img/layout/headquarters/headquarters_12.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_13.png"/></div>
	<div email='ryan'><img src="/img/layout/headquarters/headquarters_14.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_16.png"/></div>
	<div email='advertising'><img src="/img/layout/headquarters/headquarters_17.png"/></div>
	<div email='kevin'><img src="/img/layout/headquarters/headquarters_18.png"/></div>
	<div email='tim'><img src="/img/layout/headquarters/headquarters_19.png"/></div>
	<div email='trickipedia'><img src="/img/layout/headquarters/headquarters_20.png"/></div>

	<div><img src="/img/layout/headquarters/headquarters_23.png"/></div>
	<div email='chase'><img src="/img/layout/headquarters/headquarters_24.png"/></div>
	<div email='colin'><img src="/img/layout/headquarters/headquarters_25.png"/></div>
	<div email='duarte'><img src="/img/layout/headquarters/headquarters_26.png"/></div>
	<div email='zach'><img src="/img/layout/headquarters/headquarters_27.png"/></div>
	<div email='brock'><img src="/img/layout/headquarters/headquarters_28.png"/></div>
	<div email='grant'><img src="/img/layout/headquarters/headquarters_29.png"/></div>
	<div email='chris'><img src="/img/layout/headquarters/headquarters_30.png"/></div>
	<div><img src="/img/layout/headquarters/headquarters_31.png"/></div>
	<div email='danny'><img src="/img/layout/headquarters/headquarters_32.png"/></div>
	<div email='matt'><img src="/img/layout/headquarters/headquarters_33.png"/></div>
	<div email='kbrown'><img src="/img/layout/headquarters/headquarters_34.png"/></div>
	<div email='vince'><img src="/img/layout/headquarters/headquarters_36.png"/></div>
</div>
