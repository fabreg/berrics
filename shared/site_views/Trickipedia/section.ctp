<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		$("#trick_select").bind('change',function() { 

			var uri = $(this).val();

			document.location.href = uri;

			return;

		});


	});
	
</script>
<?php 

//get the trick
$trick = Set::extract("/Meta[key=/trick/i]/val",$post);
// get by who
$who = Set::extract("/Tag/User",$post);
foreach($who as $k=>$v) if(count($v['User'])<=0) unset($who[$k]);
$who = array_values($who);
//page title

$t = "The Berrics - Trickipedia - ";

$t .= strtoupper($trick[0]);

$t .= " By: ".strtoupper($who[0]['User']['first_name']." ".$who[0]['User']['last_name']);

$this->set("title_for_layout",$t);

//meta and descrip

$meta_k = Array();

foreach($post['Tag'] as $t) {

	$meta_k[] = $t['name'];

}

$meta_k = implode(",",$meta_k);

$meta_d = strip_tags($post['Dailyop']['text_content']);

$this->set(compact("meta_k","meta_d"));

unset($t,$trick,$who,$meta_k,$meta_d);


?>
<div id="trickipedia">
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
	</div>
	<div id="select-menu">
		<?php echo $this->Form->input("trick_select",array("options"=>$trick_menu)) ?>
	</div>
	<div id="posts" class='clearfix'>
		<?php 
			foreach ($posts as $k => $v): 

				$user = Set::extract("/Tag/User",$v);
				$trick = Set::extract("/Meta[key=/trick/i]/val",$v);
				$img = $v['DailyopMediaItem'][1]['MediaFile'];
				$link = "/trickipedia/".$v['Dailyop']['uri'];

		?>
			<div class="trick-div clearfix">
				<div class="img">
					<a href="<?php echo $link; ?>">
					<img src='http://img.theberrics.com/i.php?src=/loading-imgs/loading-700.jpg&amp;h=60&amp;w=60&amp;zc=1' data-original="http://img.theberrics.com/i.php?src=/images/<?php echo $img['file']; ?>&amp;w=60&amp;h=60&amp;zc=1" alt="" class='lazy' />
					</a>
				</div>
				<div class="info">
					<div class="trick">
						<a href="<?php echo $link; ?>"><?php echo strtoupper($trick[0]); ?></a>
					</div>
					<div class="name">
						<a href="<?php echo $link; ?>"><?php echo strtoupper($user[0]['User']['first_name']); ?> <?php echo strtoupper($user[0]['User']['last_name']); ?></a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>