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
    $router = $container->get(Router::class);   
    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','users');

    $router->get('/users/login', UserControlController::class, 'User#Control#Login');
    $router->post('/users/login', UserControlController::class, 'User#Control#Login');

    $router->get('/users/logout', UserControlController::class, 'User#Control#Logout');
  }

}


