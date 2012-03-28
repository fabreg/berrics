<?php 

$this->Html->script(array("jquery.cookie.js","section"),array("inline"=>false));

?>
<div id='sls-voting-section'>
	<div class='inner'>
		<div class='voting-heading'></div>
		<div class='vote-section'>
			<div class='entries'>
				<div>
					<img border='0' src='/theme/sls-voting/img/selection-heading.png' />
				</div>
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
					<div style='text-align:center;'>
						<img border='0' src='/theme/sls-voting/img/rules-heading.jpg' />
					</div>
					<div class='inner'>
						Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah Rules Blah Blah 
					</div>
				</div>
				<div class='voting-form'>
				
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
</div>
<?php 
print_r($entries);
?>