<?php

namespace App\Comment;

use System\Router;
use System\Module;
use System\Container\DIContainer;
use System\Renderer\RendererInterface;

class CommentModule extends Module
{
  // const DEFINITIONS = __DIR__ . '/config.php';

  public function __construct (DIContainer $container)
  {
    $router = $container->get(Router::class);
    $prefix_blog = $container->get('prefix.blog'); 

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','comment');

    // Routes for Comments Module 
    $router->post($prefix_blog.'/{slugBook}/chapitre-{chapters_order}/{slugChapter}/signalements/new', CrudReportController::class, 'Front#Report#Create');
    $router->post($prefix_blog.'/{slugBook}/chapitre-{chapters_order}/{slugChapter}-{id}', CommentController::class, 'Front#Comment#Create');
    


  }
  
}
