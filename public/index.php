<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * Step 1: Require L'application utilise un autoloader Maison a traduire
 */
require dirname(__DIR__).'/src/Core/Autoload.php';

/**
 * Step 2: Create instance of application with modules
 */
$app = (new \System\App(dirname(__DIR__) . '/config/config.php'))
        ->addModule(\App\Base\BaseModule::class)
        ->addModule(\App\Admin\AdminModule::class)
        ->addModule(\App\User\UserModule::class)
        ->addModule(\App\Comment\CommentModule::class)
        ->addModule(\App\Blog\BlogModule::class); 
/**
 * Step 3: Add Middlewares to sequence the application
 */
$app->pipe(\System\Middlewares\WhoopsMiddleware::class)         // For debug
    ->pipe(\System\Middlewares\TrailingSlashMiddleware::class)  // For delete slash at the end of uri
    ->pipe(\System\Middlewares\MethodMiddleware::class)         // For add method PUT and DELETE
    ->pipe(\System\Middlewares\RouterMiddleware::class)         // For see if match  in routes store 
    ->pipe(\System\Middlewares\LoginMiddleware::class)          // For see if is secure space
    ->pipe(\System\Middlewares\DispatcherMiddleware::class)         // For add method PUT and DELETE
    ->pipe(\System\Middlewares\NotFoundMiddleware::class);      // For 404 Error if not return before

 /**
 * Step 4: Run application
 */
$response = $app->run(\System\Http\ServerRequest::fromGlobals());

 /**
 * Step 5: Send response
 */
$app->send($response);
