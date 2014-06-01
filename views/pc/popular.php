<div class="main">
	<div class="container">
		<div class="row">
			<div class="pricing-plans plan-style2 span12">
				<div class="row">
					<div class="title span12">
						<h1>Hot Searches</h1>
					</div>
				</div>
				<?php for($j = 0; $j < 3; $j++) : ?>
				<div class="plan-container border-rd4">
					<div class="plan-header">
						<h2 class="plan-title bg-title">Straigth</h2>
					</div>
					<!-- end plan-header -->
					<div class="plan-content">
						<ul>
						<?php for($i = 0; $i < 10;) : ?>
						    <li><?=++$i?>. <a href="/big-dick"><b>straight keyword</b></a></li>
						<?php endfor; ?>
						</ul>
					</div>
				</div><!-- plan-container -->
				<?php endfor; ?>
			</div><!-- end pricing-plans -->

		</div><!-- row -->
	</div><!-- end container -->
</div><!-- end main -->