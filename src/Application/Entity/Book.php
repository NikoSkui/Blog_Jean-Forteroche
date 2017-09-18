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
      if(is_array($param) && array_key_exists('name',$param)) {
        $name = $param['name'];
      }
    }
    $uri = $this->router->generateUri('Blog#listChapters', ['slug' => $this->slug,'id' => $this->id]);
    $html = "<a href=$uri>$name</a>";
    echo $html;
  }

}
