<!DOCTYPE html>
<html>
<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->element("layout/admin-head-includes");
		echo $scripts_for_layout;
	?>
<script>
$(document).ready(function() { 

//$(document).off('touchstart.dropdown.data-api');

});
</script>
</head>
<body>
	<div class='navbar navbar-fixed-top'>
		<div class='navbar-inner'>
			<div class='container-fluid'>
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </a>
		      <a class="brand" href="/">TheBerrics</a>
		     <div class='btn-group pull-right dropdown'>
		     	<?php 
		     		$usr_txt = "Login";
		     		
		     		if(CakeSession::check("Auth.User.id")) $usr_txt = substr(CakeSession::read("Auth.User.first_name"), 0,1).".".CakeSession::read("Auth.User.last_name");
		     	?>
		     	<button class='btn' data-toggle='dropdown'><i class='icon icon-user'></i> <?php echo $usr_txt; ?> <b class='caret'></b></button>
		      	<ul class='dropdown-menu'>
		      	<?php if(!CakeSession::check('Auth.User.id')): ?>
			      	<li>
			      		<a href='<?php echo $this->Html->url(array("plugin"=>"identity","controller"=>"login","action"=>"index")); ?>'>
			      			Login
			      		</a>
			      	</li>
		      	<?php else: ?>
		      		<li>
		      			<a href='<?php echo $this->Html->url(array("controller"=>"dailyops","action"=>"assigned")); ?>'>
		      				<i class='icon icon-tasks'></i> Assigned Posts
		      			</a>
		      		</li>
		      		<li class="divider"></li>
		      		<li><a href='/identity/login/logout/<?php echo base64_encode($this->here); ?>'><i class='icon icon-remove-circle'></i> Logout</a></li>
		      	<?php endif; ?>
		      	</ul>
		      	
		      </div>
		      <div class='nav-collapse collapse navbar-responsive-collapse'>
		      	<?php echo $this->element("top-nav/top-nav"); ?>
		      </div>
		       
			</div>
		</div>
	</div>
	<div class='container-fluid'>
		<div class='row-fluid'>
			<div class='span12'>
				<?php echo $this->Session->flash(); ?>

				<?php echo $content_for_layout; ?>
			</div>
		</div>
	</div>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
