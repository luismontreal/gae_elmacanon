<?php
switch ($data['params']['ordering']) {
    case 'mostviewed':
        $order = 'Most Viewed';
        break;
    case 'rating':
        $order = 'Best rated';
        break;
    case 'newest':
    default :
       $order = 'Newest';
}

$search = $data['params']['search'];
?>
<div class="box-wrapper  span12">
				<div class="row">
					<div class="span12">
						<?php include 'pagination.php' ?>
					</div><!-- end navigation -->
				</div>
				<div class="row">
					<div class="title span12">
						<h3 class="pull-left"><?= $order . ' ' . urldecode($search)?> videos</h3>
						<div class="sort pull-right dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
								<?=$order?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
                                                            <? if ($data['params']['ordering'] != 'newest') : ?>
								<li><a href="/<?= $search . '/1'?>"><i class="icon-list"></i>Newest</a></li>
                                                            <? endif; 
                                                               if ($data['params']['ordering'] != 'rating') :                                                           
                                                            ?>
                                                                <li><a href="/rating/<?= $search . '/1'?>"><i class="icon-tag"></i>Best rated</a></li>
                                                            <? endif; 
                                                               if ($data['params']['ordering'] != 'mostviewed') :                                                           
                                                            ?>    
								<li><a href="/mostviewed/<?= $search . '/1'?>"><i class="icon-eye-open"></i>Most Viewed</a></li>
                                                            <? endif; ?>
							</ul>
						</div>
					</div><!-- end title -->
				</div>
				<ul class="thumbnails thumbnails-horizontal">
					<?php foreach($data['results']['videos'] as $video) : ?>
                                        <li class="span3">
						<div class="thumbnail border-radius-top">
							<div class="bg-thumbnail-img">
								<!--a class="overlay" href="detail.html">
									<img src="/pc/img/icons/play.png">
								</a-->
								<img class="border-radius-top flipbook-thumb" src="<?=$video['@default_thumb']?>">
							</div>
							<h5><a href="detail.html"><?= $video['title']?></a></h5>
						</div>
						<div class="box border-radius-bottom">
							<p>
								<span class="title_torrent pull-left pull-left"><?=$video['@duration']?></span>
								<span class="number-view pull-right"><i class="icon-white icon-eye-open"></i><?=$video['@views']?></span>
							</p>
						</div>
					</li>
                                        <?php endforeach; ?>					
				</ul>
				<div class="row">
					<div class="span12">
						<?php include 'pagination.php' ?>
					</div><!-- end navigation -->
				</div>
			</div><!-- end  -->