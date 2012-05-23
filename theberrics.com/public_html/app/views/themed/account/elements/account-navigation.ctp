<div class='account-nav-bit'>
	<ul>
		<li>
			<a href='/account/canteen'>The Canteen</a>
			<?php if(preg_match('/(\/account\/canteen)/',$_SERVER['REQUEST_URI'])): ?>
			<ul>
				<li>
					<a href='/account/canteen'>Order History</a>
				</li>
			</ul>
			<?php endif; ?>
		</li>
	</ul>
</div>