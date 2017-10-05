<?php

namespace App\Error;

use App\Error\controllers\ErrorController;

use System\Module;
use System\Router;
use System\Renderer\RendererInterface;
use System\Container\DIContainer;

class ErrorModule extends Module
{

  public function __construct (DIContainer $container)
  {    
    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','error');

    // $container->get(Router::class)->get('/erreur-404', ErrorController::class, 'Error#404');
  }

}


