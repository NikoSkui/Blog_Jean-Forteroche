<?php

namespace App\Blog\controllers;

use App\Models\BookModel;
use App\Models\ChapterModel;
use App\Models\CommentModel;
use App\Helpers\RouterAwareHelper;
use System\Router;
use System\Http\Request;
use System\Renderer\RendererInterface;

class BlogController
{

  private $renderer;

  private $chapterModel;

  private $commentModel;

  use RouterAwareHelper;

  public function __construct(Router $router, RendererInterface $renderer, BookModel $bookModel, ChapterModel $chapterModel, CommentModel $commentModel)
  {

    $this->renderer = $renderer;
    $this->router = $router;

    $this->bookModel = $bookModel;
    $this->chapterModel = $chapterModel;
    $this->commentModel = $commentModel;
  }
   
  public function __invoke (Request $request)
  {
    $id = $request->getAttribute('id');
    $slug = $request->getAttribute('slug');

    if ($id && $slug) {
      return $this->oneChapter($id);
    } elseif ($slug) {
      return $this->listChapters($slug);
    }
     return $this->listBooks($request);
  }

  public function listBooks()
  {
    $books = $this->bookModel->findAll();

    return $this->renderer->render('@blog/listBooks', compact('books'));
  }

  public function listChapters (string $slug)
  {
    $book =  $this->chapterModel->findAll($slug);
    $bookName = key($book);
    $chapters = array_shift($book);

    return $this->renderer->render('@blog/listChapters', compact('chapters','bookName'));
  }
  
  public function OneChapter (int $id)
  {
    $chapter = $this->chapterModel->findOne($id);
    $comments = $this->commentModel->findAll($id);

    return $this->renderer->render('@blog/oneChapter', compact('chapter','comments'));
  }



  // A mettre dans la fonction où créer du faux contenus
  // $faker = \Faker\Factory::create('fr_FR');
  //   $data = [
  //     'pseudo' => $faker->firstName,
  //     'email' => $faker->freeEmail,
  //     'content' =>$faker->realText($faker->numberBetween(90,255)),
  //     'created_at' => $faker->dateTimeThisYear($max = 'now', $timezone = date_default_timezone_get())->format('Y-m-d H:i:s'),
  //     'chapters_id' =>  0,
  //     'parent_id' => $faker->numberBetween($min = 28, $max = 37),
  //   ];
  // r($data);die();
  // $this-> commentModel->create($data);


  // public function paragraphs($nb = 3, $asText = false)
  // {
  // $faker = \Faker\Factory::create('fr_FR');
  
  //   $paragraphs = array();
  //   for ($i=0; $i < $nb; $i++) {
  //     $paragraphs []= $faker->paragraph(3);
  //   }
  //   return $asText ? implode("\n\n", $paragraphs) : $paragraphs;
  // }

}
