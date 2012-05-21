<div class='address-div'>
					<table cellspacing='0'>
						<tr>
							<td>Address Type</td>
							<td><?php echo strtoupper($address['address_type']); ?></td>
						</tr>
						<tr>
							<td>First Name</td>
							<td><?php echo $address['first_name']; ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $address['last_name']; ?></td>
						</tr>
						<tr>
							<td>Street</td>
							<td><?php echo $address['street']; ?></td>
						</tr>
						<tr>
							<td>Apt</td>
							<td><?php echo $address['apt']; ?></td>
						</tr>
						<tr>
							<td>City</td>
							<td><?php echo $address['city']; ?></td>
						</tr>
						<tr>
							<td>State/Province</td>
							<td><?php echo $address['state']; ?></td>
						</tr>
						<tr>
							<td>Postal</td>
							<td><?php echo $address['postal_code']; ?></td>
						</tr>
						<tr>
							<td>Country Code</td>
							<td><?php echo $address['country_code']; ?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td><?php echo $address['phone']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $address['email']; ?></td>
						</tr>
						<tr>
							<td>ID</td>
							<td><?php echo $address['id']; ?></td>
						</tr>
						<tr>
							<td colspan='2' class='actions'>
								<a href='/user_addresses/edit/<?php echo $address['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Edit</a>
								<a href='http://maps.google.com?q=<?php echo urlencode($address['street']." ".$address['apt']." ".$address['city']." ".$address['state']." ".$address['postal_code']." ".$address['country_code']); ?>' target='_blank'>Google Maps</a>
							</td>
						</tr>
					</table>
</div>