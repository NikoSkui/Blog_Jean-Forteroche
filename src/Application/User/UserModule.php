<?php

namespace App\User;

use App\User\controllers\UserControlController;

use System\Module;
use System\Router;
use System\Renderer\RendererInterface;

use System\Container\DIContainer;

class UserModule extends Module
{

  public function __construct (DIContainer $container)
  {    
    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','users');

    $container->get(Router::class)->get('/users/login', UserControlController::class, 'User#Control#Login');
    $container->get(Router::class)->post('/users/login', UserControlController::class, 'User#Control#Login');

    $container->get(Router::class)->get('/users/logout', UserControlController::class, 'User#Control#Logout');
  }

}


