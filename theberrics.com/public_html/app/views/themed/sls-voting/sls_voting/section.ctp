<?php 

$this->html->script(array("jquery.cookie.js","section"),array("inline"=>false));

?>
<div id='sls-voting-section'>
	<div class='voting-heading'></div>
	<div class='vote-section'>
		<div class='entries'>
			<?php foreach($entries as $v): ?>
			<div class='entry-div'>
				<div class='inner'>
					<div><?php echo $v['SlsEntry']['name']; ?></div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<div class='voting'>
			<div class='rules'>
				Here are the rules.  Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah Blah blah Blah
			</div>
			<div class='voting-form'>
			
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
</div>
<?php 
print_r($entries);
?>