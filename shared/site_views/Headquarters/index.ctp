
<?php 

$eg = User::employeeGroups();

$founders = $groups['founders'];

unset($groups['founders']);

//array_unshift($groups, array("founders"=>$founders));

?>
<div id="headquarters">
	<div class="inner">
		<h1>HEADQUARTERS</h1>
	</div>
	<div class="contact-group">
		<div class="heading">
			<h2>Founders</h2>
		</div>
		<div class="inner">
			<?php foreach ($founders as $k => $user): ?>
				<div class="user-contact">
					<div class="name">
						<?php echo ucfirst($user['User']['first_name']); ?> <?php echo ucfirst($user['User']['last_name']); ?>
					</div>
					<div class="email">
						<a href='mailto:<?php echo $user['User']['berrics_email']; ?>'><?php echo $user['User']['berrics_email']; ?></a>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	</div>
	<?php foreach ($groups as $k => $v): ?>
		<div class="contact-group">
			<div class="heading">
				<h2><?php echo $eg[$k] ?></h2>
			</div>
			<div class="inner">
				<?php foreach ($v as $user): ?>
				<div class="user-contact">
					<div class="name">
						<?php echo ucfirst($user['User']['first_name']); ?> <?php echo ucfirst($user['User']['last_name']); ?>
					</div>
					<div class="email">
						<a href='mailto:<?php echo $user['User']['berrics_email']; ?>'><?php echo $user['User']['berrics_email']; ?></a>
					</div>
				</div>
				<?php endforeach ?>
			</div>
		</div>
	<?php endforeach ?>
</div>
<?php pr($groups) ?>