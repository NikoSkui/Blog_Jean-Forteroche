<?php

namespace App\Blog\controllers;

use App\Base\entities\Header;

use App\Blog\models\BookModel;

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
  protected $prefixNameBooks = "Front#Books";
  protected $prefixNameChapters = "Front#Chapters";

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
   
  public function __invoke (Request $request, $next)
  {
    if ($request->getAttribute('slugBook') ) {
      return $this->oneBook($request, $next);
    }
     return $this->listBooks($request);
  }
    
  /**
  * READ list of Element 
  */
  public function listBooks (Request $request)
  {
    $books =  $this->model->findAll();  
    $header = $this->getHeaderEntity('readList');

    return $this->renderer->render($this->viewPath . '/list', compact('header', 'books'));
  }

  /**
  * READ one of Element 
  */
  public function oneBook (Request $request, $next)
  {
    $book = $this->model->findBy('slug',$request->getAttribute('slugBook'));
    if($book === false) {
      $request = $request->withAttribute('message', 'le livre est introuvable');
      return $next($request);
    }
    $header = $this->getHeaderEntity('readOne',$book);

    return $this->renderer->render($this->viewPath . '/one', compact('header', 'book'));
  }

  /**
  * Create entity Header 
  */
  private function getHeaderEntity ($action, $element = null)
  {
    $header = new Header();

    switch ($action) {
      case 'readList':
        $header->title = 'Entrez dans la bibliothèque'; 
        $header->subtitle = 'Découvrez tous nos livres';
        $header->typePage = 'readList';
        break;
      case 'readOne':
        $header->title = $element->name; 
        $header->subtitle = 'en détail';
        $header->typePage = 'readOne';
        break;
      default:
        break;
    }
    return $header;
  }
  

}
