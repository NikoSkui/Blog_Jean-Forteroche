<?php

namespace App\Admin;

use App\Admin\controllers\AdminBaseController;

use System\Module;
use System\Renderer\RendererInterface;
use System\Container\DIContainer;

class AdminModule extends Module
{

  const DEFINITIONS = __DIR__ . '/config.php';

  public function __construct (DIContainer $container)
  {    
    $prefix_admin = $container->get('prefix.admin'); 
    $router = $container->get(\System\Router::class); 

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','admin');
    
    $router->get($prefix_admin, AdminBaseController::class, 'Admin#Base#Index');


  }


}


