<?php

namespace App\Blog\controllers;


use App\Blog\models\ChapterModel;
use App\Blog\entities\Chapter;

use App\Comment\models\CommentModel;
use App\Comment\models\ReportModel;

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

  /**
   * Model need for cascade deleted
   * @var string
   */
  private $commentModel;
  private $reportModel;

  /**
  * CONSTRUCTOR
  */
  public function __construct(
    Router $router,
    RendererInterface $renderer,
    ChapterModel $model,
    CommentModel $commentModel,
    ReportModel $reportModel
  ) {
    // Idratation 
    parent::__construct($renderer, $router, $model);
    $this->commentModel = $commentModel;
    $this->reportModel = $reportModel;
    $renderer->setLayoutNamespace('admin');
  }

  /**
  * DELETE one chapter
  */
  public function delete (Request $request)
  { 
    $chapter = $request->getAttribute('id');

    // Step 1: Find all comments of chapter and delete them
    $chapterComments = $this->commentModel->findAllBy('chapters_id',$chapter);
    foreach ($chapterComments as $comment) {
      // Step 2: Find all reports of comment and delete them
      $commentReports = $this->reportModel->findAllBy('comments_id',$comment);
      foreach ($commentReports as $report) {
        $this->reportModel->delete($report);
      }
      $this->commentModel->delete($comment);
    }

    // Step 3: Delete chapter.
    $this->model->delete($chapter);

    // Step 4: Redirection to the original page.
    return $this->redirect($this->prefixName . '#Read');

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
      $datas['name'] = trim(strip_tags($datas['name']));
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
    $chapter->chapters_order = count($this->model->findAllBy('books_id', $chapter->books_id))+1;
    return $chapter;
  }

  /**
  * Create entity Header 
  */
  protected function getHeaderEntity ($action, $element = null)
  {
    $header = parent::getHeaderEntity($action,$element);

    $header->prefixName = $this->prefixName;

    switch ($action) {
      case 'create':
        $header->subtitle = 'Ajout d\'un nouveau chapitre';
        $header->typePage = 'create';
        break;
      case 'read':
        $header->subtitle = 'Gestion des chapitres du livres';
        $header->callToAction = 'Ajouter un nouveau chapitre';
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