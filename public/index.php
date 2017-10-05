<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * Step 1: Additionally required of homemade autoload
 */
require dirname(__DIR__).'/src/Core/Autoload.php';

/**
 * Step 2: Create instance of application with multiple modules
 */
$app = (new \System\App(dirname(__DIR__) . '/config/config.php'))
        ->addModule(\App\Base\BaseModule::class)                // For the home page
        ->addModule(\App\Error\ErrorModule::class)              // For the error page
        ->addModule(\App\Admin\AdminModule::class)              // For the administration area
        ->addModule(\App\User\UserModule::class)                // To control access to private areas
        ->addModule(\App\Blog\BlogModule::class)                // For blog pages
        ->addModule(\App\Comment\CommentModule::class);         // For comments sections

/**
 * Step 3: Add Middlewares to sequence the application
 */
$app->pipe(\System\Middlewares\WhoopsMiddleware::class)         // For debug
    ->pipe(\System\Middlewares\TrailingSlashMiddleware::class)  // To remove the slash at the end of uri
    ->pipe(\System\Middlewares\MethodMiddleware::class)         // To add method PUT and DELETE
    ->pipe(\System\Middlewares\RouterMiddleware::class)         // To see if there is a match in the routes store 
    ->pipe(\System\Middlewares\LoginMiddleware::class)          // To see if it's secure space
    ->pipe(\System\Middlewares\DispatcherMiddleware::class)     // For the allocation of the corresponding route
    ->pipe(\System\Middlewares\NotFoundMiddleware::class);      // For 404 Error if no response is returne before

 /**
 * Step 4: Run application
 */
$response = $app->run(\System\Http\ServerRequest::fromGlobals());

 /**
 * Step 5: Send response
 */
$app->send($response);
