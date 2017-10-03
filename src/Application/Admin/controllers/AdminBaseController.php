<?php

namespace App\Admin\controllers;

use App\Admin\entities\Header;
use App\Libraries\RouterAware;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;

class AdminBaseController
{
  /**
   * @var RendererInterface
   */
  protected $renderer;

  /**
   * @var Router
   */
  protected $router;

  /**
   * @var string
   */
  protected $viewPath = "@admin";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Base";


  use RouterAware;

  public function __construct(RendererInterface $renderer,Router $router) 
  {
    // Idratation 
    $this->renderer = $renderer;
    $this->router = $router;
    $renderer->setLayoutNamespace('admin');
  }
   
  public function __invoke (Request $request, $next)
  {
    // return $next($request);
    $header = $this->getHeaderEntity('dashboard');    

    return $this->renderer->render($this->viewPath . '/index', compact('header'));    
  }

  /**
  * Create entity Header 
  */
  private function getHeaderEntity ()
  {

    $header = new Header($this->renderer);

    $header->prefixName = $this->prefixName;

    return $header;
  }
    
}
