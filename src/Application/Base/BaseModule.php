<?php

namespace App\Base;

use \App\Models\BookModel;
use System\Module;
use System\Router;
use System\Database\Database;
use System\Http\Request;
use System\Renderer\RendererInterface;

class BaseModule extends Module
{

  private $bookModel;

  public function __construct (Router $router, RendererInterface $renderer, BookModel $bookModel)
  {
    // parent::__construct($router, $renderer);
    
    $this->renderer = $renderer;
    $this->bookModel = $bookModel;

    $renderer->addPath(__DIR__ . '/views','base');
    $router->get('/', [$this, 'index'], 'Base#home');

    // $router->get('/', function() {return '<h1>Bienvenue sur la page d\'accueil</h1>';}, 'Base#home'); Example of route with callback
    // TODO Testing Other types of routes 
    // $router->get('/posts', "Base#views"); Examples of routes without callback, just named , class#action
    // $router->get('/posts/{id}/{page}', "Base#view"); 
  }

  public function index (Request $request)
  {
    // r($request);
    // r($request->getServerParam('HTTP_HOST'));
    // r($request->getServerParam('REQUEST_URI'));
    $post = $this->bookModel->findLast();


    return $this->renderer->render('@base/index',compact('post'));
  }

}


