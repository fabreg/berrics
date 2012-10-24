<?php 

$p = $page['SplashPage'];

$this->set(array(

	"title_for_layout"=>"The Berrics ?",
	"meta_k"=>$p['meta_keywords'],
	"meta_d"=>$p['meta_description']

));


$a = array(

	"A pair of Vans Shoes",
	"A pair of Eric Koston 1 Nike SB's",
	"A pair of DC Shoes"

);

$prize = $a[mt_rand(0,2)];

?>
<?php 

echo $p['body_content'];

?>
<div class='enter-the-berrics-link' style='text-align:center; padding:5px; '>
	<a href='/dailyops' style='color:white;'>ENTER THE BERRICS</a>
</div>


<div style='width:740px; margin:auto; padding:1px;margin-top:40px;'>
<div style='padding:10px; text-align:center; color:white; font-size:18px;'>
	Guess what's happening to The Berrics <br />
	Comment below for your chance to win <?php echo $prize; ?>
</div>
<script src=
"http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" 
type="text/javascript"></script>

<fb:comments css="http://theberrics.com/css/fbc.css" href='www.theberrics.com'></fb:comments>

<script type="text/javascript">
	FB.init("4bf16033df99101e2722c24a2d165e82", "http://theberrics.com/xd-receiver.html");
</script>
</div>
<div style='font-size:9px; text-align:right; color:white;'>
	<?php echo php_uname("n"); ?>
</div>
<?php echo $this->element('sql_dump'); ?>