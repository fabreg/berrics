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
		</div>
		
		<div class='members'></div>
		<div class='uploads'></div>
	</div>

</div>