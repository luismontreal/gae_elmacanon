<?php
//error reporting 0 for prod only
error_reporting(0);
$_SERVER['SERVER_PORT'] = 80;
require 'vendor/autoload.php';
require 'vendor/kint/Kint.class.php';
require 'vendor/Mobile_Detect.php';
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
//check wether or not is mobile
$detect = new Mobile_Detect;
if($detect->isMobile()) {
    define('IS_MOBILE', true);    
} else {
    define('IS_MOBILE', false);
}

class MyLogWriter {
    public function write($message, $priority)
    {
        syslog($priority, $message);
    }
}

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
    'debug' => false,
    'templates.path' => 'views/pc',
    'log.enabled' => true,
    'log.writer' => new MyLogWriter(),
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

$app->notFound(function () use ($app) {
    $app->render('elements/header.php');
    $app->render('404.php');
    $app->render('elements/footer.php');
});

$app->get('/sitemap.xml', function () use ($app) {
    $app->response->headers->set('Content-Type', 'text/xml');
    echo '<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><sitemap><loc>http://www.elmacanon.com/sitemap_tags.xml</loc></sitemap><sitemap><loc>http://www.elmacanon.com/sitemap_videos.xml</loc></sitemap></sitemapindex>';
});

$app->get('/sitemap_tags.xml', function () use ($app) {
    $app->response->headers->set('Content-Type', 'text/xml');
    $memcache = new Memcache;
    $mc_key = 'sitemap.tags';
    echo $memcache->get($mc_key);
});

$app->get('/sitemap_videos.xml', function () use ($app) {   
    $app->response->headers->set('Content-Type', 'text/xml');
    $memcache = new Memcache;
    $mc_key = 'sitemap.videos';
    echo $memcache->get($mc_key);
});

$app->get('/page/:page', function ($page) use ($app) {   
    switch($page) {
	case 'hot-searches':
	    $data = $app->RedtubeController->getTags();
	    $data['seo']['title'] = 'Elmacanon.com: Hot searches';
	    $data['seo']['index'] = true;
	     
	    $app->render('elements/header.php',  array('data' => $data));
	    $app->render('popular.php',  array('data' => $data));
	    $app->render('elements/footer.php',  array('data' => $data));
	    break;
	default :
	    $app->notFound();
	    
    }
});

//Straight route
$app->get('/(:search)', function ($search = 'big dick') use ($app) {    
    //if search term is gay or straight then go to next route
    if(in_array($search, array('gay','shemale'))) {
        $app->pass();
    }
    
    //if user's cookie is gay/shemale redirect to that url
    $orientation = $app->getCookie('orientation');
    if(in_array($orientation, array('gay', 'shemale'))) {
        $requestsStraight = $app->request->get('straight');
        
        if(!empty($requestsStraight)) {
            $app->setCookie('orientation', 'straight');
            $app->redirect('/');
        } else {
            $app->redirect('/' . $orientation);
        }
    }
    
    if($orientation != 'straight') {
        $app->setCookie('orientation', 'straight');
    }
    
    $options = array(
        'page' => $app->request->get('page'),
        'order' => $app->request->get('order'),
    );
    
    $data = $app->RedtubeController->getSearchPage($search, null, $options);
    
    //templates
    $app->render('elements/header.php', array('data' => $data));
    $app->render('home.php', array('data' => $data));
    $app->render('elements/footer.php', array('data' => $data));
})->name('search');
//Gay/Shemale routes
$app->get('/:orientation(/:search)', function ($orientation, $search = 'big dick') use ($app) {
    $options = array(
        'page' => $app->request->get('page'),
        'order' => $app->request->get('order'),
    );
    
    $app>setCookie('orientation', $orientation);
            
    $data = $app->RedtubeController->getSearchPage($search, $orientation, $options);
    
    //templates
    $app->render('elements/header.php', array('data' => $data));
    $app->render('home.php', array('data' => $data));
    $app->render('elements/footer.php', array('data' => $data));
})->name('search_orientation')->conditions(array('orientation' => 'gay|shemale'));

$app->get('/video/:slug/:video_id', function ($slug, $video_id) use ($app) {
    $data['params'] = $params = array(
        'video_id' => $video_id,
    );
    //get last known orientation with the cookie
    $data['params']['category'] = $app->getCookie('orientation');
    $data['results'] = $app->RedtubeController->getVideoDetails($params);
   
    if(empty($data['results'])) {
        $app->pass();
    }
    /*Redtube API has different format if returning only 1 result or many*/
    if(isset($data['results']['video_details']['video']['stars']['star'])) {
        if(!is_array($data['results']['video_details']['video']['stars']['star'])) {
            settype($data['results']['video_details']['video']['stars']['star'], 'array');
        }
    } else {
        $data['results']['video_details']['video']['stars']['star'] = array();
    }
    
    /*Redtube API has different format if returning only 1 result or many*/
    if(isset($data['results']['video_details']['video']['tags']['tag'])) {
        if(!is_array($data['results']['video_details']['video']['tags']['tag'])) {
            settype($data['results']['video_details']['video']['tags']['tag'], 'array');
        }
    } else {
        $data['results']['video_details']['video']['tags']['tag'] = array();
    }
    
    if(empty($data['results']['video_details']['video']['title'])) {
	$data['results']['video_details']['video']['title'] = 'Another awesome video';
    }
    
    $data['seo']['title'] = 'Elmacanon: ' . $data['results']['video_details']['video']['title'];
    $data['seo']['index'] = true;
    
    $app->render('elements/header.php', array('data' => $data));
    $app->render('video.php', array('data' => $data));
    $app->render('elements/footer.php', array('data' => $data));
})->name('order');

$app->get('/contact', function () use ($app) {
   //$app->render('contact.php');
   printf('Simple contact page.  Link to <a href="%s">User 11</a>', $app->urlFor('user', array('id' => 11)));
});

$app->get('/user/:id', function ($id) use ($app) {
   $app['UserController']->find($id);
})->name('user');

$app->get('/users', function () use ($app) {
   $app['UserController']->all();
})->name('users');


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();