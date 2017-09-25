<?php

namespace App\Comment\controllers;

use App\Models\CommentModel;
use App\Libraries\RouterAware;
use System\Http\Request;
use System\Router;

class CommentController
{

  private $router;

  private $commentModel;

  use RouterAware;

  public function __construct(Router $router, CommentModel $commentModel)
  {

    $this->router = $router;

    $this->commentModel = $commentModel;
  }
   
  public function __invoke (Request $request)
  {

    if ($request->getAttribute('id')) {
      return $this->postComment($request);
    } 
  }

  


  public function postComment ($request)
  {
    /**
    * Step 1: Recovery only of the desired keys.
    *         Example of injection with keys that you do not want:
    *         $datas['test'] = 'Toto';
    *         $datas["<script>alert('faille')</script>"] = "<script>alert('faille')</script>";
    */
    $datas = array_filter($request->getParsedBody(), function ($key){
      return in_array($key, ['pseudo', 'content', 'email', 'parent_id']);
    }, ARRAY_FILTER_USE_KEY);

    /**
    * Step 2: Definition of some value
    */
    $datas['chapters_id'] = $request->getAttribute('id');
    $datas['parent_id'] = isset($datas['parent_id']) && !empty($datas['parent_id']) ? $datas['parent_id'] : 0;
    $datas['depth'] = 0;

    /**
    * Step 3: Checks if the comment is a reply.
    *         If reply, checks if parent exist in chapter
    *         If exist, checks if depth < 2
    *         If true, update $datas['depth']
    */
    if ($datas['parent_id'] !== 0) {
      $commentParent = $this->commentModel->hasParentCommentInChapter($datas['chapters_id'],$datas['parent_id']);   
      if ($commentParent === false) {
        throw new \Exception("The parent comment does not exist");
      }
      if ($commentParent->depth >= 2) {
        throw new \Exception("You can not reply to the comment");
      }
      $datas['depth'] = $commentParent->depth + 1;
    }

    /**
    * Step 4: Creating the new comment.
    */
    $this->commentModel->create($datas);

    /**
    * Step 5: Redirection to the original page.
    */
    return $this->redirect('FrontChapters#One',[
      'slugBook'       => $request->getAttribute('slugBook'),
      'chapters_order' => $request->getAttribute('chapters_order'),
      'slugChapter'    => $request->getAttribute('slugChapter')
    ]);

  }

}
