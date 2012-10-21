<style>
.left {

	width:48%;
	float:left;

}

.posse td:nth-child(odd) {

	text-align:right;
	font-weight:bold;
	width:200px;
}
.members {
	
	margin-top:10px;

}
.uploads {

	width:98%;
	margin:auto;

}
</style>
<div class='index'>
	<h2>Younited Nations Entry</h2>
	<div>
		<div class='left'>
			<div class='posse'>
				<h3>Crew</h3>
				<table cellspacing='0'>
					<tr>
						<td>Name</td>
						<td><?php echo $entry['YounitedNationsPosse']['name']; ?></td>
					</tr>
					<tr>
						<td>Created/Modified</td>
						<td><?php echo $this->Time->niceShort($entry['YounitedNationsPosse']['created']); ?>/<?php echo $this->Time->niceShort($entry['YounitedNationsPosse']['modified']); ?></td>
					</tr>
					<tr>
						<td>Country</td>
						<td><?php echo $entry['YounitedNationsPosse']['country']; ?></td>
					</tr>
					<tr>
						<td>Geo Formatted</td>
						<td><?php echo $entry['YounitedNationsPosse']['geo_formatted']; ?></td>
					</tr>
					<tr>
						<td>Latitude</td>
						<td><?php echo $entry['YounitedNationsPosse']['geo_latitude']; ?></td>
					</tr>
					<tr>
						<td>Longitude</td>
						<td><?php echo $entry['YounitedNationsPosse']['geo_longitude']; ?></td>
					</tr>
					<tr>
						<td>Phone #</td>
						<td><?php echo $entry['YounitedNationsPosse']['phone_number']; ?></td>
					</tr>
					<tr>
						<td>User</td>
						<td><?php echo $entry['YounitedNationsPosse']['User']['first_name']; ?> <?php echo $entry['YounitedNationsPosse']['User']['last_name']; ?> (<?php echo $entry['YounitedNationsPosse']['User']['email']; ?>) <a target='_blank' href='http://facebook.com/profile.php?id=<?php echo $entry['YounitedNationsPosse']['User']['facebook_account_num']; ?>'>Facebook</a></td>
					</tr>
				</table>
			</div>
			<div class='members'>
				<table cellspacing='0'>
					<tr>
						<th>Name</th>
						<th>Age</th>
						<th>Affiliation</th>
					</tr>
					<?php foreach($entry['YounitedNationsPosse']['YounitedNationsPosseMember'] as $m): ?>
					<tr>
						<td>
							<?php echo $m['name']; ?>
						</td>
						<td align='center'>
							<?php echo $m['age']; ?>
						</td>
						<td>
							<?php 
							
								echo ($m['skater']) ? "[Skater]":"";
								echo ($m['filmer']) ? "[Filmer]":"";
								echo ($m['editor']) ? "[Editor]":"";
								
							?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
		
		
		<div class='uploads'></div>
	</div>
	<div style='clear:both;'></div>
		<div class='form'>
		<fieldset>
			<legend>Edit Entry</legend>
			<?php 
			
				echo $this->Form->create("YounitedNationsEventEntry",array("url"=>$this->here));
				echo $this->Form->input("id",array("value"=>$entry['YounitedNationsEventEntry']['id']));
				echo $this->Form->input("finalist");
				echo $this->Form->input("entry_dailyop_id",array("options"=>$posts));
				echo $this->Form->end("Update");
			
			?>
		</fieldset>
	</div>
</div>