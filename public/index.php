<?php

/**
 * Etape 1: Require L'application utilise un autoloader Maison
 */
require '../src/Core/autoload.php';

//  pour aficher les propriété de l'objet même privé
ref::config('showPrivateMembers', true);
ref::config('validHtml', true);

/**
 * Etape 2.1: Test whoops
 */
// $whoops = new \Whoops\Run;
// $handler = new \Whoops\Handler\PrettyPageHandler;
// // Add a custom table to the layout:

// $handler->addDataTable('Errors Chargment Autoload',Autoloader::getAutoloadErrors());



// $whoops->pushHandler($handler);
// $whoops->register();

 
/**
 * Etape 2.1: FIN Test whoops
 */





/**
 * Step 2: Create instance of application with modules
 */
$app = new \System\App([
  \App\Base\BaseModule::class,
  \App\Blog\BlogModule::class
]);

 /**
 * Step 3: Run application
 */
$response = $app->run(\System\Http\ServerRequest::fromGlobals());
 /**
 * Step 4: Send response
 */
$app->send($response);
