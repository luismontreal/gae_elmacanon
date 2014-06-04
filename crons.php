<?php
$_SERVER['SERVER_PORT'] = 80;
require 'vendor/autoload.php';
require 'vendor/kint/Kint.class.php';
require 'app/controllers.php';
require 'app/models.php';
require 'app/api.php';
require 'app/helpers.php';
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
//require 'Slim/Slim.php';

//\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
    'debug' => true,
    'templates.path' => 'views/pc',
    'log.enabled' => false,
    'cookies.lifetime' => time() + 31536000, //in 1 year after accesing the site
));

/* 
 * Dependency injection
 *  
 */

$app->RedtubeController = function ($app) {    
    return new RedtubeController($app);
};

$app->RedtubeModel = function ($app) {
    return new RedtubeModel($app);
};

$app->Api = function ($app) {
    return new Api($app);
};
/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

$app->get('/crons/generatesitemap_tags', function () use ($app) {
    $data = $app->RedtubeController->getTags();
    if(empty($data)) {
	exit('not ok');
    }
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    //$time = new DateTime('NOW');
    //$W3cTime = $time->format('Y-m-d');
    $orientations = array('', 'gay/', 'shemale/');
    
    foreach($orientations as $orientation) {
	foreach($data['tags']['tag'] as $tag) {
	    $tag = strtolower(str_replace(' ', '+', $tag));
	    $sitemap .= '<url>';
	    $sitemap .= '<loc>http://www.elmacanon.com/' . $orientation . $tag . '</loc>';
	    //$sitemap .= '<lastmod>' . $W3cTime . '</lastmod>';
	    $sitemap .= '<changefreq>hourly</changefreq>';
	    $sitemap .= '</url>';
	    
	}	
    }

    $sitemap .= '</urlset>';
    $memcache = new Memcache();
    $memcache->set('sitemap.tags', $sitemap, 0);
    exit('ok');
   });

$app->get('/crons/generatesitemap_videos', function () use ($app) {
    $data = $app->RedtubeController->getTags();
    if(empty($data)) {
	exit('not ok');
    }
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    //$time = new DateTime('NOW');
    
    foreach($data['tags']['tag'] as $tag) {
	$data = $app->RedtubeController->getSearchPage($tag, null, array('page' => 1));
	if(empty($data)) {
	    break;
	}
	foreach($data['results']['videos'] as $video) {
	    $sitemap .= '<url>';
	    $sitemap .= '<loc>http://www.elmacanon.com/video/' . Helpers::slugify($video['title']) . '/' . $video['@video_id'] . '</loc>';
	    //$sitemap .= '<lastmod>' . $W3cTime . '</lastmod>';
	    $sitemap .= '<changefreq>never</changefreq>';
	    $sitemap .= '</url>';
	}
    }
    
    $sitemap .= '</urlset>';
    $memcache = new Memcache();
    $memcache->set('sitemap.videos', $sitemap, 0);
    exit('ok');
});

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();


   
   
   
  
   