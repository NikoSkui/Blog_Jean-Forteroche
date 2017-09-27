<?php
header('Content-Type: text/html; charset=UTF-8');

/**
 * Etape 1: Require L'application utilise un autoloader Maison
 */
require dirname(__DIR__).'/src/Core/Autoload.php';

/**
 * Step 2: Create instance of application with modules
 */
$app = (new \System\App(dirname(__DIR__) . '/config/config.php'))
        ->addModule(\App\Base\BaseModule::class)
        ->addModule(\App\User\UserModule::class)
        ->addModule(\App\Comment\CommentModule::class)
        ->addModule(\App\Admin\AdminModule::class)
        ->addModule(\App\Blog\BlogModule::class)     
        ->pipe(\System\Middlewares\WhoopsMiddleware::class)
        ->pipe(\System\Middlewares\TrailingSlashMiddleware::class)
        ->pipe(\System\Middlewares\MethodMiddleware::class)
        ->pipe(\System\Middlewares\RouterMiddleware::class)
        ->pipe(\System\Middlewares\LoginMiddleware::class)
        ->pipe(\System\Middlewares\DispatcherMiddleware::class)
        ->pipe(\System\Middlewares\NotFoundMiddleware::class);

 /**
 * Step 3: Run application
 */
$response = $app->run(\System\Http\ServerRequest::fromGlobals());

 /**
 * Step 4: Send response
 */
$app->send($response);