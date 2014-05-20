<?php
$tags_text = '';
foreach($data['results']['video_details']['video']['tags']['tag'] as $tag) { 
    $tags_text .= '<a href="/' . str_replace(' ', '+', trim($tag)) . '/1">' . $tag . '</a>, ';
}
$tags_text = strtolower(rtrim($tags_text,', '));

$pornstar_text = '';
foreach($data['results']['video_details']['video']['stars']['star'] as $star) { 
    $pornstar_text .= '<a href="/' . str_replace(' ', '+', trim($star)) . '/1">' . $star . '</a>, ';
}
$pornstar_text = strtolower(rtrim($pornstar_text,', '));

?>
<div class="main">
	<div class="container">
		<div class="row">
			<div class="box-wrapper span9">
				<div class="row">
					<div class="box-content-widget box-video-play span9">
						<div class="row">
							<div class="title bg-title span9">
								<h1><?=$data['results']['video_details']['video']['title']?></h1>
							</div>
						</div>
						<div class="widget">
							<div class="widget-content">
								<div class="video-play">
									<a href="#"><?= $data['results']['decoded_embed'] ?><!--img src="/pc/img/video.jpg"--></a>
								</div>
                                                                <div class="pull-left">
                                                                    <ul>
                                                                        <li>Duration: <?=$data['results']['video_details']['video']['@duration']?></li>
                                                                        <li>Views: <?=$data['results']['video_details']['video']['@views']?></li>
                                                                        <li>Tags: <?=$tags_text?></li>
                                                                        <li>Pornstars: <?=$pornstar_text?></li>
                                                                    </ul>
                                                                </div>
							</div>
						</div>
					</div><!-- end video-play -->
				</div>
			
			</div><!-- end body-content -->
			
                        
                        
			<!--div class="sidebar-content span3">
				<div class="row">
					<div class="box-wrapper span3">
						<div class="row">
							<div class="title bg-title span3">
								<h3>Recommended</h3>
							</div>
						</div>
						<ul class="thumbnails thumbnails-horizontal">
							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
										<img class="border-radius-top" src="/pc/img/project/pj1.jpg">
									</div>
									<h5><a href="detail.html">Lorem ipsum dolor sit  </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>
							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
									<img class="border-radius-top" src="/pc/img/project/pj2.jpg">
									</div>
									
									<h5><a href="detail.html">Lorem ipsum dolor sit </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>
							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
									<img class="border-radius-top" src="/pc/img/project/pj3.jpg">
									</div>
									
									<h5><a href="detail.html">Lorem ipsum dolor sit </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>
							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
									<img class="border-radius-top" src="/pc/img/project/pj4.jpg">
									</div>
									
									<h5><a href="detail.html">Lorem ipsum dolor sit </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>

							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
									<img class="border-radius-top" src="/pc/img/project/pj5.jpg">
									</div>
									
									<h5><a href="detail.html">Lorem ipsum dolor sit </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>

							<li class="span3">
								<div class="thumbnail border-radius-top">
									<div class="bg-thumbnail-img">
										<a class="overlay" href="detail.html">
											<img src="/pc/img/icons/play.png">
										</a>
									<img class="border-radius-top" src="/pc/img/project/pj8.jpg">
									</div>
									
									<h5><a href="detail.html">Lorem ipsum dolor sit </a></h5>
								</div>
								<div class="box border-radius-bottom">
									<p>
										<span class="title_torrent pull-left">Movie</span>
										<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i>1,444,898</span>
									</p>
								</div>
							</li>
						</ul>
					</div><!-- end thumbnails-style1 -->
				</div><!-- row -->

			</div--><!-- end sidebar-content -->
		</div><!-- row -->
	</div><!-- end container -->
</div><!-- end main -->