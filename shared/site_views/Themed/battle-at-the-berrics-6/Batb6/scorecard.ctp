<?php 



?>
<div id='scorecard'>
<div class="top-header clearfix">
	<div class='top-dc-flag'>
		<img src="/theme/battle-at-the-berrics-6/img/dc-top-flag.jpg" alt="DC Shoes" />
	</div>
	<div class="top-banner">
		<script type="text/javascript">
		  var ord = window.ord || Math.floor(Math.random() * 1e16);
		  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops_lo;sz=728x90;ord=' + ord + '?"><\/script>');
		</script>
		
	</div>
	<div class="top-lrg-logo">
		<img src="/theme/battle-at-the-berrics-6/img/lrg-top-logo.png" alt="LRG Clothing" />
	</div>
</div>
<div class="main-logo">
	<a href='/battle-at-the-berrics-6'><img src="/theme/battle-at-the-berrics-6/img/batb6-top-logo.png" alt="" /></a>
</div>
	<div class='card-heading clearfix'>
		<a href='/battle-at-the-berrics-6'>
			<img src="/img/v3/layout/px.png" width='100%' height='180' style='height:180px; width:100%;' border='0' alt="" />
		</a>
		<div class='profile'>
			<div class='name'>
				<a href='http://facebook.com/profile.php?id=<?php echo $profile['User']['facebook_account_num']; ?>' target='_blank'><?php echo strtoupper($profile['User']['first_name']." ".$profile['User']['last_name']); ?><span style='font-size:14px;'>(#<?php echo $score_total['BatbScore']['rank_number']; ?>)</span></a>
			</div>
			<div class="social-networking">
				<div class="fb-like" data-href="<?php echo urlencode("http://theberrics.com".$this->here); ?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="true" style=''></div>
				<div class='twitter'>
						<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://theberrics.com".$this->here; ?>" data-text='Battle At The Berrics 6 Scorecard: <?php echo $profile['User']['first_name']." ".$profile['User']['last_name']; ?>' data-count="none" data-via="berrics">Tweet</a>
				</div> 
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
					<td colspan='2' style='border:none; text-align:right; font-size:24px; '><strong>Grand Total:</strong> <?php echo ($score_total['BatbScore']['rps_score']+$score_total['BatbScore']['match_score']+$score_total['BatbScore']['letters_score']); ?></td>
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
	
		<?php foreach($votes as $v): if(in_array($v['BatbMatch']['id'],array(505,506))) continue; ?>
			<?php 
				$p1 = $v['BatbMatch']['Player1User'];
				$p2 = $v['BatbMatch']['Player2User'];
				$cls = "team-berra-card";
				
				if($v['BatbMatch']['bracket_num'] == 5 && $v['BatbMatch']['match_num'] > 8) $cls = "team-koston-card";
				if($v['BatbMatch']['bracket_num'] == 4 && $v['BatbMatch']['match_num'] > 4) $cls = "team-koston-card";
				if($v['BatbMatch']['bracket_num'] == 3 && $v['BatbMatch']['match_num'] > 2) $cls = "team-koston-card";
				
				$letters_drop = BatbMatch::winningLettersDrop();
				
			?>
			<div class='battle-card <?php echo $cls; ?>'>
				<div class='inner'>
					<table cellspacing='0'>
						<thead>
							<tr>
								<td width='28%'>BATTLE</td>
								<td width='20%' style='font-weight:bold;'>RO SHAM BO</td>
								<td width='20%' style='font-weight:bold;'>WINNER</td>
								<td width='20%' style='font-weight:bold;'>LETTERS</td>
								<td width='12%' style='font-weight:bold;'>POINTS</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td style='font-weight:bold;'><?php echo strtoupper($p1['first_name']." ".$p1['last_name']); ?></td>
								<td>
									<?php 
									
										switch($v['BatbVote']['rps_winner_user_id']) {
											
											case $p1['id']:
												echo "X";
											break;
											
										}	
									
									?>
								</td>
								<td>
								<?php 
									
										switch($v['BatbVote']['match_winner_user_id']) {
											
											case $p1['id']:
												echo "X";
											break;
											
										}	
									
									?>
								</td>
								<td>
								<?php 
									if($v['BatbVote']['match_winner_user_id'] == $p1['id']) echo $letters_drop[$v['BatbVote']['winner_letters']];
								?>
								</td>
								<td rowspan='2' class='points-cell' valign="middle">
								<?php 
								
								if(empty($v['BatbMatch']['match_winner_user_id'])) {
									
									echo "<span style='font-size:14px;'>PENDING</style>";
									
								} else {
									
									$points = 0;
									if($v['BatbVote']['rps_winner_user_id'] == $v['BatbMatch']['rps_winner_user_id']) $points += 1;
									if($v['BatbVote']['match_winner_user_id'] == $v['BatbMatch']['match_winner_user_id']) $points += 10;
									if($v['BatbVote']['winner_letters'] == $v['BatbMatch']['winner_letters'] && $points >= 10) $points += 15;
									echo $v['BatbVote']['total_points'];
									
								}
									
								
								?>
								</td>
							</tr>
							<tr>
								<td>VS</td>
								<td></td>
								<td></td>
								<td></td>
								
							</tr>
							<tr>
								<td style='font-weight:bold;'><?php echo strtoupper($p2['first_name']." ".$p2['last_name']); ?></td>
								<td>
								<?php 
								
									switch($v['BatbVote']['rps_winner_user_id']) {
										
										case $p2['id']:
											echo "X";
										break;
										
									}	
									
								?>
								</td>
								<td>
								<?php 
									
										switch($v['BatbVote']['match_winner_user_id']) {
											
											case $p2['id']:
												echo "X";
											break;
											
										}	
									
									?>
								</td>
								<td>
								<?php 
									if($v['BatbVote']['match_winner_user_id'] == $p2['id']) echo $letters_drop[$v['BatbMatch']['winner_letters']];
								?>
								</td>
								<td></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
		<?php endforeach; ?>
	</div>
	<div style='clear:both;'></div>
</div>
