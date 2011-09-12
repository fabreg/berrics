<?php 

$this->Html->css("place_vote","stylesheet",array("inline"=>false));
$this->Html->script("voting/place_vote",array("inline"=>false));

?>
<?php 

echo $this->Form->create("BatbVote",array("url"=>$_SERVER['REQUEST_URI']));

?>	
	<div class='battle-prediction-rules'>
		<p>- Place your predictions on the two upcoming battles listed below.</p>
		<p>- Your prediction will be saved and your score will be calculated at the end of each battle.</p>
		<p>- Scoring is as follows:</p>
		<ul>
			<li>RO-SHAM-BO = <span class='points'>1 Point</span></li>
			<li>WINNER = <span class='points'>10 Points</span></li>
			<li>FINAL LETTERS = <span class='points'>15 Points</span></li>
		</ul>
		<p>- Whomever has the highest weekend score for round one battles will win a $50  Gift Certificate from LRG.</p>
		<p>- Whomever has the most points at the end of BATB IV will win a year's supply of DC Shoes, a $500 LRG Gift Certificate and a trip to BATB V finals night.</p>
		<p>- In the case of a tie, first place names will be entered and a winner will be randomly selected.</p>
	</div>
<?php 

echo $this->element("place-vote-form",array("match"=>$featured1,"featured_num"=>1));
?>
<hr style='border:5px solid black;' />
<?php 
echo $this->element("place-vote-form",array("match"=>$featured2,"featured_num"=>2));

?>
<?php 

echo $this->Form->input("batb_event_id",array("type"=>"hidden","value"=>$event['BatbEvent']['id']));
echo $this->Form->end("Submit your prediction");

?>
<?php

pr($match);


?>