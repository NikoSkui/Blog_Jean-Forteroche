<?php

namespace App\Blog\entities;

use System\Container\DIContainer;

class Book 
{
  private $container;

  public $id;
  public $name;
  public $slug;
  public $excerpt;
  public $created_at;
  public $modified_at;
  public $status;

  public function __construct(DIContainer $container)
  {
    
    $this->container = $container;

    $this->name = htmlentities($this->name);
    $this->created_at = new \Datetime($this->created_at);
    $this->modified_at = new \Datetime($this->modified_at);

  }

  protected function getUrl($params = [])
  {
    $router = $this->container->get(\System\Router::class);
    $name = 'ouvrir';
    foreach ($params as $param) {
      if(is_array($param) && array_key_exists('slug',$param)) {
        $slug = $param['slug'];
      }
    }
    $uri = $router->generateUri('Front#Chapters#List', ['slugBook' => $this->slug]);
    $html = "<a href=$uri>$name</a>";
    echo $html;
  }
  
  /**
   * Method magique __call
   */
  public function __CALL($key,$params)
  {
    $method = 'get'.ucfirst($key);
    $this->$key = $this->$method($params);
    return $this->$key;
  }

}
