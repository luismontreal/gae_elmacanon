<?php
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
    $search = urlencode('big dick');

    $data['params'] = $params = array(
        'page' => $page,
        'search' => $search,
        'ordering' => 'newest',
    );

    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    
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

    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    
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
    
    $data['results'] = $pimple['RedtubeController']->searchVideo($params);
    $data['params'] = $params;
   
    $pimple['app']->render('elements/header.php', array('data' => $data));
    $pimple['app']->render('home.php', array('data' => $data));
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
