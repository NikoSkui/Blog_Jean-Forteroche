<?php

namespace App\Blog\controllers;


use App\Models\BookModel;
use App\Entity\Book;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;
use System\Controller\CrudController;

class CrudBookController extends CrudController
{
  /**
   * @var string
   */
  protected $viewPath = "@blog/admin/books";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Books";



  public function __construct(Router $router, RendererInterface $renderer, BookModel $model)
  {
    // Idratation 
    parent::__construct($renderer, $router, $model);
    $renderer->setLayoutNamespace('admin');
  }


  /**
  * Filter to recover only of the desired keys.
  */
  protected function getParams (Request $request)
  {
    // Step 1: Filter
    $datas =  array_filter($request->getParsedBody(), function ($key) {
        return in_array($key, ['name', 'excerpt', 'created_at']);
      }, ARRAY_FILTER_USE_KEY);

    // Step 2: Definition of some value 
    if(isset($datas['name']) && !empty($datas['name'])){
      $datas['name'] = strip_tags($datas['name']);
      $datas['slug'] = $this->makeSlug(strip_tags($datas['name']));
    }

    if(isset($datas['excerpt']) && !empty($datas['excerpt'])){
      $datas['excerpt'] = trim(substr($datas['excerpt'],3,-4));
    }
    $datas['modified_at'] = date('Y-m-d H:i:s');

    return $datas;

  }

  /**
  * Create entity when you insert new item in bdd and add some inital values
  */
  protected function getNewEntity ()
  {
    $book = new Book($this->router);
    $book->created_at = date('Y-m-d H:i:s');
      
    return $book;
  }

  /**
  * Create entity Header when you insert new item in bdd and add some inital values
  */
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
        $header->subtitle = 'Gestion des livres';
        $header->typePage = 'read';
        // $header->btnTxt = 'Ajouter un nouveau livre';
        break;
      case 'update':
        $header->name = $element->name;
        $header->subtitle = 'Modification du livre  : ' . $element->name;
        $header->typePage = 'update';
        break;
      
      default:
        $header->subtitle = 'Maitrisez la gestion de vos livres';
        break;
    }
    return $header;
  }

}