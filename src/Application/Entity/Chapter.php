<?php

namespace App\Entity;


use System\Http\ServerRequest;

class Chapter extends Entity
{
  public $id;
  public $name;
  public $slug;
  public $content;
  public $created_at;
  public $modified_at;
  public $chapters_order;
  public $books_id;

  public function __construct()
  {
    parent::__construct();

    if($this->name) {
      $this->name = htmlentities($this->name);
    }
    if($this->content) {
     $this->content;
    }
  }

}
