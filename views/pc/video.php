<?php
//orientation, null is assumed straight
if(empty($data['params']['category']) || $data['params']['category'] == 'straight')
    $orientation = '/';
else {
    $orientation = '/' . $data['params']['category'] .'/';
}

$tags_text = '';
foreach(@$data['results']['video_details']['video']['tags']['tag'] as $tag) { 
    $tags_text .= '<a href="' . $orientation . str_replace(' ', '+', trim($tag)) . '">' . $tag . '</a>, ';
}
$tags_text = strtolower(rtrim($tags_text,', '));

$pornstar_text = '';
foreach(@$data['results']['video_details']['video']['stars']['star'] as $star) { 
    $pornstar_text .= '<a href="/' . str_replace(' ', '+', trim($star)) . '">' . $star . '</a>, ';
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
                                                                        <li>Duration: <?=@$data['results']['video_details']['video']['@duration']?></li>
                                                                        <li>Views: <?=@$data['results']['video_details']['video']['@views']?></li>
                                                                        <li>Tags: <?=$tags_text?></li>
                                                                        <li>Pornstars: <?=$pornstar_text?></li>
                                                                    </ul>
                                                                </div>
							</div>
						</div>
					</div><!-- end video-play -->
				</div>
			
			</div><!-- end body-content -->			
		    </div><!-- row -->		   
		</div><!-- row -->
	</div><!-- end container -->
</div><!-- end main -->