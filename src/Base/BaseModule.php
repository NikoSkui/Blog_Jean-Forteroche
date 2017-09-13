<?php

namespace App\Base;

use System\Module;
use System\Router;
use System\Database\Database;
use System\Http\Request;
use System\Renderer\RendererInterface;

class BaseModule extends Module
{

  private $db;

  public function __construct (Router $router, RendererInterface $renderer, \PDO $database)
  {
    parent::__construct($router, $renderer);
    
    $this->renderer = $renderer;
    $this->db = $database;

    $renderer->addPath(__DIR__ . '/views','base');
    $router->get('/', [$this, 'index'], 'Base#home');

    // $router->get('/', function() {return '<h1>Bienvenue sur la page d\'accueil</h1>';}, 'Base#home'); Example of route with callback
    // TODO Testing Other types of routes 
    // $router->get('/posts', "Base#views"); Examples of routes without callback, just named , class#action
    // $router->get('/posts/{id}/{page}', "Base#view"); 
  }

  public function index (Request $request)
  {
    $posts = $this->db
                  ->query('SELECT * FROM books')
                  ->fetchAll();
    $test = ['trer', 'dsfg','df'];
    $slug = 'mon slug';

    print_r(compact('posts'));
    $newDatas = compact($datas);

    return $this->renderer->render('@base/index',compact('posts','test','slug'));
  }

}


