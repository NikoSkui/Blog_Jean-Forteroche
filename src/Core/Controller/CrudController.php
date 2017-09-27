<?php

namespace System\Controller;

use App\Libraries\RouterAware;
use App\Libraries\Typography;

use System\Router;
Use System\Http\Request;
use System\Renderer\RendererInterface;

class CrudController
{
  /**
   * @var RendererInterface
   */
  private $renderer;

  /**
   * @var Router
   */
  protected $router;

  /**
   * Models need
   * @var mixed
   */
  private $model;

  /**
   * @var string
   */
  protected $viewPath;

  /**
   * @var string
   */
  protected $prefixName;

  use RouterAware;
  use Typography;

  public function __construct(
    RendererInterface $renderer, 
    Router $router, 
    $model
  ) {
    // Idratation 
    $this->renderer = $renderer;
    $this->router = $router;
    $this->model = $model;

    $this->renderer->addGlobal('prefixName', $this->prefixName);
  }

  /**
  * method called when a route that matches call the child class
  */ 
  public function __invoke (Request $request)
  {

    if($request->getMethod()==="DELETE") {
      return $this->delete($request);  
    }
    if(substr($request->getUri()->getPath(), -3) === 'new') {
      return $this->create($request);  
    }
    if ($request->getAttribute('id')) {
      return $this->update($request);  
    }

    return $this->read($request);
  }

  /**
  * CREATE new element
  */
  public function create (Request $request)
  {
    $headerDatas = $this->getHeaderDatas('create');
    
    $element = $this->getNewEntity();

    if ($request->getMethod() === 'POST') {
      /**
      * Step 1: Recovery only of the desired keys.
      */
      $datas = $this->getParams($request);

      /**
      * Step 2: Creating chapter.
      */
      $this->model->create($datas);

      /**
      * Step 3: Redirection to the original page.
      */
      return $this->redirect($this->prefixName . '#Read');
    }

    return $this->renderer->render($this->viewPath . '/create', compact('headerDatas', 'element'));
  }

  /**
  * READ list of Element 
  */
  public function read (Request $request)
  {
    $headerDatas = $this->getHeaderDatas('read');

    $elements =  $this->model->findAll();

    return $this->renderer->render($this->viewPath . '/read', compact('headerDatas', 'elements'));
  }
  /**
  * UPDATE one Element
  */
  public function update (Request $request)
  {
    
    $element =  $this->model->findOne($request->getAttribute('id'));

    $headerDatas = $this->getHeaderDatas('update', $element);

    if ($request->getMethod() === 'PUT') {
      
      /**
      * Step 1: Recovery only of the desired keys.
      */
      $datas = $this->getParams($request);

      /**
      * Step 2: Updating element.
      */
      $this->model->update($element->id, $datas);

      /**
      * Step 3: Redirection to the original page.
      */
      return $this->redirect($this->prefixName . '#Read');
    }

    return $this->renderer->render($this->viewPath . '/update', compact('headerDatas', 'element'));
  }

  /**
  * DELETE one element
  */
  public function delete (Request $request)
  { 
    /**
    * Step 1: Deleted element.
    */
    $this->model->delete($request->getAttribute('id'));

    /**
    * Step 2: Redirection to the original page.
    */
    return $this->redirect($this->prefixName . '#Read');

  }
  
  /**
  * Filter to recover only of the desired keys.
  *         Example of injection with keys that you do not want:
  *         $datas['test'] = 'Toto';
  *         $datas["<script>alert('faille')</script>"] = "<script>alert('faille')</script>";
  */
  protected function getParams (Request $request)
  {
    // Step 1: Filter
    return array_filter($request->getParsedBody(), function ($key) {
        return in_array($key, []);
      }, ARRAY_FILTER_USE_KEY);
  }

  protected function getNewEntity ()
  {
    return [];
  }

  protected function getHeaderDatas ($action, $element = null)
  {
    $header = new \StdClass();
    $header->adminNavbar = [
    'Book' => [
      'name' => 'Livres',
      'prefixName' => 'Admin#Books'
    ],
    'Chapters' => [
      'name' => 'Chapitres',
      'prefixName' => 'Admin#Chapters'
    ],
    'Comments' => [
      'name' => 'Commentaires',
      'prefixName' => 'Admin#Comments'
    ]

    ];
    return $header;
  }
}