<?php

namespace App\Blog\controllers;


use App\Models\BookModel;
use App\Models\ChapterModel;
use App\Models\CommentModel;
use App\Models\ReportModel;
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

  /**
   * Model need for cascade deleted
   * @var string
   */
  private $chapterModel;
  private $commentModel;
  private $reportModel;



  public function __construct(
    Router $router,
    RendererInterface $renderer,
    BookModel $model,
    ChapterModel $chapterModel,
    CommentModel $commentModel,
    ReportModel $reportModel
  ) {
    // Idratation 
    parent::__construct($renderer, $router, $model);
    $this->chapterModel = $chapterModel;
    $this->commentModel = $commentModel;
    $this->reportModel = $reportModel;
    $renderer->setLayoutNamespace('admin');
  }

  /**
  * DELETE one chapter
  */
  public function delete (Request $request)
  { 
    $book = $request->getAttribute('id');

    // Step 1: Find all chapters of book and delete them
    $bookChapters = $this->chapterModel->findAllBy('books_id',$book);
    foreach ($bookChapters as $chapter) {
      // Step 2: Find all comments of chapter and delete them
      $chapterComments = $this->commentModel->findAllBy('chapters_id',$chapter);
      foreach ($chapterComments as $comment) {
        // Step 3: Find all reports of comment and delete them
        $commentReports = $this->reportModel->findAllBy('comments_id',$comment);
        foreach ($commentReports as $report) {
          $this->reportModel->delete($report);
        }
        $this->commentModel->delete($comment);
      }
      $this->chapterModel->delete($chapter);
    }

    // Step 4: Delete book.
    $this->model->delete($book);

    // Step 5: Redirection to the original page.
    return $this->redirect($this->prefixName . '#Read');

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