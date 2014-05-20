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
    'log.enabled' => false
));

/* 
 * Dependency injection
 *  
 */

$pimple = new Pimple();
$pimple['app'] = $app;

$pimple['RedtubeController'] = function ($pimple) {    
    return new RedtubeController($pimple);
};

$pimple['RedtubeModel'] = function ($pimple) {
    return new RedtubeModel($pimple);
};

$pimple['Api'] = function ($pimple) {
    return new Api($pimple);
};

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET routes
$app->get('/', function () use ($pimple) {
    $page = 1;
    $search = 'big+dick';

    $data['params'] = $params = array(
        'page' => $page,
        'search' => $search,
        'ordering' => 'newest',
    );

    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    $data['seo']['title'] = 'Elmacanon: Best Free Porn Videos';
    
    $pimple['app']->render('elements/header.php', array('data' => $data));
    $pimple['app']->render('home.php', array('data' => $data));
    $pimple['app']->render('elements/footer.php', array('data' => $data));
});

$app->get('/:search/:page', function ($search, $page) use ($pimple) {
    if(!is_numeric($page) || $page < 1) {
        $page = 1;
    }
    
    $data['params'] = $params = array(
        'page' => $page,
        'search' => $search,
        'ordering' => 'newest',
    );
    $data['seo']['title'] = 'Elmacanon: Best Free ' . $search . ' Porn Videos';
    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    if($data['results']['count'] == 1) {
        $data['results']['videos'] = array($data['results']['videos']);
    }
    $pimple['app']->render('elements/header.php', array('data' => $data));
    $pimple['app']->render('home.php', array('data' => $data));
    $pimple['app']->render('elements/footer.php', array('data' => $data));
})->name('search');

$app->get('/:order/:search/:page', function ($order, $search, $page) use ($pimple) {
    if(!is_numeric($page) || $page < 1) {
        $page = 1;
    }
    
    $data['params'] = $params = array(
        'page' => $page,
        'search' => $search,
        'ordering' => $order,
    );
    $data['seo']['title'] = 'Elmacanon: Best Free ' . urldecode($search) . ' Porn Videos';
    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    if($data['results']['count'] == 1) {
        $data['results']['videos'] = array($data['results']['videos']);
    }
   
    $pimple['app']->render('elements/header.php', array('data' => $data));
    $pimple['app']->render('home.php', array('data' => $data));
    $pimple['app']->render('elements/footer.php', array('data' => $data));
})->name('order')->conditions(array('order' => 'mostviewed|rating'));;

$app->get('/video/:slug/:video_id', function ($slug, $video_id) use ($pimple) {
    $data['params'] = $params = array(
        'video_id' => $video_id,
    );
    
    $data['results'] = $pimple['RedtubeController']->getVideoDetails($params);
   
    if(empty($data['results'])) {
        $pimple['app']->pass();
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
    
    $data['seo']['title'] = 'Elmacanon: ' . $data['results']['video_details']['video']['title'];
    
    $pimple['app']->render('elements/header.php', array('data' => $data));
    $pimple['app']->render('video.php', array('data' => $data));
    $pimple['app']->render('elements/footer.php', array('data' => $data));
})->name('order');

$app->get('/contact', function () use ($pimple) {
   //$pimple['app']->render('contact.php');
   printf('Simple contact page.  Link to <a href="%s">User 11</a>', $pimple['app']->urlFor('user', array('id' => 11)));
});

$app->get('/user/:id', function ($id) use ($pimple) {
   $pimple['UserController']->find($id);
})->name('user');

$app->get('/users', function () use ($pimple) {
   $pimple['UserController']->all();
})->name('users');


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
