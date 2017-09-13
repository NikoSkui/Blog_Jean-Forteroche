<?php

namespace System;

use \System\Renderer\RendererInterface;

class Module
{

  public function __construct (Router $router, RendererInterface $renderer)
  {
    $renderer->addGlobal('router', $router);
  }
}
