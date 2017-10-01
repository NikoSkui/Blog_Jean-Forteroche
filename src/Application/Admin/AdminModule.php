<?php

namespace App\Admin;

use System\Module;
use System\Renderer\RendererInterface;
use System\Container\DIContainer;

class AdminModule extends Module
{

  const DEFINITIONS = __DIR__ . '/config.php';

  public function __construct (DIContainer $container)
  {    

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','admin');

  }


}


