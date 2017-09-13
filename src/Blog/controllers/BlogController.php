<?php

namespace App\Blog\controllers;

use System\Http\Request;
use \System\Renderer\RendererInterface;

class BlogController
{

  private $renderer;


  public function __construct(RendererInterface $renderer)
  {
    $this->renderer = $renderer;
  }
   
  public function __invoke (Request $request)
  {
    $id = $request->getAttribute('id');
    $slug = $request->getAttribute('slug');
    
    if ($id && $slug) {
      return $this->show($slug, $id);
    } elseif ($slug) {
      return $this->shows($slug);
    }
     return $this->index();
  }

  public function index ()
  {
    $faker = \Faker\Factory::create('fr_FR');
    for ($i=0; $i < 17 ; $i++) { 
      $data['posts'][] = [
        'name'    => $faker->catchPhrase,
        'slug'    => $faker->slug,
        'extrait' => $faker->text(100)
      ];
    }
    return $this->renderer->render('@blog/index', $data);
  }

  public function shows (string $slug)
  {
    $faker = \Faker\Factory::create('fr_FR');
    $data = [
      'name'    => $faker->catchPhrase,
      'slug'    => $slug
    ];
    for ($i=0; $i < 5 ; $i++) { 
      $chapitres[] = [
        'id'    => $i + 1,
        'slug'  => $faker->slug,
      ];
    }
    $name = $faker->catchPhrase;
    
    return $this->renderer->render('@blog/shows', compact('name','slug','chapitres'));
  }
  
  public function show (string $slug, int $id)
  {
    $faker = \Faker\Factory::create('fr_FR');
    $datas = [
      'id' => $id,
      'slug' => $slug,
      'content' => $faker->paragraphs($nb = 10, $asText = true) ,
    ];
    
    return $this->renderer->render('@blog/show', $datas);
  }

}
