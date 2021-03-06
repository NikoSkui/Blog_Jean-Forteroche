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
      'urlHelper'   => $container->get('App\Helpers\UrlHelper'),
      'router' => $container->get('System\Router'),
      'session' => $container->get('System\Session\PHPSession'),
    ];
    return new PHPRenderer($viewPath,$globals);
  }
}
