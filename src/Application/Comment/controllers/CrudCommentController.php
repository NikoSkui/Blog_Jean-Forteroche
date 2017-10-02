<?php

namespace App\Comment\controllers;


use App\Comment\models\CommentModel;
use App\Comment\models\ReportModel;
use App\Comment\entities\Comment;

use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;
use System\Controller\CrudController;

class CrudCommentController extends CrudController
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

  public function create (Request $request)
  {
    // Step 1: Recovery only of the desired keys.
    $datas = $this->getParams($request);

    // Step 3: Checks if the comment is a reply.
    if ($datas['parent_id'] !== 0) {
      $commentParent = $this->model->hasParentCommentInChapter($datas['chapters_id'],$datas['parent_id']);   
      // If reply, checks if parent exist in chapter
      if ($commentParent === false) {
        throw new \Exception("The parent comment does not exist");
      }
      // If exist, checks if depth < 2
      if ($commentParent->depth >= 2) {
        throw new \Exception("You can not reply to the comment");
      }
      // If true, update $datas['depth']
      $datas['depth'] = $commentParent->depth + 1;
    }

    // Step 4: Creating the new comment.
    $this->model->create($datas);

    // Step 5: Redirection to the original page.
    return $this->redirect('Front#Chapters#One',[
      'slugBook'       => $request->getAttribute('slugBook'),
      'chapters_order' => $request->getAttribute('chapters_order'),
      'slugChapter'    => $request->getAttribute('slugChapter')
    ]);

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
      $this->model->delete($commentChild);
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
        return in_array($key, ['pseudo', 'content', 'email', 'parent_id']);
      }, ARRAY_FILTER_USE_KEY);

    // Step 2: Definition of some value
    return array_merge($datas,[
      'chapters_id' => $request->getAttribute('id'),
      'parent_id' => isset($datas['parent_id']) && !empty($datas['parent_id']) ? $datas['parent_id'] : 0,
      'depth' => 0
    ]);

  }

  protected function getAdditionnals ()
  {
    $comments = [];
    $datas =  $this->reportModel->findAll();
    foreach ($datas as $id => $reports) {
      $comments[$id] = $this->getNewEntity();
      $comments[$id]->id = $id;
      $comments[$id]->pseudo = htmlentities($reports[0]->pseudo);
      $comments[$id]->content = htmlentities($reports[0]->content);
      $comments[$id]->chapter_name = $reports[0]->chapter_name;
      $comments[$id]->book_name = $reports[0]->book_name;

      // organized datas by report_lvl
      foreach ($reports as $i => $report) {
        $comments[$id]->reports[$report->report_lvl][] = $report;
      }
    }


    foreach ($comments as $id => $comment) {
    // reduce datas array, keep the last entry
      foreach ($comment->reports as $i => $report) {
        $comments[$id]->reports[$i] = array_slice($report, -1,1, true);
      }
    }

    return $comments;


  }

  /**
  * Create entity when you insert new item in bdd and add some inital values
  */
  protected function getNewEntity ()
  {
    $comment = new Comment();
      
    return $comment;
  }

  protected function getHeaderEntity ($action, $element = null)
  {
    $header = parent::getHeaderEntity($action,$element);

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