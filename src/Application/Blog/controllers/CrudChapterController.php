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
  protected $prefixName = "AdminChapters";


  public function __construct(Router $router, RendererInterface $renderer, ChapterModel $model)
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
        return in_array($key, ['name', 'slug', 'content', 'created_at', 'books_id', 'chapters_order']);
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
    $chapter = new Chapter();
    $chapter->created_at = date('Y-m-d H:i:s');
    $chapter->books_id = 1;
    $chapter->chapters_order = 9;
  
    return $chapter;
  }
}