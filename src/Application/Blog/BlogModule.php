<?php

namespace App\Blog;

use App\Blog\controllers\BlogController;
use App\Blog\controllers\AdminBlogController;
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
    // parent::__construct($router, $renderer);

    $container->get(RendererInterface::class)->addPath(__DIR__ . '/views','blog');

    // Routes for Blog Module
    $router->get($prefix_blog, BlogController::class, 'Blog#listBooks');
    $router->get($prefix_blog.'/{slug}', BlogController::class, 'Blog#listChapters');
    $router->get($prefix_blog.'/{slugBook}/Chapitre-{id}/{slug}', BlogController::class, 'Blog#oneChapter');
    
    // Routes for Comments Module 
    if ($container->has(\App\Comment\CommentModule::class)) {
      $router->post('/{slugBook}/Chapitre-{id}/{slug}', CommentController::class, 'Blog#oneChapterPost');
    }

    // Routes for Admin Module 
    // if ($container->has(\App\Admin\AdminModule::class)) {
      $prefix_admin = '/admin';
      $router->get($prefix_admin.$prefix_blog, AdminBlogController::class, 'AdminBlog#listChapters');
    // }  
    
  }
  
}
