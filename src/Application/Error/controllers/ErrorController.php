<?php

namespace App\Error\controllers;

use System\Http\Request;
use System\Renderer\RendererInterface;
use App\Base\entities\Header;

class ErrorController
{
  /**
   * @var RendererInterface
   */
  private $renderer;


  /**
   * @var string
   */
  protected $viewPath = "@error";




  public function __construct(RendererInterface $renderer) 
  {
    // Idratation 
    $this->renderer = $renderer;
  }
   
  public function __invoke (Request $request)
  {
    $message = $request->getAttribute('message');
    $header = $this->getHeaderEntity('erreur', $message);

   

    return $this->renderer->render($this->viewPath . '/error404', compact('header', 'message'));    
  }

  /**
  * Create entity Header 
  */
  private function getHeaderEntity ($action, $element = null)
  {
    $header = new Header();
    $header->title = 'Oops...'; 
    $header->subtitle = 'Cette page n\'existe pas'; 
    if(!is_null($element)) {
      $header->subtitle = $element; 
    }
    $header->typePage = $action;

    return $header;
  }
    
}
