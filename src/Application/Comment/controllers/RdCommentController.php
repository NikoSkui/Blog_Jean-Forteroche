<?php

namespace App\Comment\controllers;


use App\Comment\models\CommentModel;
use App\Comment\models\ReportModel;

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
  * DELETE one comment
  */
  public function delete (Request $request)
  { 
    $comment = $request->getAttribute('id');

    // Step 1 : Find all children of the comment and delete them
    $commentChilds = $this->model->findAllBy('parent_id',$comment);
    foreach ($commentChilds as $commentChild) {
      // Step 1.2 : Find all reports of comments child and delete them
      $commentChildReports = $this->reportModel->findAllBy('comments_id',$commentChild);
      foreach ($commentChildReports as $commentChildReport) {
        $this->reportModel->delete($commentChildReport);
      }
      $this->commentModel->delete($commentChild);
    }
    // Step 2 : Find all reports of comment and delete them
    $commentReports = $this->reportModel->findAllBy('comments_id',$comment);
    foreach ($commentReports as $report) {
      $this->reportModel->delete($report);
    }

    // Step 3 : Delete comment.
    $this->model->delete($comment);

    // Step 4 : Redirection to the original page.
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
          'pseudo' => htmlentities($reports[0]->pseudo),
          'content' => htmlentities($reports[0]->content),
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