<?php

namespace App\Base\controllers;

use App\Base\entities\Header;

use App\Blog\models\BookModel;
use App\Libraries\RouterAware;

use System\Router;
use System\Http\Request;
use System\Http\Response;
use System\Renderer\RendererInterface;

class FrontBaseController
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
  protected $viewPath = "@home";

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
    // return $next($request);
    $header = $this->getHeaderEntity();    

    return $this->renderer->render($this->viewPath . '/index', compact('header'));    
  }

  /**
  * Create entity Header 
  */
  private function getHeaderEntity ()
  {
    $header = new Header();
    return $header;
  }
    
}
