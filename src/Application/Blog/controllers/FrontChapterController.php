<?php

namespace App\Blog\controllers;

use App\Base\entities\Header;

use App\Blog\models\BookModel;
use App\Blog\models\ChapterModel;

use App\Comment\models\CommentModel;

use App\Libraries\RouterAware;

use System\Router;
use System\Http\Request;
use System\Http\Response;
use System\Renderer\RendererInterface;

class FrontChapterController
{
  /**
   * @var RendererInterface
   */
  private $renderer;

  /**
   * @var Router
   */
  private $router;

  /**
   * @var string
   */
  protected $viewPath = "@blog/front/chapters";

  /**
   * @var string
   */
  protected $prefixNameBooks = "Front#Books";
  protected $prefixNameChapters = "Front#Chapters";

  /**
   * @var ChapterModel
   */
  private $model;

  /**
   * @var BookModel
   */
  private $bookModel;

  /**
   * @var CommentModel
   */
  private $commentModel;

  use RouterAware;

  public function __construct(
    RendererInterface $renderer,
    Router $router,
    ChapterModel $model,
    BookModel $bookModel,
    CommentModel $commentModel) 
  {
    // Idratation 
    $this->renderer = $renderer;
    $this->router = $router;
    $this->model = $model;
    $this->bookModel = $bookModel;
    $this->commentModel = $commentModel;
    $this->renderer->addGlobal('prefixNameBooks', $this->prefixNameBooks);
    $this->renderer->addGlobal('prefixNameChapters', $this->prefixNameChapters);
  }
   
  public function __invoke (Request $request, $next)
  {
    if ($request->getAttribute('slugChapter') ) {
      return $this->oneChapter($request, $next);
    }
     return $this->listChapters($request, $next);
  }
    
  /**
  * READ list of Element 
  */
  public function listChapters (Request $request, $next)
  {
    $book = $this->bookModel->findBy('slug',$request->getAttribute('slugBook'));
    if($book === false) {
      $request = $request->withAttribute('message', 'le livre est introuvable');
      return $next($request);
    }
    $header = $this->getHeaderEntity('readList',$book);
    $elements =  $this->model->findAllWithBook($book->id); 
    $bookName = key($elements);
    $chapters = array_shift($elements);

    return $this->renderer->render($this->viewPath . '/list', compact('header','chapters'));
  }

  /**
  * READ one of Element 
  */
  public function oneChapter (Request $request, $next)
  {
    $book = $this->bookModel->findBy('slug',$request->getAttribute('slugBook'));
    if($book === false) {
      $request = $request->withAttribute('message', 'le livre est introuvable pour ce chapitre');
      return $next($request);
    }
    $chapter = $this->model->findOneWithBook($request->getAttribute('slugChapter'),$book->id);
    if($chapter === false) {
      $request = $request->withAttribute('message', 'le chapitre est introuvable');
      return $next($request);
    }
    $header = $this->getHeaderEntity('readOne',$chapter);
    if($chapter->chapters_order !== $request->getAttribute('chapters_order')) {
      return $this->redirect($this->prefixNameChapters . '#One', [
        'slugBook' => $book->slug,
        'chapters_order' => $chapter->chapters_order,
        'slugChapter' => $chapter->slug]);
    }
    $comments = $this->commentModel->findAllWithChapter($chapter->id);
    $commentsFormAction = [
      'slugBook' => $book->slug,
      'chapters_order' => $chapter->chapters_order,
      'slugChapter' => $chapter->slug,
      'chapter_id' => $chapter->id
    ];

    return $this->renderer->render($this->viewPath . '/one', compact('header','chapter','comments','commentsFormAction'));
  }

  /**
  * Create entity Header 
  */
  private function getHeaderEntity ($action, $element = null)
  {
    $header = new Header();
    switch ($action) {
      case 'readList':
        $header->title = $element->name; 
        $header->subtitle = 'Sommaire';
        $header->typePage = 'readList';
        $header->imgName = $element->slug;
        break;
      case 'readOne':
        $header->title = 'Chapitre ' . $element->chapters_order; 
        $header->subtitle = $element->name;
        $header->typePage = 'readOne';
        break;
      default:
        break;
    }
    return $header;
  }
  
}
