<?php

namespace App\Blog\controllers;


use App\Models\ChapterModel;
use App\Entity\Chapter;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;
use System\Controller\CrudController;

class CrudChapterController extends CrudController
{
  /**
   * @var string
   */
  protected $viewPath = "@blog/admin/chapters";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Chapters";


  public function __construct(Router $router, RendererInterface $renderer, ChapterModel $model)
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
        return in_array($key, ['name', 'content', 'created_at', 'books_id', 'chapters_order']);
      }, ARRAY_FILTER_USE_KEY);

    // Step 2: Definition of some value 
    if(isset($datas['name']) && !empty($datas['name'])){
      $datas['name'] = strip_tags($datas['name']);
      $datas['slug'] = $this->makeSlug(strip_tags($datas['name']));
    }
    if(isset($datas['created_at']) && !empty($datas['created_at'])){
      $datas['created_at'] = strip_tags($datas['created_at']);
    }
    if(isset($datas['books_id']) && !empty($datas['books_id'])){
      $datas['books_id'] = strip_tags($datas['books_id']);
    }
    if(isset($datas['chapters_order']) && !empty($datas['chapters_order'])){
      $datas['chapters_order'] = strip_tags($datas['chapters_order']);
    }
    if(isset($datas['content']) && !empty($datas['content'])){
      $datas['content'] = substr($datas['content'],3,-4);
    }
    return array_merge($datas,[
      'modified_at' => date('Y-m-d H:i:s') 
    ]);
  }

  /**
  * Create entity when you insert new item in bdd and add some inital values
  */
  protected function getNewEntity ()
  {
    $chapter = new Chapter();
    $chapter->created_at = date('Y-m-d H:i:s');
    $chapter->books_id = 1;
    $chapter->chapters_order = 9;
  
    return $chapter;
  }

  protected function getHeaderDatas ($action, $element = null)
  {
    $header = parent::getHeaderDatas($action,$element);

    $header->linkName = 'Chapitres'; 
    $header->prefixName = $this->prefixName;

    switch ($action) {
      case 'create':
        $header->subtitle = 'Ajout d\'un nouveau chapitre';
        $header->typePage = 'create';
        break;
      case 'read':
        $header->subtitle = 'Gestion des chapitres du livres';
        $header->btnTxt = 'Ajouter un nouveau chapitre';
        $header->typePage = 'read';
        break;
      case 'update':
        $header->name = $element->name;
        $header->subtitle = 'Modification du chapitre ' . $element->chapters_order ;
        $header->typePage = 'update';
        break;
      
      default:
        $header->subtitle = 'Maitrisez la gestion de vos chapitres';
        break;
    }
    return $header;
  }
}