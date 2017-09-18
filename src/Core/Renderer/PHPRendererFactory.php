<?php

namespace System\Renderer;

use System\Container\DIContainer;

class PHPRendererFactory
{

  public function __construct() {}

  public function __invoke(DIContainer $container)
  {
    $viewPath = $container->get('views.path');
    $globals = [
      'router' => $container->get('System\Router')
    ];
    return new PHPRenderer($viewPath,$globals);
  }
}
