<?php 

$nums = array();

for($i=1.0;$i<=10;($i = number_format(($i+.1),1))) {

	if($i>=10) $i = 10;

	if($i == 1) $i = "1.0";

	$nums[$i] = $i;

}


?>
<?php 
		if(isset($post['RgVote']['score']) && !empty($post['RgVote']['score'])) {

					$this->request->data['RgVote']['score'] = $post['RgVote']['score'];
					
		}

		echo $this->Form->create('RgVote',array(
						"id"=>'RgVoteForm',
						"url"=>"/run-and-gun/place_vote",
						"class"=>"rg-vote-form"
					)); 

				echo $this->Form->input("dailyop_id",array("type"=>"hidden","value"=>$post['Dailyop']['id']));

				

		?>
<div class="vote-box clearfix">
	<div class="vote-accepted">
		SCORE ACCEPTED!
	</div>
	<table cellspacing='0' cellpadding='0' width='175'>
		<tr>
			<td width='50%' style=''>
				<div class="select-menu">
						<?php echo $this->Form->select("score",$nums,array("id"=>"score-drop-{$num}","empty"=>false)) ?>
				</div>
			</td>
			<td width='50%' style='padding-left:10px;'>
				<div class="submit-btn">
						<button type="submit">
							<img src="/theme/run-and-gun/img/submit-btn.png" alt="">
						</button>
				</div>
				<div class="loader-gif">
					<img src="/img/v3/layout/loader-big.gif" alt="">
				</div>
			</td>
		</tr>
	</table>
</div>
<?php 
unset($this->request->data['RgVote']);
echo $this->Form->end(); 

?>
