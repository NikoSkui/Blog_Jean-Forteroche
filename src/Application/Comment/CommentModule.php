<?php

namespace App\Comment;

use System\Module;
use System\Renderer\RendererInterface;

class CommentModule extends Module
{

  // const DEFINITIONS = __DIR__ . '/config.php';

  public function __construct ( RendererInterface $renderer)
  {
    $renderer->addPath(__DIR__ . '/views','comment');
  }
  
}
