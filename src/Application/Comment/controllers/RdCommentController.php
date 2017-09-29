<?php

namespace App\Comment\controllers;


use App\Models\CommentModel;
use App\Models\ReportModel;
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
  protected $viewPath = "@comment/admin/comments";

  /**
   * @var string
   */
  protected $prefixName = "Admin#Comments";

  /**
   * @var string
   */
  private $reportModel;



  public function __construct(Router $router, RendererInterface $renderer, CommentModel $model, ReportModel $reportModel)
  {
    // Idratation 
    parent::__construct($renderer, $router, $model);
    $this->reportModel = $reportModel;
    $renderer->setLayoutNamespace('admin');
  }

  /**
  * DELETE one element
  */
  public function delete (Request $request)
  { 
    // Step 1: Delete all comments child
    $commentChilds = $this->model->findAllBy('parent_id',$request->getAttribute('id'));
    foreach ($commentChilds as $id) {
      $this->model->delete($id);
    }
    // Step 2: Delete all reports child
    $reportChilds = $this->reportModel->findAllBy('comments_id',$request->getAttribute('id'));
    foreach ($reportChilds as $id) {
      $this->reportModel->delete($id);
    }

    // Step 3: Delete element.
    $this->model->delete($request->getAttribute('id'));

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
        return in_array($key, ['name', 'slug', 'content', 'created_at']);
      }, ARRAY_FILTER_USE_KEY);

    // Step 2: Definition of some value
    return array_merge($datas,[
      'modified_at' => date('Y-m-d H:i:s')
    ]);
  }

  protected function getAdditionnals ()
  {
    $datas =  $this->reportModel->findAll();
    $comments = [];
    foreach ($datas as $id => $reports) {
      $comments[$id] = [
          'id' => $id,
          'pseudo' => $reports[0]->pseudo,
          'content' => $reports[0]->content,
          'chapter_name' => $reports[0]->chapter_name,
          'book_name' => $reports[0]->book_name
      ];
      // organized datas by report_lvl
      foreach ($reports as $i => $report) {
        $comments[$id]['reports'][$report->report_lvl][] = $report;
      }
    }


    foreach ($comments as $id => $comment) {
    // reduce datas array, keep the last entry
      foreach ($comment['reports'] as $i => $report) {
        $comments[$id]['reports'][$i] = array_slice($report, -1,1, true);
      }
    }
    return $comments;


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