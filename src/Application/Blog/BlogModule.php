<?php

namespace App\Blog;

use App\Blog\controllers\FrontBookController;
use App\Blog\controllers\FrontChapterController;
use App\Blog\controllers\CrudBookController;
use App\Blog\controllers\CrudChapterController;
use App\comment\controllers\CrudReportController;
use App\Comment\controllers\RdCommentController;

use App\Comment\controllers\CommentController;

use System\Module;
use System\Router;
use System\Container\DIContainer;
use System\Renderer\RendererInterface;

class BlogModule extends Module
{

  const DEFINITIONS = __DIR__ . '/config.php';

  public function __construct (DIContainer $container)
  {
     $router = $container->get(Router::class);  
     $prefix_blog = $container->get('prefix.blog');  

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','blog');

    // Routes for Blog Module
    $router->get($prefix_blog, FrontBookController::class, 'Front#Books#List');
    $router->get($prefix_blog . '/{slugBook}', FrontBookController::class, 'Front#Books#One');
    $router->get($prefix_blog . '/{slugBook}/chapitres', FrontChapterController::class, 'Front#Chapters#List');
    $router->get($prefix_blog . '/{slugBook}/chapitre-{chapters_order}/{slugChapter}', FrontChapterController::class, 'Front#Chapters#One');
    
    // Routes for Comments Module 
    if ($container->has(\App\Comment\CommentModule::class)) {
    }

    // Routes for Admin Module 
    if ($container->has(\App\Admin\AdminModule::class)) {
      $prefix_admin = $container->get('prefix.admin');  
      
      $router->crud($prefix_admin.'/livres',CrudBookController::class, 'Admin#Books');      
      $router->crud($prefix_admin.'/chapitres',CrudChapterController::class, 'Admin#Chapters');
      $router->crud($prefix_admin.'/commentaires',RdCommentController::class, 'Admin#Comments');
      $router->delete($prefix_admin.'/signalements/{id}',CrudReportController::class, 'Admin#Reports#Delete');

    }  
    
  }
  
}
