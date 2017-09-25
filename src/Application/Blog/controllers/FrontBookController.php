<?php

namespace App\Blog\controllers;

use App\Models\BookModel;
use App\Libraries\RouterAware;

use System\Router;
use System\Http\Request;
use System\Http\Response;
use System\Renderer\RendererInterface;

class FrontBookController
{
  /**
   * @var RendererInterface
   */
  private $renderer;

  /**
   * @var Router
   */
  private $router;

  /**
   * @var string
   */
  protected $viewPath = "@blog/front/books";

  /**
   * @var string
   */
  protected $prefixNameBooks = "FrontBooks";
  protected $prefixNameChapters = "FrontChapters";

  /**
   * @var BookModel
   */
  private $model;

  use RouterAware;

  public function __construct(RendererInterface $renderer,Router $router, BookModel $model) 
  {
    // Idratation 
    $this->renderer = $renderer;
    $this->router = $router;
    $this->model = $model;
    $this->renderer->addGlobal('prefixNameBooks', $this->prefixNameBooks);
    $this->renderer->addGlobal('prefixNameChapters', $this->prefixNameChapters);
  }
   
  public function __invoke (Request $request)
  {

    if ($request->getAttribute('slugBook') ) {
      return $this->oneBook($request);
    }
     return $this->listBooks($request);
  }
    
  /**
  * READ list of Element 
  */
  public function listBooks (Request $request)
  {
    $books =  $this->model->findAll();  

    return $this->renderer->render($this->viewPath . '/list', compact('books'));
  }

  /**
  * READ one of Element 
  */
  public function oneBook (Request $request)
  {
    $book = $this->model->findBy('slug',$request->getAttribute('slugBook'));
    if($element === false) {
      return new Response(404, [], '<h1>Erreur 404 : book not Found<h1>');
    }

    return $this->renderer->render($this->viewPath . '/one', compact('book'));
  }
  

}
