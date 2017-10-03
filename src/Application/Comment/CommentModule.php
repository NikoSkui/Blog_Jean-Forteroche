<?php

namespace App\Comment;

use App\Comment\controllers\CrudReportController;
use App\Comment\controllers\CrudCommentController;

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

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','comment');

    // Routes for Comments Module 
    if ($container->has(\App\Admin\CommentModule::class)) {
      $prefix_blog = $container->get('prefix.blog'); 
      $router->post($prefix_blog.'/{slugBook}/chapitre-{chapters_order}/{slugChapter}/signalements/new', CrudReportController::class, 'Front#Report#Create');
      $router->post($prefix_blog.'/{slugBook}/chapitre-{chapters_order}/{slugChapter}-{id}/comments/new', CrudCommentController::class, 'Front#Comment#Create');
    }

    // Routes for Admin Module 
    if ($container->has(\App\Admin\AdminModule::class)) {
      $prefix_admin = $container->get('prefix.admin');  
      $router->crud($prefix_admin.'/commentaires',CrudCommentController::class, 'Admin#Comments');
      $router->delete($prefix_admin.'/signalements/{id}',CrudReportController::class, 'Admin#Reports#Delete');

    }

  }
  
}
