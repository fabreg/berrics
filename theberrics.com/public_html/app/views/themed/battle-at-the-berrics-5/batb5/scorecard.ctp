<?php 

$this->Html->css(array("scorecard"),"stylesheet",array("inline"=>false));

?>
<div id='scorecard'>
	<div class='main-heading'>
	
	</div>
	<div class='card-heading'>
		<div class='profile'>
			<div class='name'>
				<?php echo strtoupper($profile['User']['first_name']." ".$profile['User']['last_name']); ?>
				
				<div class="fb-like" data-href="<?php echo urlencode("http://theberrics.com".$this->here); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style=''></div>
				<div class='twitter'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$this->here; ?>" data-text='Battle At The Berrics 5 Scorecard: <?php echo $profile['User']['first_name']." ".$profile['User']['last_name']; ?>' data-count="none" data-via="berrics">Tweet</a>
				</div> 
				<div style='clear:both;'></div>
			</div>
			<table cellspacing='0'>
				<tr>
					<td width='1%' nowrap align='right'>Ro-Sham-Bo Total:</td>
					<td class='total'>
						<?php echo $score_total['BatbScore']['rps_score']; ?>
					</td>
				</tr>
				<tr>
					<td width='1%' nowrap align='right'>Battle Winner Total:</td>
					<td class='total'><?php echo $score_total['BatbScore']['match_score']; ?></td>
				</tr>
				<tr>
					<td width='1%' nowrap align='right'>Final Letters Total:</td>
					<td class='total'><?php echo $score_total['BatbScore']['letters_score']; ?></td>
				</tr>
				<tr>
					<td colspan='2' style='border:none;'>Grand Total: <?php echo ($score_total['BatbScore']['rps_score']+$score_total['BatbScore']['match_score']+$score_total['BatbScore']['letters_score']); ?></td>
				</tr>
			</table>
		</div>
		<div class='right-banner'>
			<script type='text/javascript'>
				var ord = window.ord || Math.floor(Math.random() * 1e16);
			  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops;sz=300x250;ord=' + ord + '?"><\/script>');
			</script>
		</div>
		<div style='clear:both;'></div>
	</div>
	
	<div class='votes'>
		<pre><?php print_r($votes); ?></pre>
		
	</div>
	<div style='clear:both;'></div>
</div>