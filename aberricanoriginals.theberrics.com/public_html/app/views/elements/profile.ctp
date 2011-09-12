<?php

	$u = $this->Session->read("Auth.User");


?>
<div id='profile'>

	<table cellspacing='0'>
	<tr>
		<td width='50' class='label'>Name:</td>
		<td><?php echo $u['first_name']; ?> <?php echo $u['last_name']; ?></td>
	</tr>
	<tr>
		<td  class='label'>Email:</td>
		<td><?php echo $u['email']; ?></td>
	</tr>
	</table>
	
</div>