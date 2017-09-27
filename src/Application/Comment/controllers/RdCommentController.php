<?php

namespace App\Comment\controllers;


use App\Models\CommentModel;
use App\Entity\Comment;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;
use System\Controller\CrudController;

class RdCommentController extends CrudController
{
  /**
   * @var string
   */
  protected $viewPath = "@comment/admin/chapters";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Comments";



  public function __construct(Router $router, RendererInterface $renderer, CommentModel $model)
  {
    // Idratation 
    parent::__construct($renderer, $router, $model);
    $renderer->setLayoutNamespace('admin');
  }


  protected function getParams (Request $request)
  {
    /**
    * Filter to recover only of the desired keys.
    *         Example of injection with keys that you do not want:
    *         $datas['test'] = 'Toto';
    *         $datas["<script>alert('faille')</script>"] = "<script>alert('faille')</script>";
    */
    $datas =  array_filter($request->getParsedBody(), function ($key) {
        return in_array($key, ['name', 'slug', 'content', 'created_at']);
      }, ARRAY_FILTER_USE_KEY);
    /**
    * Step 2: Definition of some value
    */
    return array_merge($datas,[
      'modified_at' => date('Y-m-d H:i:s')
    ]);
  }

  protected function getNewEntity ()
  {
    $book = new Book($this->router);
    $book->created_at = date('Y-m-d H:i:s');
      
    return $book;
  }

  protected function getHeaderDatas ($action, $element = null)
  {
    $header = parent::getHeaderDatas($action,$element);

    $header->linkName = 'Livres'; 
    $header->prefixName = $this->prefixName;

    switch ($action) {
      case 'create':
        $header->subtitle = 'Ajout d\'un nouveau livre';
        $header->typePage = 'create';
        break;
      case 'read':
        $header->subtitle = 'Gestion des commentaires';
        $header->typePage = 'read';
        // $header->btnTxt = 'Ajouter un nouveau livre';
        break;
      case 'update':
        $header->email = $element->email;
        $header->subtitle = 'Aperçu du commentaire de ' . $element->pseudo;
        $header->typePage = 'update';
        break;
      
      default:
        $header->subtitle = 'Maitrisez la gestion de vos livres';
        break;
    }
    return $header;
  }

}