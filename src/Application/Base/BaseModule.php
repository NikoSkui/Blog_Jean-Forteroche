<?php

namespace App\Base;

use App\Base\controllers\FrontBaseController;

use System\Module;
use System\Router;
use System\Renderer\RendererInterface;
use System\Container\DIContainer;

class BaseModule extends Module
{

  public function __construct (DIContainer $container)
  {    
    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','home');
    $container->get(RendererInterface::class)->addPath(dirname(__DIR__) . '/Components','component');

    $container->get(Router::class)->get('/', FrontBaseController::class, 'Front#Base#Index');
  }

}


