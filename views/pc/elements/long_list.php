<div class="row">			
			<!-- **************** start All Flie  ****************** -->
			<div class="box-wrapper span10">
				<div class="row">
					<div class="title span10">
						<h3 class="pull-left">Lorem ipsum dolor ...</h3>
						<div class="sort pull-right dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								Most Viewed
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="icon-tag"></i>By Name</a></li>
								<li><a href="#"><i class="icon-list"></i>List</a></li>
								<li><a href="#"><i class="icon-eye-open"></i>View</a></li>
							</ul>
						</div>
					</div><!-- end title -->
				</div>
				<ul class="thumbnails thumbnails-vertical">
					<?php foreach($data['results']['videos'] as $video) : ?>
                                        <li class="span5">
						<div class="thumbnail border-radius-top">
							<div class="bg-thumbnail-img">
								<a class="overlay" href="detail.html">
									<img src="pc/img/icons/play.png">
								</a>
								<img class="border-radius-top" src="<?=$video['@default_thumb']?>">
							</div>
							<div class="thumbnail-content-left">
								<h5><a href="detail.html"><?= $video['title']?> </a></h5>
								<p>
									<!--Lorem ipsum dolor sit amet, consectetur adipisicing elit magna aliqua.-->
								</p>
							</div>
						</div>
						<div class="box border-radius-bottom">
							<p>
								<span class="title_torrent pull-left">Movie</span>
								<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i><?=$video['@views']?></span>
							</p>
						</div>
					</li>
                                        <?php endforeach; ?>					
				</ul>
				<div class="row">
					<div class="span10">
						<div class="navigation pagination pull-right">
							<ul>
								<li><a href="#">←</a></li>
								<li><a class="active" href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">→</a></li>
							</ul>
						</div>
					</div><!-- end navigation -->
				</div>
			</div><!-- end  -->
			<div class="row">
				<div class="list-menu box-wrapper span2">
					<div class="row">
						<div class="title bg-title span2">
							<h3>List menu</h3>
						</div>
					</div>
					<ul class="nav nav-list">
						<li><a href="index.html"><i class="icon-home"></i>Home</a></li>
						<li class="active"><a href="#"><i class="icon-book"></i>Detail</a></li>
						<li><a href="#"><i class="icon-list"></i>List Menu</a></li>
						<li><a href="#"><i class="icon-list-alt"></i>List Alt Menu</a></li>
					</ul>
				</div>
			</div><!-- row -->
			<!-- **************** end All Flie  ****************** -->
		</div><!-- row -->