<?php

$this->set("title_for_layout","THE BERRICS - RUN & GUN");

?>

<?php echo $this->Html->script(array("/js/v3/jquery.customSelect.min.js","/js/jquery.form.js"),array("inline"=>false)) ?>
<script>

jQuery(document).ready(function($) {

		$("#score-drop-0").customSelect();
		$("#score-drop-0").bind('change',function() { 

			var $score = $(this).val();
			formatSelectFont();

		});

		$("#score-drop-1").customSelect();
		$("#score-drop-1").bind('change',function() { 

			var $score = $(this).val();
			formatSelectFont();

		});


		formatSelectFont();


		//bind the voting forms
		bootstrapForms();

		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1100px, initial-scale=0"

		});


});	


function bootstrapForms () {
	
	$('.rg-vote-form').ajaxForm({

			beforeSubmit:function(arr, $form, options) {

				
				$($form).find('.submit-btn').hide();
				$($form).find('.loader-gif').show();

				return true;

			},
			"success":function(d,status,$xhr,$form) {

				//alert("Vote Accpeted");
				$($form).find('.submit-btn').show();
				$($form).find('.loader-gif').hide();
				$($form).find('.vote-accepted').fadeIn('normal',function() { 
				//update the scoring row below!
				var $post_id = $($form).find('input[type=hidden][name="data[RgVote][dailyop_id]"]').val();
				var $score = $($form).find('select[name="data[RgVote][score]"]').val();
				setTimeout(function() { 

						$($form).find('.vote-accepted').fadeOut();
						$('.score-col[data-post-id='+$post_id+']').html($score);
					},2500);

				});

				
				

			}


	});
	

}

function formatSelectFont (argument) {
		
		$(".customSelectInner").each(function() { 

			var $score = $(this).text();

			$(this).css({"width":"81px"});

			if($score == 10) {

				$(this).css("letter-spacing","13px");

			} else {

				$(this).css("letter-spacing","3px");

			}


		});

		

}

function formatSelectFont__ ($score,$num) {
	
	console.log("Score Drop formate num:"+$num);

	if($score == 10) {

		$("#score-drop-"+$num+" .customSelectInner").css("letter-spacing","13px");

	} else {

		$("#score-drop-"+$num+" .customSelectInner").css("letter-spacing","3px");

	}

}


</script>
<div id='rg-section'>
	<div class="heading">
		<img src="/theme/run-and-gun/img/heading.jpg" alt="">
	</div>
	<div class="text-content">
		<div class="para">
			<div class="heading">
				The Idea:
			</div>
			<p>
				Each skater gets The Berrics to himself for a 24 hour period to film the best 60 second run he can without knowing anything about what the other skaters have filmed.
			</p>
		</div>
		<div class="para">
			<div class="heading">
				Scoring:
			</div>
			<p>
				The runs are scored by you.  You can change the score you submitted by logging into your account and changing it as you see fit.  Once we close scoring (at the very end) we'll average all the submitted scores together per skater to determine the winner.
			</p>
		</div>
		<div class="para">
			<div class="heading">
				Prizes:
			</div>
			<p>
				The winner takes home $25k and a special Run &amp; Gun clock.
There is also a best trick bonus for $1k for whoever does the best single trick in their run as decided by a Berrics panel.
			</p>
		</div>
		<div style='text-align:center;'>
			<img src='/theme/run-and-gun/img/line-break.jpg' />
		</div>
	</div>
	<?php if (count($post)>0): ?>
		<?php foreach ($post as $k => $v): ?>
			<div class="main-name-img">
					<img src="//img.theberrics.com/images/<?php echo $v['DailyopMediaItem'][3]['MediaFile']['file']; ?>" alt="">
					
			</div>
			<div id="post">
				
				<?php echo $this->element("dailyops/post-bit",array("dop"=>$v,"lazy"=>false)) ?>
				<div class="voting clearfix">
					<div class="copy">
						<img src="/theme/run-and-gun/img/score-copy.png" alt="" />
					</div>
					<div data-post-id='<?php echo $v['Dailyop']['id']; ?>' class="voting-div">
						<?php if (!CakeSession::check("Auth.User.id")): ?>
							<?php echo $this->element("login-btn"); ?>
						<?php else: ?>
							<?php echo $this->element("voting-box",array("post"=>$v,"num"=>$k)); ?>
						<?php endif ?>
					</div>
				</div>
			</div>		
		<?php endforeach ?>		  	 
	<?php endif; ?>
	<div class="entries">
		<?php foreach ($posts as $k => $v): ?>
			<?php echo $this->element("entry-row",array("post"=>$v)) ?>
		<?php endforeach ?>
	</div>
</div>
<pre>
<?php print_r($posts); ?>
</pre>