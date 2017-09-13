<?php

namespace App\Blog;

use App\Blog\controllers\BlogController;
use System\Module;
use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;

class BlogModule extends Module
{

  public function __construct (Router $router, RendererInterface $renderer)
  {
    parent::__construct($router, $renderer);

    $renderer->addPath(__DIR__ . '/views','blog');
    $router->get('/Livres', BlogController::class, 'Blog#index');
    $router->get('/Livre/{slug}', BlogController::class, 'Blog#shows');
    $router->get('/Livre/Chapitre-{id}/{slug}', BlogController::class, 'Blog#show');
  }
  
}
