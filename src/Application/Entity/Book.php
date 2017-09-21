<?php

namespace App\Entity;

use System\Router;

class Book extends Entity
{
  public $id;
  public $name;
  public $slug;
  public $excerpt;
  public $created_at;
  public $modified_at;
  public $status;

  public function __construct(Router $router)
  {
    parent::__construct();
    
    $this->router = $router;

  }

  protected function getUrl($params = [])
  {
    $name = 'ouvrir';
    foreach ($params as $param) {
      if(is_array($param) && array_key_exists('slug',$param)) {
        $slug = $param['slug'];
      }
    }
    $uri = $this->router->generateUri('FrontChapters#List', ['slugBook' => $this->slug]);
    $html = "<a href=$uri>$name</a>";
    echo $html;
  }

}
