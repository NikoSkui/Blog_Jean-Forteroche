<?php

namespace App\Admin;

use System\Module;
use System\Renderer\RendererInterface;

class AdminModule extends Module
{

  public function __construct (RendererInterface $renderer)
  {    
    $this->renderer = $renderer;

    $renderer->addPath(__DIR__ . '/views','admin');

  }


}


